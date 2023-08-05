<?php

namespace Database\Seeders;
use App\Models\UserCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserCategory::insert([
            [
                'name' => 'Adm'
            ],
            [
                'name' => 'Empresa'
            ],
            [
                'name' => 'Trabalhador'
            ],
            [
                'name' => 'Contador'
            ],
            [
                'name' => 'Recrutador'
            ],
        ]);
    }
}
