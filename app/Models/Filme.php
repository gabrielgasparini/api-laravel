<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filme extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'capa'
    ];

    public function rules(){
        return [
            'titulo' => 'required',
            'capa' => 'image'
        ];
    }

    public function arquivo($id){
        $data = $this->find($id);
        return $data->capa;
    }

}
