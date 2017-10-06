<?php
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\Entity\Time;

require_once 'Base.php';


class TimeController extends Base
{
    public function getEntityName()
    {
        return 'Time';
    }
  
    public function getNewEntity()
    {
        return new Time();
    }
  
    public function setValues(&$entity, $params)
    {
        $entity->setNome($params->nome);
    }
}
