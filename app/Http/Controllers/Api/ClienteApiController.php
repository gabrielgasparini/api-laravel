<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Http\Controllers\MasterApiController;

class ClienteApiController extends MasterApiController
{

    protected $model;
    protected $path = 'clientes';
    protected $upload = 'image';
    public $request;
    public function __construct(Cliente $clientes, Request $request){
        $this->model   = $clientes;
        $this->request = $request;
    }

}
