<?php
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\Entity\Tipo;

require_once 'Base.php';

/**
 * Controller Tipo
 */
class TipoController extends Base {


    public function getRepositoryPath() {
        return 'App\Models\Entity\Tipo';
    }

    /**
     * Listagem de Tipos
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function list($request, $response, $args) {
        $tiposRepository = $this->getRepository();

        $tipos = $tiposRepository->findAll();
        $return = $response->withJson($tipos, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;        
    }
    
    /**
     * Cria um Tipo
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function create($request, $response, $args) {
        $params = (object) $request->getParams();
        /**
         * Pega o Entity Manager do nosso Container
         */
        $entityManager = $this->container->get('em');
        /**
         * Instância da nossa Entidade preenchida com nossos parametros do post
         */
        $tipo = (new Tipo())->setNome($params->nome);
        
        /**
         * Registra a criação do tipo
         */
        $logger = $this->container->get('logger');
        $logger->info('Tipo Created!', $tipo->getValues());

        /**
         * Persiste a entidade no banco de dados
         */
        $entityManager->persist($tipo);
        $entityManager->flush();
      
        $return = $response->withJson($tipo, 201)
            ->withHeader('Content-type', 'application/json');
        return $return;       
    }

    /**
     * Exibe as informações de um tipo 
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function view($request, $response, $args) {

        $id = (int) $args['id'];

        $entityManager = $this->container->get('em');
        $tiposRepository = $entityManager->getRepository('App\Models\Entity\Tipo');
        $tipo = $tiposRepository->find($id); 

        /**
         * Verifica se existe um livro com a ID informada
         */
        if (!$tipo) {
            $logger = $this->container->get('logger');
            $logger->warning("Tipo {$id} Not Found");
            throw new \Exception("Tipo not Found", 404);
        }    

        $return = $response->withJson($tipo, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;   
    }

    /**
     * Atualiza um tipo
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function update($request, $response, $args) {

        $id = (int) $args['id'];

        /**
         * Encontra o Livro no Banco
         */ 
        $entityManager = $this->container->get('em');
        $tiposRepository = $entityManager->getRepository('App\Models\Entity\Tipo');
        $tipo = $tiposRepository->find($id);   

        /**
         * Verifica se existe um tipo com a ID informada
         */
        if (!$tipo) {
            $logger = $this->container->get('logger');
            $logger->warning("Tipo {$id} Not Found");
            throw new \Exception("Tipo not Found", 404);
        }  

        /**
         * Atualiza e Persiste o Tipo com os parâmetros recebidos no request
         */
        $tipo->setNome($request->getParam('nome'));

        /**
         * Persiste a entidade no banco de dados
         */
        $entityManager->persist($tipo);
        $entityManager->flush();        
        
        $return = $response->withJson($tipo, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;       
    }

    /**
     * Deleta um Livro
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function delete($request, $response, $args) {

        $id = (int) $args['id'];

        /**
         * Encontra o Livro no Banco
         */ 
        $entityManager = $this->container->get('em');
        $tiposRepository = $entityManager->getRepository('App\Models\Entity\Tipo');
        $tipo = $tiposRepository->find($id);   

        /**
         * Verifica se existe um livro com a ID informada
         */
        if (!$tipo) {
            $logger = $this->container->get('logger');
            $logger->warning("Tipo {$id} Not Found");
            throw new \Exception("Tipo not Found", 404);
        }  

        /**
         * Remove a entidade
         */
        $entityManager->remove($tipo);
        $entityManager->flush(); 
        $return = $response->withJson(['msg' => "Deletando o livro {$id}"], 204)
            ->withHeader('Content-type', 'application/json');
        return $return;    
    }
    
}