<?php
// Shared Product Database (Procedural Array)
$products = [
    1 => [
        'id' => 1,
        'title' => 'Premium Kashmiri Mamra Almonds (Raw)',
        'meta' => 'Dry Fruits',
        'badge' => 'Valley Sourced',
        'rating' => 5,
        'reviews' => 48,
        'image' => 'assets/img/almonds.png',
        'description' => 'Kashmiri Mamra Almonds are highly prized for their high oil content and rich nutrient profile. Grown organically in local orchards, they are unpolished and 100% raw. Excellent for memory boost and daily strength.',
        'variants' => [
            '250g' => ['price' => 850, 'orig' => 990],
            '500g' => ['price' => 1650, 'orig' => 1900],
            '1kg' => ['price' => 3200, 'orig' => 3700]
        ],
        'origin' => 'Zakura Orchards, Srinagar, J&K',
        'nutrition' => 'Per 100g: Calories: 579kcal, Protein: 21.15g, Healthy Fats: 49.93g, Carbohydrates: 21.55g, Dietary Fiber: 12.5g',
        'storage' => 'Store in a cool, dry place in an airtight container. Refrigeration recommended for extended freshness.'
    ],
    2 => [
        'id' => 2,
        'title' => 'Kashmiri Kesar (Pure Mogra Saffron)',
        'meta' => 'Spices',
        'badge' => 'Grade A+ Certified',
        'rating' => 5,
        'reviews' => 94,
        'image' => 'assets/img/saffron.png',
        'description' => 'Genuine Kashmiri Mogra Kesar representing the highest grade (A+) of flower stigma threads. Sourced directly from local farmers in Pampore. Certified Grade 1 coloring strength and crocin content.',
        'variants' => [
            '1g' => ['price' => 350, 'orig' => 400],
            '2g' => ['price' => 680, 'orig' => 800],
            '5g' => ['price' => 1650, 'orig' => 2000]
        ],
        'origin' => 'Pampore Fields, Pulwama, J&K',
        'nutrition' => '100% Pure Saffron Flower Stigma. Rich in Antioxidants, Crocin, Crocetins, and Safranal.',
        'storage' => 'Keep container tightly sealed in a cool, dark location. Protect from light and humidity.'
    ],
    3 => [
        'id' => 3,
        'title' => 'Premium Kashmiri Shelled Walnuts (Light Kernels)',
        'meta' => 'Dry Fruits',
        'badge' => '100% Organic',
        'rating' => 5,
        'reviews' => 37,
        'image' => 'assets/img/walnuts.png',
        'description' => 'Premium grade shelled walnuts Kernels (Akhrot Giri) known for their extra light color, sweet taste, and high concentrations of Omega-3 fatty acids. Shelled carefully to preserve full halves.',
        'variants' => [
            '250g' => ['price' => 420, 'orig' => 510],
            '500g' => ['price' => 810, 'orig' => 1000],
            '1kg' => ['price' => 1580, 'orig' => 1950]
        ],
        'origin' => 'Anantnag Valleys, J&K',
        'nutrition' => 'Per 100g: Calories: 654kcal, Protein: 15.2g, Omega-3 Fats: 9.08g, Dietary Fiber: 6.7g',
        'storage' => 'Keep inside airtight glass jars. Freeze or refrigerate during summer months to prevent rancidity.'
    ],
    4 => [
        'id' => 4,
        'title' => 'Organic Dried Kashmiri Figs (Anjeer Garland)',
        'meta' => 'Dried Fruits',
        'badge' => 'High Fiber',
        'rating' => 4,
        'reviews' => 22,
        'image' => 'assets/img/figs.png',
        'description' => 'Rich, chewy, and naturally sweet Kashmiri Figs (Anjeer) hand-threaded into traditional garlands. Naturally sun-dried without sugar syrup, preservatives, or color treatments.',
        'variants' => [
            '250g' => ['price' => 490, 'orig' => 550],
            '500g' => ['price' => 950, 'orig' => 1080],
            '1kg' => ['price' => 1850, 'orig' => 2100]
        ],
        'origin' => 'Shopian Farms, J&K',
        'nutrition' => 'Per 100g: Calories: 249kcal, Protein: 3.3g, Carbohydrates: 63.87g, Calcium: 162mg, Iron: 2.03mg',
        'storage' => 'Store inside a cool dry container. Keep away from direct moisture.'
    ],
    5 => [
        'id' => 5,
        'title' => 'Pure Kashmiri Acacia Honey (Raw & Unfiltered)',
        'meta' => 'Honey',
        'badge' => '100% Natural',
        'rating' => 5,
        'reviews' => 29,
        'image' => 'assets/img/honey.png',
        'description' => 'Direct from the Acacia flower valleys of J&K. This honey is light-colored, mild, and slow to crystallize. Pure, organic, cold-extracted, and unheated to preserve natural enzymes.',
        'variants' => [
            '250g' => ['price' => 380, 'orig' => 450],
            '500g' => ['price' => 720, 'orig' => 850],
            '1kg' => ['price' => 1350, 'orig' => 1600]
        ],
        'origin' => 'Ganderbal Acacia Forests, J&K',
        'nutrition' => 'Per 100g: Calories: 304kcal, Protein: 0.3g, Carbohydrates: 82.4g (Natural fructose/glucose), Calcium: 6mg',
        'storage' => 'Store at room temperature. Keep away from moisture. Natural crystallization is normal; liquefy in warm water if needed.'
    ],
    6 => [
        'id' => 6,
        'title' => 'Kashmiri Shahi Zeera (Organic Black Cumin)',
        'meta' => 'Spices',
        'badge' => 'Mountain Sourced',
        'rating' => 5,
        'reviews' => 41,
        'image' => 'assets/img/zeera.png',
        'description' => 'Rare, wild black cumin harvested from the high-altitude mountain fields of Kashmir. It has a rich, earthy, aromatic flavor profiles that is far superior to standard black cumin.',
        'variants' => [
            '100g' => ['price' => 290, 'orig' => 350],
            '250g' => ['price' => 680, 'orig' => 800],
            '500g' => ['price' => 1250, 'orig' => 1500]
        ],
        'origin' => 'Wild Slopes, Dachigam Range, J&K',
        'nutrition' => 'Rich in iron, calcium, magnesium, and essential volatile oils (cuminaldehyde).',
        'storage' => 'Store in a airtight container in a dark, dry kitchen cabinet.'
    ],
    7 => [
        'id' => 7,
        'title' => 'Premium Kashmiri Pumpkin Seeds (Raw & Shelled)',
        'meta' => 'Dried Seeds',
        'badge' => 'Superfood Grade',
        'rating' => 4,
        'reviews' => 18,
        'image' => 'assets/img/pumpkin-seeds.png',
        'description' => 'Raw shelled green pumpkin seeds sourced from local organic squash growers in Kashmir. Rich in zinc, magnesium, and plant-based protein. Ideal for snacking or baking.',
        'variants' => [
            '200g' => ['price' => 220, 'orig' => 280],
            '500g' => ['price' => 490, 'orig' => 600],
            '1kg' => ['price' => 920, 'orig' => 1150]
        ],
        'origin' => 'Pulwama Farms, J&K',
        'nutrition' => 'Per 100g: Protein: 30.23g, Healthy Fats: 49.05g, Fiber: 6g, Zinc: 7.81mg, Magnesium: 592mg',
        'storage' => 'Keep in dry airtight jar. Refrigeration maintains crunch and prevents oil rancidity.'
    ],
    8 => [
        'id' => 8,
        'title' => 'Bhaderwah Kashmiri Rajma (Premium Red Beans)',
        'meta' => 'Pulses',
        'badge' => 'GI Tag Sourced',
        'rating' => 5,
        'reviews' => 34,
        'image' => 'assets/img/rajma.png',
        'description' => 'World-famous small red kidney beans harvested from the pristine high valleys of Bhaderwah, J&K. Known for their distinct deep red color, sweet aroma, and soft melting textures upon cooking.',
        'variants' => [
            '500g' => ['price' => 180, 'orig' => 220],
            '1kg' => ['price' => 340, 'orig' => 420],
            '2kg' => ['price' => 650, 'orig' => 800]
        ],
        'origin' => 'Bhaderwah Valleys, Doda District, J&K',
        'nutrition' => 'Per 100g: Calories: 333kcal, Protein: 24g, Dietary Fiber: 15.2g, Potassium: 1406mg, Iron: 8.2mg',
        'storage' => 'Keep inside a cool, dry bin away from direct sun. Store with a couple of cloves to deter pests.'
    ]
];
return $products;
