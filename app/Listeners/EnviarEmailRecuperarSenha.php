<?php

namespace App\Listeners;

use Illuminate\Mail\Message;
use Mail;

class EnviarEmailRecuperarSenha
{
    /**
     * Handle the event.
     *
     * @param array $data
     * @return void
     */
    public function handle(array $data)
    {

        $email = $data['email'];
        $url = $data['url'];

        Mail::send('emails.recuperar-senha', ['email' => $email, 'url' => $url],
            function(Message $message) use ($email){
                $message->to($email)
                    ->subject('Recuperação de senha - NÂO RESPONDA')
                    ->from('suporte@petlovers.com', 'Suporte PetLovers');
            }
        );
    }
}
