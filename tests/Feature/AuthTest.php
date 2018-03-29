<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Entities\Dono;
use Tests\UploadFileTrait;

class AuthTest extends TestCase
{
    use UploadFileTrait;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_cadastro_com_senha()
    {
        $dono = factory(Dono::class)->states('senha')->make()->toArray();

        $dono['senha_confirmation'] = $dono['senha'];

        $dono['data_nascimento'] = date('d/m/Y');
        $dono['path_perfil'] = $this->uploadFakerTmp(true);
        $response = $this->postJson(
            route('dono.cadastro'),
            $dono
        );
        $response->assertStatus(201)
            ->assertJson(['success' => true])
            ->assertJsonStructure(['success', 'data', 'token']);
    }

    public function test_cadastro_com_facebook()
    {
        $dono = factory(Dono::class)->states('senha')->make()->toArray();

        if (isset($dono['senha'])) {
            unset($dono['senha']);
            $dono['facebook_id'] = str_random(15);
        }

        $dono['data_nascimento'] = date('d/m/Y');
        $dono['path_perfil'] = $this->uploadFakerTmp(true);

        $response = $this->postJson(
            route('dono.cadastro'),
            $dono
        );
        $response->assertStatus(201)
            ->assertJson(['success' => true])
            ->assertJsonStructure(['success', 'data', 'token']);
    }

    public function test_login_com_senha()
    {
        $dono = Dono::whereNotNull('senha')->whereNull('facebook_id')->inRandomOrder()->first();
        if (!$dono) {
            $dono = factory(Dono::class)->states('senha')->create();
        }
        while($dono->facebook_id || !\Hash::check('123456', $dono->senha)){
            $dono = Dono::whereNotNull('senha')->whereNull('facebook_id')->inRandomOrder()->first();
            if (!$dono) {
                $dono = factory(Dono::class)->states('senha')->create();
            }
        }
        $data = ['email' => $dono->email, 'senha' => '123456'];
        $response = $this->postJson(
            route('dono.login'),
            $data
        );
        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure(['success', 'data', 'token']);
    }

    public function test_login_com_facebook()
    {
        $dono = Dono::whereNotNull('facebook_id')->inRandomOrder()->first();
        if (!$dono) {
            $dono = factory(Dono::class)->states('facebook')->create();
        }
        $data = ['facebook_id' => $dono->facebook_id];
        $response = $this->postJson(
            route('dono.login'),
            $data
        );
        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure(['success', 'data', 'token']);
    }

    public function test_redefinir_a_senha()
    {
        $dono = Dono::whereNotNull('senha')->inRandomOrder()->first();
        if (!$dono) {
            $dono = factory(Dono::class)->states('senha')->create();
        }
        $data = ['email' => $dono->email];
        $response = $this->postJson(
            route('dono.api.redefinir-senha'),
            $data
        );
        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }
}
