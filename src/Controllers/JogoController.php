<?php
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\Entity\Jogo;
use App\Models\Entity\Fase;
use App\Models\Entity\Time;
use App\Models\Entity\Situacao;
use App\Models\Entity\Modalidade;

require_once 'Base.php';

class JogoController extends Base
{
    const esperado = array(0, 4, 2, 1, 1);

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

    private function findTime($id)
    {
        $repository = $this->getRepositoryByEntity('Time');
        $time = $repository->find($id);
        return $time;
    }

    private function findSituacao($id)
    {
        $repository = $this->getRepositoryByEntity('Situacao');
        $situacao = $repository->find($id);
        return $situacao;
    }

    private function findModalidade($id)
    {
        $repository = $this->getRepositoryByEntity('Modalidade');
        $modalidade = $repository->find($id);
        return $modalidade;
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

    private function checarJogosTipo($tipo, $total)
    {
        if (($tipo == 1 && $total != 4) || ($tipo == 2 && $total != 2) || ($tipo == 3 && $total != 1) || ($tipo == 4 && $total != 1)) {
            $esperado = self::esperado[$tipo];
            throw new \Exception(\sprintf('Erro na quantidade de jogos. Esperado: %d, encontrado: %d', $esperado, $total), 404);
        }
    }

    private function getOrdem($tipo)
    {
        switch ($tipo) {
            case 1:
                return 1;
            case 2:
                return 5;
            case 3:
                return 7;
            case 4:
                return 8;
        }
    }

    private function geraJogosPrimeiraFase($fase, $params, &$values)
    {
        $tipo = $fase->tipo->id;
        $total = count($params);

        $this->checarJogosTipo($tipo, $total);
        $ordem = $this->getOrdem($tipo);
        
        for ($i = 0; $i < $total; $i++) {
            $value = (object) $params[$i];
            $jogo = $this->getNewEntity();

            $idTime1 = $value->time1["id"];
            $time1 = $this->findTime($idTime1);
            if (!$time1) {
                $logger = $this->container->get('logger');
                $logger->warning("Time 1 {$idTime1} Not Found");
                throw new \Exception("Time 1 not Found", 404);
            }

            $idTime2 = $value->time2["id"];
            $time2 = $this->findTime($idTime2);
            if (!$time2) {
                $logger = $this->container->get('logger');
                $logger->warning("Time 2 {$idTime2} Not Found");
                throw new \Exception("Time 2 not Found", 404);
            }

            $idSituacao = $value->situacao["id"];
            $situacao = $this->findSituacao($idSituacao);
            if (!$situacao) {
                $logger = $this->container->get('logger');
                $logger->warning("Situação {$idSituacao} Not Found");
                throw new \Exception("Situação not Found", 404);
            }

            $jogo->setFase($fase)
                 ->setTime1($time1)
                 ->setTime2($time2)
                 ->setSituacao($situacao)
                 ->setOrdem($ordem)
                 ->setPlacar1(0)
                 ->setPenalti1(0)
                 ->setPlacar2(0)
                 ->setPenalti2(0);

            $this->persist($jogo);
            array_push($values, $jogo);
            $ordem++;
        }
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

        $values = array();

        $this->transaction();
        try {
            $this->deleteQuery('DELETE App\Models\Entity\Jogo j WHERE j.fase IN (SELECT f.id FROM App\Models\Entity\Fase f WHERE f.modalidade = ?1)', $modalidade->id);

            $sql = 'SELECT f FROM App\Models\Entity\Fase f WHERE f.modalidade = ?1 ORDER BY f.id ASC';
            
            $query = (array) $this->getEntityManager()->createQuery($sql)
                                  ->setParameter(1, $id)
                                  ->getResult();
            
            $fase = array_shift($query);
            $params = (array) $request->getParams();
            $this->geraJogosPrimeiraFase($fase, $params, $values);

            $this->commit();
        } catch (Exception $e) {
            $this->rollBack();
            throw $e;
        }

        $return = $response->withJson($values, 201)
            ->withHeader('Content-type', 'application/json');
        return $return;
    }
}
