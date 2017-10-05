<?php
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\Entity\Situacao;

require_once 'Base.php';

/**
 * Controller Situacao
 */
 class SituacaoController extends Base
{
    public function getEntityName() {
        return 'Tipo';
    }

    public function getNewEntity(){
        return new Tipo();
    }

    public function setValues(&$entity, $params) {
        $entity->setNome($params->nome);
    }
 }