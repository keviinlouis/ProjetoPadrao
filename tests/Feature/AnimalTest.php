<?php

namespace Tests\Feature;

use App\Entities\AnimaisCategoria;
use App\Entities\AnimaisHistorico;
use App\Entities\AnimaisLembrete;
use App\Entities\Animal;
use App\Entities\Dono;

use Tests\AttachJwtToken;
use Tests\TestCase;
use Faker\Factory as Faker;
use Tests\UploadFileTrait;

class AnimalTest extends TestCase
{
    use AttachJwtToken, UploadFileTrait;

    public function createAnimal(array $data)
    {
        $faker = Faker::create('pt_BR');

        for ($i = 0; $i <= rand(1, 5); $i++) {
            $data['fotos'][] = $this->uploadFakerTmp(true);
        }
        if($data['animal_categoria_id'] == AnimaisCategoria::PERDIDO){
            $data['data_desaparecimento'] = $faker->date('d/m/Y');
        }

        $dono = Dono::inRandomOrder()->first();

        if(!$dono){
            $dono = factory(Dono::class)->states('senha')->create();
        }
        $response = $this->loginAsWithJwt($dono)
            ->postJson(route('animal.store'), $data);

        $response->assertJson(['success' => true]);

        return $response;
    }

    public function checkIfAnuncioCriado($id)
    {
        $animal = Animal::whereId($id)->first();
        $this->assertTrue(
            !is_null($animal) &&
            !is_null($animal->anuncio)
        );
    }

    public function test_cadastro_mercado()
    {

        $data = factory(Animal::class)->states('mercado')->make()->toArray();
        $response = $this->createAnimal($data);

        $responseData = $response->getData();

        $this->checkIfAnuncioCriado($responseData->data->id);

    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_cadastro_match()
    {
        $data =  $data = factory(Animal::class)->states('match')->make()->toArray();

        $this->createAnimal($data);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_cadastro_doacao()
    {
        $data =  $data = factory(Animal::class)->states('doacao')->make()->toArray();;
        $this->createAnimal($data);

    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_cadastro_perdido()
    {
        $data = factory(Animal::class)->states('perdido')->make()->toArray();;

        $response = $this->createAnimal($data);

        $responseData = $response->getData();

        $this->checkIfAnuncioCriado($responseData->data->id);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_cadastro_pessoal()
    {
        $data = factory(Animal::class)->states('pessoal')->make()->toArray();;

        $this->createAnimal($data);
    }

    public function test_criar_lembrete_animal()
    {
        $animal = Animal::inRandomOrder()->tipoPessoal()->first();

        if(!$animal){
            $dono = Dono::inRandomOrder()->first();
            if(!$dono){
                $dono = factory(Dono::class)->states('senha')->create();
            }
            $animal = $dono->animais()->save(factory(Animal::class)->states('pessoal')->make());
        }

        $lembrete = factory(AnimaisLembrete::class)->make()->toArray();

        $lembrete['data_notificacao']= now()->addDays(rand(1, 5))->format('d/m/Y H:i');
        $response = $this->loginAsWithJwt($animal->dono)
            ->postJson(
                route('animal.lembrete.store', $animal->getKey()),
                $lembrete
            );
        $response->assertJson(['success' => true]);
    }

    public function teste_deletar_lembrete_animal()
    {
        $animal = Animal::inRandomOrder()->whereHas('lembretes')->first();

        if(!$animal){
            $dono = Dono::inRandomOrder()->first();
            if(!$dono){
                $dono = factory(Dono::class)->states('senha')->create();
            }
            $animal = $dono->animais()->save(factory(Animal::class)->states('pessoal')->make());
            $animal->lembretes()->save(factory(AnimaisLembrete::class)->make());
        }


        $response = $this->loginAsWithJwt($animal->dono)
            ->deleteJson(
                route('lembrete.destroy', $animal->lembretes->random()->getKey())
            );
        $response->assertJson(['success' => true]);
    }

    public function teste_listar_lembretes_animal()
    {
        $animal = Animal::inRandomOrder()->whereHas('lembretes')->first();

        if(!$animal){
            $dono = Dono::inRandomOrder()->first();
            if(!$dono){
                $dono = factory(Dono::class)->states('senha')->create();
            }
            $animal = $dono->animais()->save(factory(Animal::class)->states('pessoal')->make());
            $animal->lembretes()->saveMany(factory(AnimaisLembrete::class, 5)->make());
        }

        $response = $this->loginAsWithJwt($animal->dono)
            ->getJson(
                route('animal.lembretes', $animal->getKey())
            );

        $response->assertJson(['success' => true, 'meta' => ['to' => $animal->lembretes()->count()]]);
    }


    public function test_criar_historico_animal()
    {
        $animal = Animal::inRandomOrder()->tipoPessoal()->first();

        if(!$animal){
            $dono = Dono::inRandomOrder()->first();
            if(!$dono){
                $dono = factory(Dono::class)->states('senha')->create();
            }
            $animal = $dono->animais()->save(factory(Animal::class)->states('pessoal')->make());
        }

        $historico = factory(AnimaisHistorico::class)->make()->toArray();

        $historico['data']= now()->subDays(rand(0, 5))->format('d/m/Y');

        $response = $this->loginAsWithJwt($animal->dono)
            ->postJson(
                route('animal.historico.store', $animal->getKey()),
                $historico
            );

        $response->assertJson(['success' => true]);
    }

    public function teste_deletar_historico_animal()
    {
        $animal = Animal::inRandomOrder()->whereHas('historicos')->first();

        if(!$animal){
            $dono = Dono::inRandomOrder()->first();
            if(!$dono){
                $dono = factory(Dono::class)->states('senha')->create();
            }
            $animal = $dono->animais()->save(factory(Animal::class)->states('pessoal')->make());
            $animal->historicos()->save(factory(AnimaisHistorico::class)->make());
        }


        $response = $this->loginAsWithJwt($animal->dono)
            ->deleteJson(
                route('historico.destroy', $animal->historicos->random()->getKey())
            );
        $response->assertJson(['success' => true]);
    }

    public function teste_listar_historicos_animal()
    {
        $animal = Animal::inRandomOrder()->whereHas('historicos')->first();

        if(!$animal){
            $dono = Dono::inRandomOrder()->first();
            if(!$dono){
                $dono = factory(Dono::class)->states('senha')->create();
            }
            $animal = $dono->animais()->save(factory(Animal::class)->states('pessoal')->make());
            $animal->historicos()->saveMany(factory(AnimaisHistorico::class, 5)->make());
        }

        $response = $this->loginAsWithJwt($animal->dono)
            ->getJson(
                route('animal.historicos', $animal->getKey())
            );

        $response->assertJson(['success' => true, 'length' =>  $animal->historicos()->count()]);
    }
}
