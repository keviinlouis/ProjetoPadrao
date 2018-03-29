<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 29/03/2018
 * Time: 14:06
 */

namespace App\Traits;


use App\Entities\Arquivo;

trait FotoPerfil
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function fotoPerfil()
    {
        return $this->morphOne(Arquivo::class, 'entidade')->where('tipo', 'PERFIL');
    }

    public function getPathFotoPerfil()
    {
        return $this->getPathFiles().'/fotos_perfil';
    }

    public function getFotoPerfilUrlAttribute()
    {
        $foto = $this->fotoPerfil;
        if(!$foto){
            return asset('assets/images/imagem-perfil.jpg');
        }
        return $foto->url;
    }

    public function createOrUpdateFotoPerfil($data)
    {
        if($this->fotoPerfil){
            $this->fotoPerfil->update($data);
            return $this->fotoPerfil;
        }

        return $this->fotoPerfil()->create($data);

    }
}