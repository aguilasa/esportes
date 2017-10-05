<?php
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\Entity\Tipo;

require_once 'Base.php';

class TipoController extends Base
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
