<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Roles
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Super Admin', 'slug' => 'super_admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Admin', 'slug' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Inventory Manager', 'slug' => 'inventory_manager', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Customer Support', 'slug' => 'customer_support', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 2. Seed Default Admin User
        DB::table('users')->insert([
            'id' => 1,
            'role_id' => 1,
            'name' => 'Super Admin',
            'email' => 'admin@albarfoods.com',
            'phone' => '9419000000',
            'email_verified_at' => now(),
            'password' => Hash::make('Admin@Albar123'),
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Seed Categories
        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'Dry Fruits', 'slug' => 'dry-fruits', 'description' => 'Premium organic dry fruits sourced from J&K orchards.', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Spices', 'slug' => 'spices', 'description' => 'Aromatic Kashmiri spices and Grade A+ Mogra saffron.', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Honey', 'slug' => 'honey', 'description' => 'Pure Acacia honey, raw and unfiltered.', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Dried Seeds', 'slug' => 'seeds', 'description' => 'Raw and shelled green pumpkin seeds, organic grade.', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Pulses', 'slug' => 'pulses', 'description' => ' Bhaderwah red beans (Rajma) and organic lentils.', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Dried Fruits', 'slug' => 'dried-fruits', 'description' => 'Dried figs, apricots and organic Kashmiri valley fruits.', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 4. Seed Brands
        DB::table('brands')->insert([
            ['id' => 1, 'name' => 'Al Barr', 'slug' => 'al-barr', 'description' => 'Khalis Wa Shifaf premium organic goods direct from Srinagar, J&K.', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 5. Seed Products & Variants (based on original products-db.php)
        $productsData = [
            1 => [
                'category_id' => 1,
                'brand_id' => 1,
                'title' => 'Premium Kashmiri Mamra Almonds (Raw)',
                'slug' => 'premium-kashmiri-mamra-almonds-raw',
                'badge' => 'Valley Sourced',
                'image' => 'assets/img/almonds.png',
                'description' => 'Kashmiri Mamra Almonds are highly prized for their high oil content and rich nutrient profile. Grown organically in local orchards, they are unpolished and 100% raw. Excellent for memory boost and daily strength.',
                'origin' => 'Zakura Orchards, Srinagar, J&K',
                'nutrition' => 'Per 100g: Calories: 579kcal, Protein: 21.15g, Healthy Fats: 49.93g, Carbohydrates: 21.55g, Dietary Fiber: 12.5g',
                'storage' => 'Store in a cool, dry place in an airtight container. Refrigeration recommended for extended freshness.',
                'variants' => [
                    ['weight' => '250g', 'price' => 850, 'orig' => 990, 'sku' => 'ALB-ALM-250G', 'stock' => 100],
                    ['weight' => '500g', 'price' => 1650, 'orig' => 1900, 'sku' => 'ALB-ALM-500G', 'stock' => 100],
                    ['weight' => '1kg', 'price' => 3200, 'orig' => 3700, 'sku' => 'ALB-ALM-1KG', 'stock' => 100]
                ]
            ],
            2 => [
                'category_id' => 2,
                'brand_id' => 1,
                'title' => 'Kashmiri Kesar (Pure Mogra Saffron)',
                'slug' => 'kashmiri-kesar-pure-mogra-saffron',
                'badge' => 'Grade A+ Certified',
                'image' => 'assets/img/saffron.png',
                'description' => 'Genuine Kashmiri Mogra Kesar representing the highest grade (A+) of flower stigma threads. Sourced directly from local farmers in Pampore. Certified Grade 1 coloring strength and crocin content.',
                'origin' => 'Pampore Fields, Pulwama, J&K',
                'nutrition' => '100% Pure Saffron Flower Stigma. Rich in Antioxidants, Crocin, Crocetins, and Safranal.',
                'storage' => 'Keep container tightly sealed in a cool, dark location. Protect from light and humidity.',
                'variants' => [
                    ['weight' => '1g', 'price' => 350, 'orig' => 400, 'sku' => 'ALB-SAF-1G', 'stock' => 150],
                    ['weight' => '2g', 'price' => 680, 'orig' => 800, 'sku' => 'ALB-SAF-2G', 'stock' => 100],
                    ['weight' => '5g', 'price' => 1650, 'orig' => 2000, 'sku' => 'ALB-SAF-5G', 'stock' => 50]
                ]
            ],
            3 => [
                'category_id' => 1,
                'brand_id' => 1,
                'title' => 'Premium Kashmiri Shelled Walnuts (Light Kernels)',
                'slug' => 'premium-kashmiri-shelled-walnuts-light-kernels',
                'badge' => '100% Organic',
                'image' => 'assets/img/walnuts.png',
                'description' => 'Premium grade shelled walnuts Kernels (Akhrot Giri) known for their extra light color, sweet taste, and high concentrations of Omega-3 fatty acids. Shelled carefully to preserve full halves.',
                'origin' => 'Anantnag Valleys, J&K',
                'nutrition' => 'Per 100g: Calories: 654kcal, Protein: 15.2g, Omega-3 Fats: 9.08g, Dietary Fiber: 6.7g',
                'storage' => 'Keep inside airtight glass jars. Freeze or refrigerate during summer months to prevent rancidity.',
                'variants' => [
                    ['weight' => '250g', 'price' => 420, 'orig' => 510, 'sku' => 'ALB-WAL-250G', 'stock' => 100],
                    ['weight' => '500g', 'price' => 810, 'orig' => 1000, 'sku' => 'ALB-WAL-500G', 'stock' => 100],
                    ['weight' => '1kg', 'price' => 1580, 'orig' => 1950, 'sku' => 'ALB-WAL-1KG', 'stock' => 100]
                ]
            ],
            4 => [
                'category_id' => 6,
                'brand_id' => 1,
                'title' => 'Organic Dried Kashmiri Figs (Anjeer Garland)',
                'slug' => 'organic-dried-kashmiri-figs-anjeer-garland',
                'badge' => 'High Fiber',
                'image' => 'assets/img/figs.png',
                'description' => 'Rich, chewy, and naturally sweet Kashmiri Figs (Anjeer) hand-threaded into traditional garlands. Naturally sun-dried without sugar syrup, preservatives, or color treatments.',
                'origin' => 'Shopian Farms, J&K',
                'nutrition' => 'Per 100g: Calories: 249kcal, Protein: 3.3g, Carbohydrates: 63.87g, Calcium: 162mg, Iron: 2.03mg',
                'storage' => 'Store inside a cool dry container. Keep away from direct moisture.',
                'variants' => [
                    ['weight' => '250g', 'price' => 490, 'orig' => 550, 'sku' => 'ALB-FIG-250G', 'stock' => 80],
                    ['weight' => '500g', 'price' => 950, 'orig' => 1080, 'sku' => 'ALB-FIG-500G', 'stock' => 80],
                    ['weight' => '1kg', 'price' => 1850, 'orig' => 2100, 'sku' => 'ALB-FIG-1KG', 'stock' => 50]
                ]
            ],
            5 => [
                'category_id' => 3,
                'brand_id' => 1,
                'title' => 'Pure Kashmiri Acacia Honey (Raw & Unfiltered)',
                'slug' => 'pure-kashmiri-acacia-honey-raw-unfiltered',
                'badge' => '100% Natural',
                'image' => 'assets/img/honey.png',
                'description' => 'Direct from the Acacia flower valleys of J&K. This honey is light-colored, mild, and slow to crystallize. Pure, organic, cold-extracted, and unheated to preserve natural enzymes.',
                'origin' => 'Ganderbal Acacia Forests, J&K',
                'nutrition' => 'Per 100g: Calories: 304kcal, Protein: 0.3g, Carbohydrates: 82.4g (Natural fructose/glucose), Calcium: 6mg',
                'storage' => 'Store at room temperature. Keep away from moisture. Natural crystallization is normal; liquefy in warm water if needed.',
                'variants' => [
                    ['weight' => '250g', 'price' => 380, 'orig' => 450, 'sku' => 'ALB-HON-250G', 'stock' => 200],
                    ['weight' => '500g', 'price' => 720, 'orig' => 850, 'sku' => 'ALB-HON-500G', 'stock' => 150],
                    ['weight' => '1kg', 'price' => 1350, 'orig' => 1600, 'sku' => 'ALB-HON-1KG', 'stock' => 100]
                ]
            ],
            6 => [
                'category_id' => 2,
                'brand_id' => 1,
                'title' => 'Kashmiri Shahi Zeera (Organic Black Cumin)',
                'slug' => 'kashmiri-shahi-zeera-organic-black-cumin',
                'badge' => 'Mountain Sourced',
                'image' => 'assets/img/zeera.png',
                'description' => 'Rare, wild black cumin harvested from the high-altitude mountain fields of Kashmir. It has a rich, earthy, aromatic flavor profiles that is far superior to standard black cumin.',
                'origin' => 'Wild Slopes, Dachigam Range, J&K',
                'nutrition' => 'Rich in iron, calcium, magnesium, and essential volatile oils (cuminaldehyde).',
                'storage' => 'Store in a airtight container in a dark, dry kitchen cabinet.',
                'variants' => [
                    ['weight' => '100g', 'price' => 290, 'orig' => 350, 'sku' => 'ALB-ZEE-100G', 'stock' => 100],
                    ['weight' => '250g', 'price' => 680, 'orig' => 800, 'sku' => 'ALB-ZEE-250G', 'stock' => 100],
                    ['weight' => '500g', 'price' => 1250, 'orig' => 1500, 'sku' => 'ALB-ZEE-500G', 'stock' => 50]
                ]
            ],
            7 => [
                'category_id' => 4,
                'brand_id' => 1,
                'title' => 'Premium Kashmiri Pumpkin Seeds (Raw & Shelled)',
                'slug' => 'premium-kashmiri-pumpkin-seeds-raw-shelled',
                'badge' => 'Superfood Grade',
                'image' => 'assets/img/pumpkin-seeds.png',
                'description' => 'Raw shelled green pumpkin seeds sourced from local organic squash growers in Kashmir. Rich in zinc, magnesium, and plant-based protein. Ideal for snacking or baking.',
                'origin' => 'Pulwama Farms, J&K',
                'nutrition' => 'Per 100g: Protein: 30.23g, Healthy Fats: 49.05g, Fiber: 6g, Zinc: 7.81mg, Magnesium: 592mg',
                'storage' => 'Keep in dry airtight jar. Refrigeration maintains crunch and prevents oil rancidity.',
                'variants' => [
                    ['weight' => '200g', 'price' => 220, 'orig' => 280, 'sku' => 'ALB-PUM-200G', 'stock' => 120],
                    ['weight' => '500g', 'price' => 490, 'orig' => 600, 'sku' => 'ALB-PUM-500G', 'stock' => 100],
                    ['weight' => '1kg', 'price' => 920, 'orig' => 1150, 'sku' => 'ALB-PUM-1KG', 'stock' => 50]
                ]
            ],
            8 => [
                'category_id' => 5,
                'brand_id' => 1,
                'title' => 'Bhaderwah Kashmiri Rajma (Premium Red Beans)',
                'slug' => 'bhaderwah-kashmiri-rajma-premium-red-beans',
                'badge' => 'GI Tag Sourced',
                'image' => 'assets/img/rajma.png',
                'description' => 'World-famous small red kidney beans harvested from the pristine high valleys of Bhaderwah, J&K. Known for their distinct deep red color, sweet aroma, and soft melting textures upon cooking.',
                'origin' => 'Bhaderwah Valleys, Doda District, J&K',
                'nutrition' => 'Per 100g: Calories: 333kcal, Protein: 24g, Dietary Fiber: 15.2g, Potassium: 1406mg, Iron: 8.2mg',
                'storage' => 'Keep inside a cool, dry bin away from direct sun. Store with a couple of cloves to deter pests.',
                'variants' => [
                    ['weight' => '500g', 'price' => 180, 'orig' => 220, 'sku' => 'ALB-RAJ-500G', 'stock' => 150],
                    ['weight' => '1kg', 'price' => 340, 'orig' => 420, 'sku' => 'ALB-RAJ-1KG', 'stock' => 100],
                    ['weight' => '2kg', 'price' => 650, 'orig' => 800, 'sku' => 'ALB-RAJ-2KG', 'stock' => 50]
                ]
            ]
        ];

        foreach ($productsData as $id => $p) {
            DB::table('products')->insert([
                'id' => $id,
                'category_id' => $p['category_id'],
                'brand_id' => $p['brand_id'],
                'title' => $p['title'],
                'slug' => $p['slug'],
                'badge' => $p['badge'],
                'description' => $p['description'],
                'image' => $p['image'],
                'origin' => $p['origin'],
                'nutrition' => $p['nutrition'],
                'storage' => $p['storage'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($p['variants'] as $v) {
                DB::table('product_variants')->insert([
                    'product_id' => $id,
                    'weight' => $v['weight'],
                    'price' => $v['price'],
                    'orig_price' => $v['orig'],
                    'sku' => $v['sku'],
                    'stock' => $v['stock'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 6. Seed Settings
        DB::table('settings')->insert([
            ['group' => 'site', 'key' => 'website_name', 'value' => 'Al Barr | Khalis Wa Shifaf', 'created_at' => now(), 'updated_at' => now()],
            ['group' => 'contact', 'key' => 'phone_number', 'value' => '+91-9419000000', 'created_at' => now(), 'updated_at' => now()],
            ['group' => 'contact', 'key' => 'email_address', 'value' => 'info@albarfoods.com', 'created_at' => now(), 'updated_at' => now()],
            ['group' => 'contact', 'key' => 'bank_name', 'value' => 'J&K Bank', 'created_at' => now(), 'updated_at' => now()],
            ['group' => 'contact', 'key' => 'bank_account_name', 'value' => 'AL BARR', 'created_at' => now(), 'updated_at' => now()],
            ['group' => 'contact', 'key' => 'bank_account_number', 'value' => '0216010100002651', 'created_at' => now(), 'updated_at' => now()],
            ['group' => 'contact', 'key' => 'bank_ifsc', 'value' => 'JAKA0GARDEN', 'created_at' => now(), 'updated_at' => now()],
            ['group' => 'site', 'key' => 'gst_percentage', 'value' => '5', 'created_at' => now(), 'updated_at' => now()],
            ['group' => 'site', 'key' => 'fssai_number', 'value' => '11025430000232', 'created_at' => now(), 'updated_at' => now()],
            ['group' => 'site', 'key' => 'gstin_number', 'value' => '01ACFFM4729H1ZF', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 7. Seed CMS Pages
        DB::table('cms_pages')->insert([
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => 'Al Barr is dedicated to sourcing the purest organic foods directly from organic valleys in Jammu & Kashmir. Sourced direct from Zakura orchards and Pulwama fields, we offer 100% natural, lab-tested, and double-sealed products.',
                'meta_title' => 'About Al Barr - Premium Kashmiri Organics',
                'meta_description' => 'Learn about Al Barr and our mission to source 100% organic dry fruits, Mogra saffron, and natural honey directly from J&K orchards.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms-conditions',
                'content' => 'All items ordered are subject to product availability. Bank transfers must be completed within 24 hours of placing the order. FSSAI certified products are packaged in clean environments.',
                'meta_title' => 'Terms & Conditions - Al Barr',
                'meta_description' => 'Read our terms and conditions for ordering organic Kashmiri dry fruits and honey from Al Barr.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => 'Your personal data such as contact numbers, email addresses, and shipping details are encrypted and securely stored. We respect your privacy and will never share your data with third parties.',
                'meta_title' => 'Privacy Policy - Al Barr',
                'meta_description' => 'Review our privacy policy regarding how we protect your personal and payment details at Al Barr.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 8. Seed Shipping Zones and Rules
        DB::table('shipping_zones')->insert([
            ['id' => 1, 'name' => 'J&K Local', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Rest of India', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('shipping_rules')->insert([
            ['shipping_zone_id' => 1, 'name' => 'Flat Rate Local', 'type' => 'flat_rate', 'min_val' => 0, 'max_val' => 998.99, 'price' => 30.00, 'created_at' => now(), 'updated_at' => now()],
            ['shipping_zone_id' => 1, 'name' => 'Free Delivery Local', 'type' => 'free_above', 'min_val' => 999.00, 'max_val' => null, 'price' => 0.00, 'created_at' => now(), 'updated_at' => now()],
            ['shipping_zone_id' => 2, 'name' => 'Flat Rate National', 'type' => 'flat_rate', 'min_val' => 0, 'max_val' => 998.99, 'price' => 60.00, 'created_at' => now(), 'updated_at' => now()],
            ['shipping_zone_id' => 2, 'name' => 'Free Delivery National', 'type' => 'free_above', 'min_val' => 999.00, 'max_val' => null, 'price' => 0.00, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 9. Seed Coupons
        DB::table('coupons')->insert([
            ['code' => 'ALBARR10', 'type' => 'percentage', 'value' => 10.00, 'min_order_amount' => 0.00, 'usage_limit' => null, 'used_count' => 0, 'expires_at' => '2030-12-31 23:59:59', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
