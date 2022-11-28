<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Option;

class OptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'option_name' => 'sitename',
            'option_value' => 'newBlog',
        ];
        $option = new Option;
        $option->fill($param)->save();

        $param = [
            'option_name' => 'post_per_page',
            'option_value' => '10',
            'autoload' => 'no',
        ];
        $option = new Option;
        $option->fill($param)->save();

        $param = [
            'option_name' => 'post_per_admin',
            'option_value' => '5',
            'autoload' => 'no',
        ];
        $option = new Option;
        $option->fill($param)->save();
    }
}
