<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Mail\Message;
use Mail;

/**
 * Class AtualizarChamados
 * @package App\Console\Commands
 */
class SendEmailTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teste:email {view}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia um email de teste para a view passada';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Mail::send('emails.' . $this->argument('view'), [], function (Message $message) {
            $message->to('keviinlouiis@gmail.com')
                ->subject('Teste')
                ->from('teste@teste.com', 'Teste');
        });
    }
}