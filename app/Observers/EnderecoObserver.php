<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 25/05/2018
 * Time: 22:51
 */

namespace App\Observers;


use App\Entities\Endereco;

class EnderecoObserver
{
    /**
     * @param Endereco $endereco
     */
    public function saved(Endereco $endereco)
    {
        $endereco->loadLatLong();
    }
}
