<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\MasterApiController;
use Illuminate\Http\Request;
use App\Models\Telefone;

class TelefoneApiController extends MasterApiController
{
    protected $model;
    protected $path = '';
    protected $upload = '';
    protected $width = '';
    protected $height = '';

    public $request;
    public function __construct(Telefone $tel, Request $request){
        $this->model   = $tel;
        $this->request = $request;
    }

    public function cliente($id){
        if(!$data = $this->model->with('cliente')->find($id)){
            return response()->json(['error' => 'Nada foi encontrado'], 404);
        } else {
            return response()->json($data, 200);
        }
    }
}
