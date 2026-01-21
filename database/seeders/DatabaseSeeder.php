<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\HarvestBatch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Vytvor test usera
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'user',
        ]);

        // Vytvor admin usera
        User::firstOrCreate(
            ['email' => 'admin@demo.test'],
            [
                'name' => 'Administrator',
                'password' => '1234',
                'role' => 'admin',
            ]
        );

        // ==================== HARVEST BATCHES ====================
        $batches = [
            HarvestBatch::create([
                'year' => 2024,
                'location' => 'Nitriansky kraj',
                'brix' => 82.5,
                'harvested_at' => '2024-06-15',
            ]),
            HarvestBatch::create([
                'year' => 2024,
                'location' => 'Východné Slovensko',
                'brix' => 80.0,
                'harvested_at' => '2024-07-20',
            ]),
            HarvestBatch::create([
                'year' => 2023,
                'location' => 'Nitra',
                'brix' => 81.0,
                'harvested_at' => '2023-06-10',
            ]),
        ];

        // ==================== CATEGORIES ====================
        $categories = [
            Category::create([
                'name' => 'Lesný med',
                'slug' => 'lesny-med',
                'description' => 'Chutný med zbieraný z lesných kvetov',
                'is_active' => true,
            ]),
            Category::create([
                'name' => 'Lipový med',
                'slug' => 'lipovy-med',
                'description' => 'Jemný med s vôňou lipových kvetov',
                'is_active' => true,
            ]),
            Category::create([
                'name' => 'Akaciový med',
                'slug' => 'akaciavy-med',
                'description' => 'Svetlý med s príjemnou chuťou',
                'is_active' => true,
            ]),
            Category::create([
                'name' => 'Kvetový med',
                'slug' => 'kvetovy-med',
                'description' => 'Mix медov z rôznych kvetov',
                'is_active' => true,
            ]),
        ];

        // ==================== PRODUCTS ====================
        $products = [
            // Lesný med
            [
                'category_id' => $categories[0]->id,
                'harvest_batch_id' => $batches[0]->id,
                'name' => 'Med lesný 500g',
                'slug' => 'med-lesny-500g',
                'description' => 'Výborný lesný med v skleničke 500g. Čistý a prírodný.',
                'price_cents' => 599,
                'stock' => 25,
                'is_active' => true,
            ],
            [
                'category_id' => $categories[0]->id,
                'harvest_batch_id' => $batches[0]->id,
                'name' => 'Med lesný 1kg',
                'slug' => 'med-lesny-1kg',
                'description' => 'Balenie jedného kilogramu lesného medu.',
                'price_cents' => 999,
                'stock' => 15,
                'is_active' => true,
            ],
            // Lipový med
            [
                'category_id' => $categories[1]->id,
                'harvest_batch_id' => $batches[1]->id,
                'name' => 'Med lipový 500g',
                'slug' => 'med-lipovy-500g',
                'description' => 'Nežný lipový med s unikátnou chuťou.',
                'price_cents' => 699,
                'stock' => 30,
                'is_active' => true,
            ],
            [
                'category_id' => $categories[1]->id,
                'harvest_batch_id' => $batches[1]->id,
                'name' => 'Med lipový 250g',
                'slug' => 'med-lipovy-250g',
                'description' => 'Menšie balenie lipového medu, ideálne na kúsok skúšky.',
                'price_cents' => 399,
                'stock' => 50,
                'is_active' => true,
            ],
            // Akaciový med
            [
                'category_id' => $categories[2]->id,
                'harvest_batch_id' => $batches[2]->id,
                'name' => 'Med akaciový 400g',
                'slug' => 'med-akaciavy-400g',
                'description' => 'Svetlý akaciový med s kryštalickou štruktúrou.',
                'price_cents' => 549,
                'stock' => 20,
                'is_active' => true,
            ],
            [
                'category_id' => $categories[3]->id,
                'harvest_batch_id' => $batches[0]->id,
                'name' => 'Med kvetový mix 500g',
                'slug' => 'med-kvetovy-mix-500g',
                'description' => 'Luxusný mix kvetového medu s bohatou chuťou.',
                'price_cents' => 799,
                'stock' => 12,
                'is_active' => true,
            ],
            [
                'category_id' => $categories[3]->id,
                'harvest_batch_id' => null,
                'name' => 'Med kvetový prezent',
                'slug' => 'med-kvetovy-prezent',
                'description' => 'Elegantné balenie vhodné ako darček.',
                'price_cents' => 1299,
                'stock' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        echo "✅ Seeder dokončený!\n";
        echo "✅ Vytvorené: " . count($batches) . " zbierok\n";
        echo "✅ Vytvorené: " . count($categories) . " kategórií\n";
        echo "✅ Vytvorené: " . count($products) . " produktov\n";
    }
}
