<?php
namespace App\Controllers;

use \Datetime;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\Entity\Person;
use App\Models\Entity\Company;
use App\Models\Entity\Job;

class Teste
{
    protected $container;
     
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getRepositoryPath()
    {
        return 'App\\Models\\Entity\\Job';
    }

    public function getEntityManager()
    {
        return $this->container->get('em');
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
       /* $em = $this->getEntityManager();
        $person = new Person();
        $person->setName('Jasper N. Brouwer');
        $em->persist($person);
        
        $company = new Company();
        $company->setName('Future500 B.V.');
        $em->persist($company);
        
        $em->flush();

        $person = $em->find('App\\Models\\Entity\\Person', 1);
        $company = $em->find('App\\Models\\Entity\\Company', 1);
        
        $job = new Job();
        $job->setPerson($person)
            ->setCompany($company)
            ->setStartedOn(new DateTime('01-10-2009'))
            ->setMonthlySalary(10000);
        $em->persist($job);
        
        $em->flush();*/

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

        $return = $response->withJson($value, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;
    }

    public function delete($request, $response, $args)
    {
        $id = (int) $args['id'];
        $value = $this->find($id);

        if (!$value) {
            $entName = $this->getEntityName();
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

    public function getEntityName() {
		return 'Job';
	}
	
    public function setValues(&$entity, $params)
    {
        $modalidade = $this->findModalidade($params->modalidade["id"]);

        if (!$modalidade) {
            $logger = $this->container->get('logger');
            $logger->warning("Modalidade {$id} Not Found");
            throw new \Exception("Modalidade not Found", 404);
        }
        
        $entity->setNome($params->nome);
        $entity->setModalidade($modalidade);
    }
	
    public function getNewEntity() {
		return new Job();
	}
}
