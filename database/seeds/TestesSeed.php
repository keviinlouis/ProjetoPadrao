<?php

use Illuminate\Database\Seeder;

class TestesSeed extends Seeder
{
    private $fileService;

    /**
     * TestesSeed constructor.
     */
    public function __construct(\App\Services\FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $this->exampleSeed();
    }

    /**
     * @throws Exception
     */
    public function exampleSeed()
    {
        $arquivos = collect(Storage::files('public/temp'));
        if($arquivos->isEmpty()){
            for($i = 0;$i<=5;$i++){
                \Illuminate\Http\UploadedFile::fake()->image('teste.jpg')->storeAs('public/temp', uniqid().'.jpg');
            }
            $arquivos = collect(Storage::files('public/temp'));
        }


        factory(\App\Entities\Dono::class)->states('senha')->create(['email' => 'q@q.com']);
        factory(\App\Entities\Dono::class)->states('senha')->create(['email' => 'w@w.com']);
        factory(\App\Entities\Dono::class)->states('senha')->create(['email' => 'e@e.com']);

//        factory(\App\Entities\Dono::class, 50)->states('senha')->create()->each(function (\App\Entities\Dono $dono) use ($arquivos){
//            if(rand(0, 3) != 3){
//                $dono->cartoes()->saveMany(factory(\App\Entities\Cartao::class, rand(1, 4))->make());
//            }
//            if (rand(0, 3) == 3) {
//                return;
//            }
//            $fotoPerfil = explode('/', $arquivos->random());
//            $fotoPerfil = end($fotoPerfil);
//            $pathFile = $this->fileService->copyFileFromTmp(
//                $fotoPerfil,
//                $dono->getPathFotoPerfil()
//            );
//
//            $dono->arquivos()->create([
//                'nome' => $fotoPerfil,
//                'extensao' => $this->fileService->extractExtensionFromFileName($pathFile),
//                'tipo' => \App\Entities\Dono::FOTO_PERFIL,
//                'path' => $pathFile,
//                'url' => $this->fileService->url($pathFile),
//                'descricao' => 'Foto de Perfil'
//            ]);
//            if(rand(1,3) == 3){
//                foreach(['mercado', 'perdido', 'match', 'doacao', 'pessoal'] as $tipo){
//                    if(rand(1,3) == 3){
//                        continue;
//                    }
//                    $dono->animais()->saveMany(factory(\App\Entities\Animal::class, rand(1, 10))->states($tipo)->make([
//                        'cidade' => $dono->cidade,
//                        'estado' => $dono->estado
//                    ]));
//                }
//            }
//
//            $dono->animais->each(function (\App\Entities\Animal $animal) use($arquivos) {
//                foreach ($arquivos->random(rand(1, $arquivos->count())) as $foto) {
//                    if(rand(0, 1) == 1){
//                        continue;
//                    }
//                    $foto = explode('/', $foto);
//                    $foto = end($foto);
//                    $pathFile = $this->fileService->copyFileFromTmp(
//                        $foto,
//                        $animal->getPathFotos()
//                    );
//                    $animal->arquivos()->updateOrCreate([
//                        'nome' => $foto,
//                        'extensao' => $this->fileService->extractExtensionFromFileName($pathFile),
//                        'tipo' => \App\Entities\Animal::FOTOS,
//                        'path' => $pathFile,
//                        'url' => $this->fileService->url($pathFile),
//                        'descricao' => 'Foto de animal'
//                    ]);
//                }
//            });
//
//        });
    }
}
