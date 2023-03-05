<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as ImageUp;

class MasterApiController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // GET ALL
    public function index(){
        if(!$data = $this->model->all()){
            return response()->json(['error' => 'Nada foi encontrado'], 404);
        } else {
            return response()->json($data);
        }
    }

    // INSERT
    public function store(Request $request)
    {
        $request->validate($this->model->rules());
        $dataForm = $request->all();
        if($request->hasFile($this->upload) && $request->file($this->upload)->isValid()){
            $extension = $request->file($this->upload)->extension();
            $name = uniqid(date('His'));
            $nameFile = "{$name}.{$extension}";
            $upload = ImageUp::make($dataForm[$this->upload])->resize(177, 236)->save(storage_path("app/public/{$this->path}/{$nameFile}", 70));
            if(!$upload){
                return response()->json(['error' => 'Falha ao fazer upload'], 500);
            }else{
                $dataForm[$this->upload] = $nameFile;
            }
        }
        $data = $this->model->create($dataForm);
        return response()->json($data, 201);
    }

    // GET UNIQUE
    public function show($id) {
        if(!$data = $this->model->find($id)){
            return response()->json(['error' => 'Nada foi encontrado'], 404);
        } else {
            return response()->json($data, 200);
        }
    }

    // UPDATE
    public function update(Request $request, $id) {
        if(!$data = $this->model->find($id)){
            return response()->json(['error' => 'Nada foi encontrado'], 404);
        }
        $request->validate($this->model->rules());
        $dataForm = $request->all();
        if($request->hasFile($this->upload) && $request->file($this->upload)->isValid()){
            $arquivo = $this->model->arquivo($id);
            if($arquivo){
                Storage::disk('public')->delete("/{$this->path}/$data->image");
            }
            $extension = $request->file($this->upload)->extension();
            $name = uniqid(date('His'));
            $nameFile = "{$name}.{$extension}";
            $upload = ImageUp::make($dataForm[$this->upload])->resize(177, 236)->save(storage_path("app/public/{$this->path}/{$nameFile}", 70));
            if(!$upload){
                return response()->json(['error' => 'Falha ao fazer upload'], 500);
            }else{
                $dataForm[$this->upload] = $nameFile;
            }
        }
        $data->update($dataForm);
        return response()->json($data);
    }

    // DELETE
    public function destroy($id) {
        if($data = $this->model->find($id)){
            if(method_exists($this->model, 'arquivo')){
                Storage::disk('public')->delete("/{$this->path}/{$this->model->arquivo($id)}");
            }
            $data->delete();
            return response()->json(['sucess' => 'Deletado com sucesso'], 202);
        }else{
            return response()->json(['error' => 'Nada foi encontrado'], 404);
        }
    }
}
