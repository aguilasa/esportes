<?php
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\Entity\Tipo;

require_once 'Base.php';

class TipoController extends Base
{

    public function getRepositoryPath()
    {
        return 'App\Models\Entity\Tipo';
    }

    public function getEntityName() {
        return 'Tipo';
    }

    public function create($request, $response, $args)
    {
        $params = (object) $request->getParams();
        $value = (new Tipo())->setNome($params->nome);

        $logger = $this->container->get('logger');
        $logger->info('Tipo Created!', $value->getValues());

        $this->persist($value);
      
        $return = $response->withJson($value, 201)
            ->withHeader('Content-type', 'application/json');
        return $return;
    }

    public function view($request, $response, $args)
    {
        $id = (int) $args['id'];
        $value = $this->find($id);

        if (!$value) {
            $logger = $this->container->get('logger');
            $logger->warning("Tipo {$id} Not Found");
            throw new \Exception("Tipo not Found", 404);
        }

        $return = $response->withJson($value, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;
    }

    public function update($request, $response, $args)
    {
        $id = (int) $args['id'];
        $value = $this->find($id);

        if (!$value) {
            $logger = $this->container->get('logger');
            $logger->warning("Tipo {$id} Not Found");
            throw new \Exception("Tipo not Found", 404);
        }

        $value->setNome($request->getParam('nome'));
        $this->persist($value);
        
        $return = $response->withJson($value, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;
    }

    public function delete($request, $response, $args)
    {
        $id = (int) $args['id'];
        $value = $this->find($id);

        if (!$value) {
            $logger = $this->container->get('logger');
            $logger->warning("Tipo {$id} Not Found");
            throw new \Exception("Tipo not Found", 404);
        }

        $this->remove($value);
        $return = $response->withJson(['msg' => "Deletando o tipo {$id}"], 204)
            ->withHeader('Content-type', 'application/json');
        return $return;
    }
}
