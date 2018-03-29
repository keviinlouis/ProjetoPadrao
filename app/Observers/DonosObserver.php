<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 02/03/2018
 * Time: 18:45
 */

namespace App\Observers;

use App\Entities\Dono;
use Illuminate\Mail\Message;

class DonosObserver
{

    /**
     * @param Dono $dono
     */
    public function created(Dono $dono)
    {
        \Mail::send('emails.bem-vindo', get_defined_vars(), function(Message $message) use ($dono){
            $message->to($dono->email)
                ->from('suporte@petlovers.com', 'Suporte PetLovers')
                ->subject('Bem vindo ao PetLovers');
        });
    }

}