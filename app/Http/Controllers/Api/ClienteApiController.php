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
    protected $width = 177;
    protected $height = 236;

    public $request;
    public function __construct(Cliente $clientes, Request $request){
        $this->model   = $clientes;
        $this->request = $request;
    }

    // Relacionamento 1 para 1
    public function documento($id){
        if(!$data = $this->model->with('documento')->find($id)){
            return response()->json(['error' => 'Nada foi encontrado'], 404);
        } else {
            return response()->json($data, 200);
        }
    }

    // Relacionamento N para 1
    public function telefone($id){
        if(!$data = $this->model->with('telefone')->find($id)){
            return response()->json(['error' => 'Nada foi encontrado'], 404);
        } else {
            return response()->json($data, 200);
        }
    }

    // Relacionamento N para N
    public function alugados($id){
        if(!$data = $this->model->with('filmesAlugados')->find($id)){
            return response()->json(['error' => 'Nada foi encontrado'], 404);
        } else {
            return response()->json($data, 200);
        }
    }

}
