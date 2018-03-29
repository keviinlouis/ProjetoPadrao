<?php

namespace Tests\Feature;

use App\Entities\Cartao;
use App\Entities\Dono;
use Tests\AttachJwtToken;
use Tests\TestCase;

class CartoesTest extends TestCase
{
    use AttachJwtToken;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_criar_cartao()
    {
        $dono = Dono::inRandomOrder()->first();

        if(!$dono){
            $dono = factory(Dono::class)->states('senha')->create();
        }

        $cartao = factory(Cartao::class)->make()->toArray();
        $cartao['data_nascimento'] = date('d/m/Y');
        $response = $this->loginAsWithJwt($dono)
            ->postJson(route('cartao.store'), $cartao);

        $response->assertJson(['success' => true]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_remover_cartao()
    {
        $dono = Dono::inRandomOrder()->first();

        if(!$dono){
            $dono = factory(Dono::class)->states('senha')->create();
        }

        if($dono->cartoes->isEmpty()){
            $dono->cartoes()->saveMany(factory(Cartao::class, rand(1, 5))->make());
        }
        $response = $this->loginAsWithJwt($dono)
            ->deleteJson(route('cartao.delete', $dono->cartoes()->inRandomOrder()->first()->getKey()));

        $response->assertJson(['success' => true]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_listar_cartoes()
    {
        $dono = Dono::inRandomOrder()->first();

        if(!$dono){
            $dono = factory(Dono::class)->states('senha')->create();
        }

        if($dono->cartoes->isEmpty()){
            $dono->cartoes()->saveMany(factory(Cartao::class, rand(1, 5))->make());
        }

        $response = $this->loginAsWithJwt($dono)
            ->getJson(route('cartao.listagem'));

        $response->assertJson(['success' => true, 'length' => $dono->cartoes()->count()]);
    }
}
