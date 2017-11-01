<?php
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\Entity\Modalidade;

require_once 'Base.php';

class ModalidadeController extends Base
{
    public function getEntityName()
    {
        return 'Modalidade';
    }
 
    public function getNewEntity()
    {
        return new Modalidade();
    }
 
    public function setValues(&$entity, $params)
    {
        $entity->setNome($params->nome);
        $entity->setFutebol($params->futebol);
    }
}
