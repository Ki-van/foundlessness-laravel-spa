<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $domains = [
            [
                'slug' => 'out_of_domain',
                'name' => 'Вне области',
                'description' => 'Статьи, которые не попадают ни под один предоставленный домен',
            ],
            [
                'slug' => 'math',
                'name' => 'Математика',
                'description' => 'Всевозможное использование чисел и форм',
            ],
            [
                'slug' => 'philosophy_of_it',
                'name' => 'Философия программирования',
                'description' => 'То же что и философия, только про программирование',
            ],
            [
                'slug' => 'philosophy',
                'name' => 'Философия',
                'description' => 'Наиболее категоричные рассуждения и знания. Познание',
            ],
            [
                'slug' => 'it',
                'name' => 'Информационные технологии',
                'description' => 'Методологии обработки информации',
            ],

        ];

        foreach($domains as $domain) {
            DB::table('domains')->insert($domain);
        }
    }
}
