<?php
namespace App\Controllers;

use App\Models\Entity\Fase as Fase;
use App\Models\Entity\Modalidade as Modalidade;
use App\Models\Entity\Tipo as Tipo;

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
        $modalidade = $repository->find($id);
        return $modalidade;
    }

    private function findTipo($id)
    {
        $repository = $this->getRepositoryByEntity('Tipo');
        $tipo = $repository->find($id);
        return $tipo;
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

    public function generate($request, $response, $args)
    {
        $id = (int) $args['id'];
        $modalidade = $this->findModalidade($id);

        if (!$modalidade) {
            $logger = $this->container->get('logger');
            $logger->warning("Modalidade {$id} Not Found");
            throw new \Exception("Modalidade not Found", 404);
        }

        $sql = 'DELETE App\Models\Entity\Fase f WHERE f.modalidade = ?1';
        $query = $this->getEntityManager()->createQuery($sql)
            ->setParameter(1, $id)
            ->getResult();

        $sql = 'SELECT t FROM App\Models\Entity\Tipo t ORDER BY t.id ASC';

        $tipos = $this->getEntityManager()->createQuery($sql)->getResult();

        $values = array();
        foreach ($tipos as $tipo) {
            $value = $this->getNewEntity();
            $value->setModalidade($modalidade);
            $value->setTipo($tipo);
            $value->setNome($tipo->getNome());
            $this->persist($value);

            array_push($values, $value);
        }

        $return = $response->withJson($values, 201)
            ->withHeader('Content-type', 'application/json');
        return $return;
    }

    public function modalidade($request, $response, $args)
    {
        $id = (int) $args['id'];

        $modalidade = $this->findModalidade($id);

        if (!$modalidade) {
            $logger = $this->container->get('logger');
            $logger->warning("Modalidade {$id} Not Found");
            throw new \Exception("Modalidade not Found", 404);
        }

        $sql = 'SELECT f FROM App\Models\Entity\Fase f WHERE f.modalidade = ?1 ORDER BY f.id ASC';

        $query = $this->getEntityManager()->createQuery($sql)
            ->setParameter(1, $id)
            ->getResult();

        $values = array();
        foreach ($query as $value) {
            $this->unsetProxies($value->modalidade);
            $this->unsetProxies($value->tipo);
            array_push($values, $value);
        }

        $return = $response->withJson($values, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;
    }
}
