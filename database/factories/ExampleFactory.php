<?php

use Faker\Factory as Faker;

$faker = Faker::create('pt_BR');
$genero = \App\Entities\Dono::getGeneros();
$porte = \App\Entities\Animal::getPortes();

$factory->define(App\Entities\Dono::class, function () use ($faker, $genero) {
    $data = [
        'nome' => $faker->name,
        'genero' => $genero[rand(0, 1)],
        'data_nascimento' => $faker->date('d/m/Y'),
        'estado' => $faker->stateAbbr,
        'cidade' => $faker->city,
        'latitude' => $faker->latitude(-25.413091, -25.528394),
        'longitude' => $faker->longitude(-49.348890, -49.199717),
        'telefone' => str_replace(' ', '', $faker->cellphoneNumber),
        'email' => $faker->email,
        'como_soube' => str_random(15)
    ];
    return $data;
});

$factory->state(\App\Entities\Dono::class, 'facebook', [
     'facebook_id' => str_random(15)
]);

$factory->state(\App\Entities\Dono::class, 'senha', [
    'senha' => '123456'
]);

$factory->define(App\Entities\Animal::class, function () use ($faker, $genero, $porte) {
    $categoria = rand(1, 5);
    $data = [
        'nome' => $faker->name,
        'raca_id' => rand(1, 15),
        'cor' => $faker->word,
        'idade_mes' => rand(0, 11),
        'idade_ano' => rand(0, 200),
        'porte' => $porte[rand(0, 2)],
        'genero' => $genero[rand(0, 1)],
        'estado' => $faker->stateAbbr,
        'cidade' => $faker->city,
        'animal_categoria_id' => $categoria,
        'dono_id' => rand(1, 10)
    ];
    if (rand(0, 3) == 3) {
        $data['informacoes'] = str_random(rand(5, 50));
    }
    if ($categoria == \App\Entities\AnimaisCategoria::MERCADO) {
        $data['preco'] = $faker->randomFloat(2, 5, 9000);
    }
    if ($categoria == \App\Entities\AnimaisCategoria::PERDIDO) {
        $data['data_desaparecimento'] = $faker->date('d/m/Y');
    }
    if (rand(0, 3) == 3) {
        $data['peso'] = $faker->randomFloat(2, 1);
    }
    return $data;
});

$factory->state(App\Entities\Animal::class, 'mercado', [
    'preco' => $faker->randomFloat(2, 5, 9000),
    'animal_categoria_id' => \App\Entities\AnimaisCategoria::MERCADO,
]);

$factory->state(App\Entities\Animal::class, 'perdido', [
    'animal_categoria_id' => \App\Entities\AnimaisCategoria::PERDIDO,
    'data_desaparecimento' => $faker->date('d/m/Y')
]);

$factory->state(App\Entities\Animal::class, 'match', [
    'animal_categoria_id' => \App\Entities\AnimaisCategoria::MATCH,
]);

$factory->state(App\Entities\Animal::class, 'doacao', [
    'animal_categoria_id' => \App\Entities\AnimaisCategoria::DOACAO,
]);

$factory->state(App\Entities\Animal::class, 'pessoal', [
    'animal_categoria_id' => \App\Entities\AnimaisCategoria::PESSOAL,
]);

$factory->define(\App\Entities\Cartao::class, function() use ($faker){
    $bandeiras = \App\Entities\Cartao::getBandeiras();
    return [
        'hash' => base64_encode(str_random(30)),
        'ultimos_digitos' => '"'.rand(1000, 9999).'"',
        'nome_completo' => $faker->name,
        'data_nascimento' => $faker->date('d/m/Y'),
        'bandeira' => $bandeiras[rand(0, count($bandeiras)-1)],
        'cpf' => $faker->cpf,
        'telefone' => str_replace(' ', '', $faker->cellphoneNumber),
        'cep' => rand(10000, 99999).'-'.rand(100, 999),
        'rua' => $faker->streetName,
        'bairro' => $faker->word,
        'numero' => $faker->buildingNumber,
        'cidade' => $faker->city,
        'estado' => $faker->stateAbbr,
        'dono_id' => rand(1, 10)
    ];
});

$factory->define(\App\Entities\AnimaisLembrete::class, function() use($faker){
     return [
         'nome' => $faker->word,
         'descricao' => $faker->text,
         'data_notificacao' => now()->addHours(rand(1,11))->addDays(rand(0, 5))
     ];
});

$factory->define(\App\Entities\AnimaisHistorico::class, function() use($faker){
    return [
        'peso' => $faker->randomFloat(2, 2, 100),
		'altura' => rand(20, 200),
		'data' => $faker->date('d/m/Y')
	];
});

