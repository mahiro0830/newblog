<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new Category;
        $params = [
            'name' => 'IT系',
            'slug' => 'it',
            'path' => '6/',
        ];
        $category->fill($params)->save();

        // $category->destroy(9,10);
    }
}

