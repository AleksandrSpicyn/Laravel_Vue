<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Product::class, 50)->create()->each(function ($product) {
            $category = \App\Category::inRandomOrder()->get()->first();
            $product->categories()->attach($category);
        });
    }
}
