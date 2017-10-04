<?php

/**
 * Recurso /Tipo
 */
$app->group('/tipo', function () {
    $this->get('', '\App\Controllers\TipoController:list');
    $this->post('', '\App\Controllers\TipoController:create');
    $this->get('/{id:[0-9]+}', '\App\Controllers\TipoController:view');
    $this->put('/{id:[0-9]+}', '\App\Controllers\TipoController:update');
    $this->delete('/{id:[0-9]+}', '\App\Controllers\TipoController:delete');
});
