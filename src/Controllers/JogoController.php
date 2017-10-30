<?php
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\Entity\Jogo;
use App\Models\Entity\Fase;
use App\Models\Entity\Time;
use App\Models\Entity\Situacao;

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
        $esperado = 0;

        if ($tipo == 1 && $total != 4) {
            $esperado = 4;
        } elseif ($tipo == 2 && $total != 2) {
            $esperado = 2;
        } elseif ($tipo == 3 && $total != 1) {
            $esperado = 1;
        } elseif ($tipo == 4 && $total != 1) {
            $esperado = 1;
        }

        $erro = $esperado > 0;

        if ($erro) {
            throw new \Exception(\sprintf('Erro na quantidade de jogos. Esperado: %d, encontrado: %d', $esperado, $total), 404);
        }
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

        $values = array();

        $this->transaction();
        try {
            $this->deleteQuery('DELETE App\Models\Entity\Jogo j WHERE j.fase = ?1', $id);
                
            $params = (array) $request->getParams();
            $tipo = $fase->getTipo()->getId();
            $total = count($params);

            $this->checarJogosTipo($tipo, $total);
            
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
                 ->setOrdem($i + 1)
                 ->setPlacar1(0)
                 ->setPenalti1(0)
                 ->setPlacar2(0)
                 ->setPenalti2(0);

                $this->persist($jogo);
                array_push($values, $jogo);
            }
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
