<?php

use Illuminate\Database\Seeder;

class AdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'nome' => 'Administrador Teste',
                'email' => 'master@master.com',
                'senha' => Hash::make('123456'),
                'is_master' => 1
            ]
        ];

        foreach ($data as $item) {
            DB::table('administradores')->updateOrInsert($item);
        }
    }
}
