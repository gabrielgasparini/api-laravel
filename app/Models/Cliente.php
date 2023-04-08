<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Documento;
use App\Models\Telefone;
use App\Models\Filme;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image'
    ];

    public function rules(){
        return [
            'name' => 'required',
            'image' => 'image'
        ];
    }

    public function arquivo($id){
        $data = $this->find($id);
        return $data->image;
    }

    // Relacionamento 1 para 1
    public function documento(){
        return $this->hasOne(Documento::class, 'cliente_id', 'id');
    }

    // Relacionamento N para 1
    public function telefone(){
        return $this->hasMany(Telefone::class, 'cliente_id', 'id');
    }

    // Relacionamento N para N
    public function filmesAlugados(){
        return $this->belongsToMany(Filme::class, 'locacaos');
    }
}
