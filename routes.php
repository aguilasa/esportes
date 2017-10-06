<?php

$app->group('/tipo', function () {
    $this->get('', '\App\Controllers\TipoController:list');
    $this->post('', '\App\Controllers\TipoController:create');
    $this->get('/{id:[0-9]+}', '\App\Controllers\TipoController:view');
    $this->put('/{id:[0-9]+}', '\App\Controllers\TipoController:update');
    $this->delete('/{id:[0-9]+}', '\App\Controllers\TipoController:delete');
});

$app->group('/situacao', function () {
    $this->get('', '\App\Controllers\SituacaoController:list');
    $this->post('', '\App\Controllers\SituacaoController:create');
    $this->get('/{id:[0-9]+}', '\App\Controllers\SituacaoController:view');
    $this->put('/{id:[0-9]+}', '\App\Controllers\SituacaoController:update');
    $this->delete('/{id:[0-9]+}', '\App\Controllers\SituacaoController:delete');
});

$app->group('/modalidade', function () {
    $this->get('', '\App\Controllers\ModalidadeController:list');
    $this->post('', '\App\Controllers\ModalidadeController:create');
    $this->get('/{id:[0-9]+}', '\App\Controllers\ModalidadeController:view');
    $this->put('/{id:[0-9]+}', '\App\Controllers\ModalidadeController:update');
    $this->delete('/{id:[0-9]+}', '\App\Controllers\ModalidadeController:delete');
});

$app->group('/time', function () {
    $this->get('', '\App\Controllers\TimeController:list');
    $this->post('', '\App\Controllers\TimeController:create');
    $this->get('/{id:[0-9]+}', '\App\Controllers\TimeController:view');
    $this->put('/{id:[0-9]+}', '\App\Controllers\TimeController:update');
    $this->delete('/{id:[0-9]+}', '\App\Controllers\TimeController:delete');
});

$app->group('/fase', function () {
    $this->get('', '\App\Controllers\FaseController:list');
    $this->post('', '\App\Controllers\FaseController:create');
    $this->get('/{id:[0-9]+}', '\App\Controllers\FaseController:view');
    $this->put('/{id:[0-9]+}', '\App\Controllers\FaseController:update');
    $this->delete('/{id:[0-9]+}', '\App\Controllers\FaseController:delete');
});

$app->group('/teste', function () {
    $this->get('', '\App\Controllers\Teste:list');
    $this->post('', '\App\Controllers\Teste:create');
    $this->get('/{id:[0-9]+}', '\App\Controllers\Teste:view');
    $this->put('/{id:[0-9]+}', '\App\Controllers\Teste:update');
    $this->delete('/{id:[0-9]+}', '\App\Controllers\Teste:delete');
});
