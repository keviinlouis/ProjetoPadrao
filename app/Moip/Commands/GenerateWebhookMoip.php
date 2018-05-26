<?php

namespace App\Moip\Commands;

use App\Moip\Services\MoipService;
use Illuminate\Console\Command;

/**
 * Class GenerateWebhookMoip
 * @package App\Console\Commands
 */
class GenerateWebhookMoip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moip:webhook {route} {--d} {--type=} ';

    CONST ORDER = 'order';
    CONST PAYMENT = 'payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria e deleta webhooks para moip, use --d para deletar o webhook e --type para criar ';

    private $moipService;

    /**
     * Create a new command instance.
     *
     * @param MoipService $moipService
     */
    public function __construct(MoipService $moipService)
    {
        parent::__construct();
        $this->moipService = $moipService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $route = $this->argument('route');
        if (!\Route::has($route)) {
            $this->error('Essa rota não existe');
            exit;
        }
        $delete = $this->option('d');
        if($delete){
            if($this->moipService->removeWebhook(route($route))){
                $this->info('WebHook deletado com sucesso ');
            }else{
                $this->info('Webhook não encontrado ');
            }
            return;
        }

        $types = explode(',', $this->option('type'));

        if(count($types) <= 0){
            $this->error('Tipo de eventos não pode vir vazio');
            $this->info('Os eventos disponiveis são: ');
            foreach($this->getEventos() as $evento){
                $this->line($evento);
            }
            return;
        }

        $events  = [];
        foreach ($types as $type) {
            switch ($type) {
                case self::ORDER:
                    $events = array_merge($events, $this->orderEvents());
                    break;
                case self::PAYMENT:
                    $events = array_merge($events, $this->paymentEvents());
                    break;
                default:
                    $this->error('Não foi possivel encontrar o evento ' . $type);
                    $this->info('Os eventos disponiveis são: ');
                    foreach($this->getEventos() as $evento){
                        $this->line($evento);
                    }
                    return;
            }
        }

        $response = $this->moipService->createWebhook($events, route($route));
        if($response->getStatusCode() < 200 || $response->getStatusCode() > 400) {
            $this->line('Erro ao criar o webhook');
            \Log::channel('moip')->error($response->getBody());
            return;
        }
        $this->line('Webhook Criado com sucesso');
        return;
    }

    /**
     * @return array
     */
    private function orderEvents()
    {
        $events = [
            'ORDER.*'
        ];

        return $events;

    }

    /**
     * @return array
     */
    private function paymentEvents()
    {
        $events = [
            'PAYMENT.*'
        ];
        return $events;
    }

    /**
     * @return array
     */
    private function getEventos(){
        return [
          self::ORDER,
          self::PAYMENT
        ];
    }
}
