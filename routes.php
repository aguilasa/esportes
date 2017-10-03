<?php

/**
 * Recurso /Tipo
 */
$app->group('/tipo', function () {
    $this->get('', '\App\Controllers\TipoController:listTipo');
    $this->post('', '\App\Controllers\TipoController:createTipo');
    
    /**
     * Validando se tem um integer no final da URL
     */
    $this->get('/{id:[0-9]+}', '\App\Controllers\TipoController:viewTipo');
    $this->put('/{id:[0-9]+}', '\App\Controllers\TipoController:updateTipo');
    $this->delete('/{id:[0-9]+}', '\App\Controllers\TipoController:deleteTipo');
});
