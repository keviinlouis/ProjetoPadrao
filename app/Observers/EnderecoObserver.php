<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 25/05/2018
 * Time: 22:51
 */

namespace App\Observers;


use App\Entities\Endereco;

class EnderecoObserver extends Observer
{
    public function saving(Endereco $endereco)
    {
        if($endereco->hasLatLong() && !$endereco->hasDadosEnderecos()){
            $endereco->updateEnderecoByLatLong();
        }
    }
    /**
     * @param Endereco $endereco
     */
    public function saved(Endereco $endereco)
    {
        if(!$endereco->hasLatLong() || $this->isNotEqual(['cep', 'rua', 'numero', 'cidade', 'estado', 'bairro'], $endereco)){
            $endereco->loadLatLong();
        }
    }
}
