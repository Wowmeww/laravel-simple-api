<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Nico Bernard B. Firmanes',
            'email' => 'nbfirmanes@sorsu.edu.ph',
            'password' => Hash::make('123')
        ]);

        $products = [
            [
                'name' => 'T-Shirt Classic',
                'description' => 'Comfortable cotton t-shirt in classic white.',
                'price' => 299.00,
                'stock' => 30,
                'category' => 'Clothing',
                'active' => true,
            ],
            [
                'name' => 'Graphic Hoodie',
                'description' => 'Soft fleece hoodie with custom graphic.',
                'price' => 799.00,
                'stock' => 15,
                'category' => 'Clothing',
                'active' => true,
            ],
            [
                'name' => 'Jogger Pants',
                'description' => 'Lightweight and comfy joggers.',
                'price' => 599.00,
                'stock' => 25,
                'category' => 'Clothing',
                'active' => true,
            ],
            [
                'name' => 'Custom Mug',
                'description' => 'Personalized printed mug.',
                'price' => 120.00,
                'stock' => 50,
                'category' => 'Merch',
                'active' => true,
            ],
            [
                'name' => 'Lanyard',
                'description' => 'Custom printed lanyard.',
                'price' => 50.00,
                'stock' => 100,
                'category' => 'Accessories',
                'active' => true,
            ],
            [
                'name' => 'Sticker Pack',
                'description' => 'Set of high-quality custom stickers.',
                'price' => 80.00,
                'stock' => 200,
                'category' => 'Merch',
                'active' => true,
            ],
            [
                'name' => 'Tumbler Print',
                'description' => 'Custom stainless tumbler.',
                'price' => 350.00,
                'stock' => 40,
                'category' => 'Merch',
                'active' => true,
            ],
            [
                'name' => 'ID PVC Card',
                'description' => 'PVC card custom printed for IDs.',
                'price' => 45.00,
                'stock' => 300,
                'category' => 'Printing',
                'active' => true,
            ],
            [
                'name' => 'Custom Tote Bag',
                'description' => 'Eco-friendly tote bag with custom print.',
                'price' => 150.00,
                'stock' => 60,
                'category' => 'Merch',
                'active' => true,
            ],
            [
                'name' => 'Keychain Acrylic',
                'description' => 'Laser-cut acrylic keychain.',
                'price' => 35.00,
                'stock' => 150,
                'category' => 'Accessories',
                'active' => true,
            ],
            [
                'name' => 'Cap Print',
                'description' => 'Custom embroidered or printed cap.',
                'price' => 250.00,
                'stock' => 20,
                'category' => 'Clothing',
                'active' => true,
            ],
            [
                'name' => 'Sports Jersey',
                'description' => 'Full-sublimation jersey.',
                'price' => 699.00,
                'stock' => 18,
                'category' => 'Clothing',
                'active' => true,
            ],
            [
                'name' => 'Business Card Print',
                'description' => 'Premium matte laminated business cards (100 pcs).',
                'price' => 180.00,
                'stock' => 120,
                'category' => 'Printing',
                'active' => true,
            ],
            [
                'name' => 'Photo Print (8x10)',
                'description' => 'High-resolution glossy photo print.',
                'price' => 25.00,
                'stock' => 500,
                'category' => 'Printing',
                'active' => true,
            ],
            [
                'name' => 'Mousepad Print',
                'description' => 'Custom printed mousepad.',
                'price' => 220.00,
                'stock' => 35,
                'category' => 'Merch',
                'active' => true,
            ],
        ];


        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
