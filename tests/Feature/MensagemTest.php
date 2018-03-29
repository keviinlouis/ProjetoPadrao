<?php

namespace Tests\Feature;

use App\Entities\Dono;
use App\Entities\Mensagem;
use Tests\AttachJwtToken;
use Tests\TestCase;
use Faker\Factory as Faker;

class MensagemTest extends TestCase
{
    use AttachJwtToken;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_enviar_mensagem()
    {
        $faker = Faker::create('pt_BR');

        $data = [
            'texto' =>  $faker->realText()
        ];

        $donos = Dono::inRandomOrder()->limit(2)->get();

        if($donos->isEmpty()){
            $donos = factory(Dono::class, 2)->create();
        }
        $response = $this->loginAsWithJwt($donos->first())
            ->postJson(route('dono.mensagem.enviar', $donos->last()->getKey()), $data);

        $response->assertJson(['success' => true]);
    }

    public function test_listar_mensagens()
    {
        $donos = Dono::inRandomOrder()->limit(2)->get();

        if($donos->isEmpty()){
            $donos = factory(Dono::class, 2)->create();
        }
        $response = $this->loginAsWithJwt($donos->first())
            ->getJson(route('dono.mensagem.historico', $donos->last()->getKey()));

        $response->assertJson(['success' => true]);

    }
}
