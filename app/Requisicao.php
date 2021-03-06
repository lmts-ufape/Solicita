<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Requisicao extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    //
    protected $fillable = ['aluno_id','data_pedido','hora_pedido'];


    public function perfil(){
        return $this->belongsTo('App\Perfil');
    }

    public function servidor(){
        return $this->belongsTo('App\Servidor');
    }

    public function requisicao_documento(){
        return $this->hasMany('App\Requisicao_documento');
    }

}
