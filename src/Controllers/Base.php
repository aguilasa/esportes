<?php
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

abstract class Base
{
    protected $container;
     
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getRepositoryPath()
    {
        return 'App\\Models\\Entity\\' . $this->getEntityName();
    }

    public function getSerializer()
    {
        return $this->container->get('serializer');
    }

    public function getEntityManager()
    {
        return $this->container->get('em');
    }

    public function transaction() {
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
    }

    public function commit() {
        $em->getConnection()->commit();
    }

    public function rollback() {
        $em->getConnection()->rollBack();
    }

    public function getRepository()
    {
        return $this->getEntityManager()->getRepository($this->getRepositoryPath());
    }

    public function getRepositoryByEntity($name)
    {
        return $this->getEntityManager()->getRepository('App\\Models\\Entity\\' . $name);
    }

    public function find($id)
    {
        return $this->getRepository()->find($id);
    }

    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    public function persist($value)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($value);
        $entityManager->flush();
    }

    public function remove($value)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($value);
        $entityManager->flush();
    }

    public function list($request, $response, $args)
    {
        $all = $this->findAll();
        $return = $response->withJson($all, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;
    }

    public function view($request, $response, $args)
    {
        $id = (int) $args['id'];
        $value = $this->find($id);

        if (!$value) {
            $entName = $this->getEntityName();
            $logger = $this->container->get('logger');
            $logger->warning("{$entName} {$id} Not Found");
            throw new \Exception("{$entName} not Found", 404);
        }

        $value = $this->getSerializer()->serialize($value, 'json');
        $response->getBody()->write($value);
        $return = $response->withStatus(200)->withHeader('Content-type', 'application/json');
        return $return;
    }

    public function delete($request, $response, $args)
    {
        $id = (int) $args['id'];
        $value = $this->find($id);

        $entName = $this->getEntityName();
        if (!$value) {
            $logger = $this->container->get('logger');
            $logger->warning("{$entName} {$id} Not Found");
            throw new \Exception("{$entName} not Found", 404);
        }

        $this->remove($value);
        $return = $response->withJson(['msg' => "Deletando o {$entName} {$id}"], 204)
            ->withHeader('Content-type', 'application/json');
        return $return;
    }

    public function create($request, $response, $args)
    {
        $params = (object) $request->getParams();
        $value = $this->getNewEntity();

        $this->setValues($value, $params);

        $entName = $this->getEntityName();
        $logger = $this->container->get('logger');
        $logger->info('{$entName} Created!', $value->getValues());

        $this->persist($value);
      
        $return = $response->withJson($value, 201)
            ->withHeader('Content-type', 'application/json');
        return $return;
    }

    public function update($request, $response, $args)
    {
        $id = (int) $args['id'];
        $params = (object) $request->getParams();
        $value = $this->find($id);

        if (!$value) {
            $entName = $this->getEntityName();
            $logger = $this->container->get('logger');
            $logger->warning("{$entName} {$id} Not Found");
            throw new \Exception("{$entName} not Found", 404);
        }

        $this->setValues($value, $params);
        $this->persist($value);
        
        $return = $response->withJson($value, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;
    }

    protected function deleteQuery($sql, $id)
    {
        $query = $this->getEntityManager()->createQuery($sql)
            ->setParameter(1, $id)
            ->getResult();
    }

    abstract public function getEntityName();
    abstract public function setValues(&$entity, $params);
    abstract public function getNewEntity();
}
