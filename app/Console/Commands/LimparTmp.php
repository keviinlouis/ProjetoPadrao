<?php

namespace App\Console\Commands;

use App\Entities\Anuncio;
use App\Entities\Pagamento;
use App\Entities\Plano;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Mail\Message;
use Mail;

/**
 * Class AtualizarChamados
 * @package App\Console\Commands
 */
class LimparTmp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmp:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpa a pasta tmp';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Storage::exists('public/tmp')? \Storage::delete('public/tmp'):null;
        return;

    }

}