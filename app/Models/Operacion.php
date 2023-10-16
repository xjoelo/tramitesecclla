<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operacion extends Model
{
    use HasFactory;
    
    protected $appends = ['forma_documento'];

    public function origenOficina()
    {
        return $this->belongsTo(Dependencia::class,'idDependencia');
    }
    public function origenUsuario()
    {
        return $this->belongsTo(User::class,'iduser');
    }
    public function derivadoOficina()
    {
        return $this->belongsTo(Dependencia::class,'idDependenciaDestino');
    }
    public function derivadoUsuario()
    {
        return $this->belongsTo(User::class,'iduserDestino');
    }
    public function archivador()
    {
        return $this->belongsTo(Archivador::class,'idArchivado');
    }
    public function documento()
    {
    	return $this->belongsTo(Documento::class,'idDocumento');
    }
    public function getFormaDocumentoAttribute()
    {
        $forma = [0 => 'ORIGINAL',1 => 'ORIGINAL',2 => 'COPIA' ,3 =>'DIGITAL'];
        return $forma[$this->forma];
    }
}
