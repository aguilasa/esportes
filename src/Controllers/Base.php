<?php
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

abstract class Base
{
    /**
     * Container Class
     * @var [object]
     */
    protected $container;
     
    /**
     * Undocumented function
     * @param [object] $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getRepository() {
        return $this->container->get('em')->getRepository($this->getRepositoryPath());
    }

    abstract public function list($request, $response, $args);
    abstract public function create($request, $response, $args);
    abstract public function view($request, $response, $args);
    abstract public function update($request, $response, $args);
    abstract public function delete($request, $response, $args);
    abstract public function getRepositoryPath();
}
