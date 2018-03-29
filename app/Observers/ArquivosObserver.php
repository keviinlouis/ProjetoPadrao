<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 02/03/2018
 * Time: 18:45
 */

namespace App\Observers;

use App\Entities\Arquivo;

class ArquivosObserver
{

    /**
     * @param Arquivo $arquivo
     */
    public function deleted(Arquivo $arquivo)
    {
//        $arquivo->removeFile();
    }

}