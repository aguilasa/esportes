<?php
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\Entity\Jogo;
use App\Models\Entity\Fase;

require_once 'Base.php';

class JogoController extends Base
{
    public function getEntityName()
    {
        return 'Jogo';
    }
  
    public function getNewEntity()
    {
        return new Jogo();
    }
  
    public function setValues(&$entity, $params)
    {
        $entity->setNome($params->nome);
    }

    private function findFase($id)
    {
        $repository = $this->getRepositoryByEntity('Fase');
        $fase = $repository->find($id);
        return $fase;
    }

    public function fase($request, $response, $args)
    {
        $id = (int) $args['id'];

        $fase = $this->findFase($id);

        if (!$fase) {
            $logger = $this->container->get('logger');
            $logger->warning("Fase {$id} Not Found");
            throw new \Exception("Fase not Found", 404);
        }

        $sql = 'SELECT j FROM App\Models\Entity\Jogo j WHERE j.fase = ?1 ORDER BY j.ordem ASC';

        $query = $this->getEntityManager()->createQuery($sql)
            ->setParameter(1, $id)
            ->getResult();

        $values = array();
        foreach ($query as $value) {
            array_push($values, $value);
        }

        $values = $this->getSerializer()->serialize($values, 'json');
        $response->getBody()->write($values);
        $return = $response->withStatus(200)->withHeader('Content-type', 'application/json');
        return $return;
    }

    public function writeFase($request, $response, $args)
    {
        $id = (int) $args['id'];
        $fase = $this->findFase($id);
        
        if (!$fase) {
            $logger = $this->container->get('logger');
            $logger->warning("Fase {$id} Not Found");
            throw new \Exception("Fase not Found", 404);
        }
                
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
}
