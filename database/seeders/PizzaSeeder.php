<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Pizza;

class PizzaSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // CATEGORIES
        // =========================

        $classic = Category::create([
            'name' => 'Classic Pizza',
            'description' => 'Our delicious classic pizza flavors.',
            'status' => true,
        ]);

        $special = Category::create([
            'name' => 'Special Pizza',
            'description' => 'Our special and delicious pizza flavors.',
            'status' => true,
        ]);

        $vegetarian = Category::create([
            'name' => 'Vegetarian Pizza',
            'description' => 'Fresh and delicious vegetarian pizza.',
            'status' => true,
        ]);


        // =========================
        // PIZZA 1 - HAM & CHEESE
        // =========================

        Pizza::create([
            'category_id' => $classic->id,
            'name' => 'Ham & Cheese',
            'description' => 'Delicious ham and melted cheese pizza.',
            'price' => 115.00,
            'image' => null,
            'status' => true,
        ]);


        // =========================
        // PIZZA 2 - HAWAIIAN
        // =========================

        Pizza::create([
            'category_id' => $classic->id,
            'name' => 'Hawaiian',
            'description' => 'Ham and pineapple with melted cheese.',
            'price' => 115.00,
            'image' => null,
            'status' => true,
        ]);


        // =========================
        // PIZZA 3 - PEPPERONI
        // =========================

        Pizza::create([
            'category_id' => $classic->id,
            'name' => 'Pepperoni',
            'description' => 'Pizza topped with delicious pepperoni.',
            'price' => 120.00,
            'image' => null,
            'status' => true,
        ]);


        // =========================
        // PIZZA 4 - BACON
        // =========================

        Pizza::create([
            'category_id' => $special->id,
            'name' => 'Bacon',
            'description' => 'Delicious pizza topped with crispy bacon.',
            'price' => 125.00,
            'image' => null,
            'status' => true,
        ]);


        // =========================
        // PIZZA 5 - BEEF
        // =========================

        Pizza::create([
            'category_id' => $special->id,
            'name' => 'Beef',
            'description' => 'Savory beef pizza with delicious toppings.',
            'price' => 125.00,
            'image' => null,
            'status' => true,
        ]);


        // =========================
        // PIZZA 6 - VEGETARIAN
        // =========================

        Pizza::create([
            'category_id' => $vegetarian->id,
            'name' => 'Vegetarian',
            'description' => 'Fresh vegetables with melted cheese.',
            'price' => 120.00,
            'image' => null,
            'status' => true,
        ]);
    }
}