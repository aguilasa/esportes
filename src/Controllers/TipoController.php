<?php
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\Entity\Tipo;

require_once 'Base.php';

class TipoController extends Base {

    public function getRepositoryPath() {
        return 'App\Models\Entity\Tipo';
    }

    public function list($request, $response, $args) {
        $tiposRepository = $this->getRepository();

        $tipos = $tiposRepository->findAll();
        $return = $response->withJson($tipos, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;        
    }
    
    public function create($request, $response, $args) {
        $params = (object) $request->getParams();

        $entityManager = $this->container->get('em');

        $tipo = (new Tipo())->setNome($params->nome);
        

        $logger = $this->container->get('logger');
        $logger->info('Tipo Created!', $tipo->getValues());

        $entityManager->persist($tipo);
        $entityManager->flush();
      
        $return = $response->withJson($tipo, 201)
            ->withHeader('Content-type', 'application/json');
        return $return;       
    }

    public function view($request, $response, $args) {

        $id = (int) $args['id'];

        $tiposRepository = $this->getRepository();
        $tipo = $tiposRepository->find($id); 

        if (!$tipo) {
            $logger = $this->container->get('logger');
            $logger->warning("Tipo {$id} Not Found");
            throw new \Exception("Tipo not Found", 404);
        }    

        $return = $response->withJson($tipo, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;   
    }

    public function update($request, $response, $args) {

        $id = (int) $args['id'];

        $entityManager = $this->container->get('em');
        $tiposRepository = $this->getRepository();
        $tipo = $tiposRepository->find($id);   

        if (!$tipo) {
            $logger = $this->container->get('logger');
            $logger->warning("Tipo {$id} Not Found");
            throw new \Exception("Tipo not Found", 404);
        }  

        $tipo->setNome($request->getParam('nome'));

        $entityManager->persist($tipo);
        $entityManager->flush();        
        
        $return = $response->withJson($tipo, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;       
    }

    public function delete($request, $response, $args) {

        $id = (int) $args['id'];

        $entityManager = $this->container->get('em');
        $tiposRepository = $this->getRepository();
        $tipo = $tiposRepository->find($id);   

        if (!$tipo) {
            $logger = $this->container->get('logger');
            $logger->warning("Tipo {$id} Not Found");
            throw new \Exception("Tipo not Found", 404);
        }  

        $entityManager->remove($tipo);
        $entityManager->flush(); 
        $return = $response->withJson(['msg' => "Deletando o livro {$id}"], 204)
            ->withHeader('Content-type', 'application/json');
        return $return;    
    }
    
}