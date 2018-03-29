<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 02/03/2018
 * Time: 18:45
 */

namespace App\Observers;

use App\Entities\Mensagem;
use FCM;
use Illuminate\Http\Response;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class MensagensObserver
{

    /**
     * @param Mensagem $mensagem
     */
    public function created(Mensagem $mensagem)
    {
        $destinatario = $mensagem->destinatario;
        if(!$destinatario->hasdevice()){
            \Log::channel('notifications')->error(
                'Erro ao mandar o push notification para o destinatario '.$destinatario->getKey().PHP_EOL.
                'Exception: Destinatario não possui device'.PHP_EOL.
                'Code: 400'
            );
            return;
        }

        try {
            $optionBuilder = new OptionsBuilder();
            $optionBuilder->setPriority('high');
            if($destinatario->device_model != 'android'){
                $notificationBuilder = new PayloadNotificationBuilder('Você recebeu uma nova mensagem');
                $notificationBuilder->setBody($mensagem->texto)
                    ->setClickAction('message');

            }else{
                $notificationBuilder = null;
            }

            $dataBuilder = new PayloadDataBuilder();

            $dataBuilder->addData([
                'title' => 'Você recebeu uma nova mensagem',
                'body' => $mensagem->texto,
                'icon' => $mensagem->remetente->foto_perfil_url,
                'tipo' => 'message',
                'remetente_id' => $mensagem->remetente->getKey(),
                'remetente_nome' => $mensagem->remetente->nome,
                'mensagem_texto' =>  $mensagem->texto,
                'mensagem_id' => $mensagem->getKey()
            ]);

            $notification = !$notificationBuilder?null:$notificationBuilder->build();
            $data = $dataBuilder->build();
            $option = $optionBuilder->build();

            $downstreamResponse = FCM::sendTo($destinatario->device_token, $option, $notification, $data);

            if($downstreamResponse->numberFailure()>0){
               throw new \Exception('O envio falhou', Response::HTTP_INTERNAL_SERVER_ERROR);

            }
            \Log::channel('notifications')->info(
                'Push notification enviado com sucesso para '.$destinatario->getKey().PHP_EOL.
                'Mensagem: '.$mensagem->texto.PHP_EOL.
                'Mensagem ID: '.$mensagem->getKey()
            );
        } catch (\Exception $e) {
            \Log::channel('notifications')->error(
                'Erro ao mandar o push notification para o destinatario '.$destinatario->getKey().PHP_EOL.
                'Exception: '.$e->getMessage().PHP_EOL.
                'Code: '.$e->getCode()
            );
        }

    }

    public function retrieved(Mensagem $mensagem)
    {
        if(auth()->user()->isDono() && auth()->id() == $mensagem->destinatario->getKey()){
            $mensagem->aberto = 1;
            $mensagem->save();

        }
    }

}