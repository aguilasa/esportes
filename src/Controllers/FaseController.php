<?php
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\Entity\Fase;
use App\Models\Entity\Modalidade as Modalidade;
use App\Models\Entity\Tipo;

require_once 'Base.php';

class FaseController extends Base
{
    public function getEntityName()
    {
        return 'Fase';
    }

    public function getNewEntity()
    {
        return new Fase();
    }

    private function findModalidade($id)
    {
        $repository = $this->getRepositoryByEntity('Modalidade');
        $modalidade = new Modalidade();
        $object = $repository->find($id);
        $modalidade->id = $object->getId();
        $modalidade->setNome($object->getNome());
        return $modalidade;
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
}
