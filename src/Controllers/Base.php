<?php
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

abstract class Base
{
    /**
     * Container Class
     * @var [object]
     */
    protected $container;
     
    /**
     * Undocumented function
     * @param [object] $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getEntityManager()
    {
        return $this->container->get('em');
    }

    public function getRepository()
    {
        return $this->getEntityManager()->getRepository($this->getRepositoryPath());
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

    abstract public function getEntityName();
    abstract public function create($request, $response, $args);
    abstract public function view($request, $response, $args);
    abstract public function update($request, $response, $args);
    abstract public function delete($request, $response, $args);
    abstract public function getRepositoryPath();
}
