<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedAdminUser();
        $this->seedCategories();
        $this->seedProducts();
    }

    private function seedAdminUser(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@drugpharmaeg.com'],
            [
                'name'              => 'Admin',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }

    private function seedCategories(): void
    {
        $categories = [
            [
                'slug' => 'child-neonates',
                'name' => 'Child & Neonates Care',
                'description' => 'Pediatric drops, syrups, and supplements specially formulated for infants and children.',
                'icon' => '👶',
                'sort_order' => 1,
            ],
            [
                'slug' => 'pregnant-women',
                'name' => 'Pregnant & Women Care',
                'description' => 'Calcium, iron, and prenatal nutrition for expectant mothers and women.',
                'icon' => '🤰',
                'sort_order' => 2,
            ],
            [
                'slug' => 'pain-management',
                'name' => 'Pain Management & Anti-inflammatory',
                'description' => 'Enzyme blends and neuropathic-pain formulations for inflammation and pain relief.',
                'icon' => '💪',
                'sort_order' => 3,
            ],
            [
                'slug' => 'neuro-support',
                'name' => 'Neuro Support',
                'description' => 'Citicoline-based formulations supporting cognitive function and brain health.',
                'icon' => '🧠',
                'sort_order' => 4,
            ],
            [
                'slug' => 'bone',
                'name' => 'Bone Care',
                'description' => 'Joint and orthopedic support — glucosamine, collagen, vitamin D3, topical relief.',
                'icon' => '🦴',
                'sort_order' => 5,
            ],
            [
                'slug' => 'antioxidant-immunity',
                'name' => 'Antioxidant & Immunity',
                'description' => 'Vitamin & mineral sachets for daily antioxidant defense and immune support.',
                'icon' => '🛡️',
                'sort_order' => 6,
            ],
            [
                'slug' => 'git-gut-health',
                'name' => 'GIT & Gut Health',
                'description' => 'Gastric comfort and probiotic formulations for digestive balance.',
                'icon' => '🫁',
                'sort_order' => 7,
            ],
            [
                'slug' => 'skin-care',
                'name' => 'Skin Care',
                'description' => 'Specialty formulations for hair, skin, and nail health.',
                'icon' => '✨',
                'sort_order' => 8,
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }

    private function seedProducts(): void
    {
        // Each product's image lives at public/images/products/<slug>.{webp,png,jpg}
        // resolveImg() prefers .webp when available (much smaller), falls back to original formats.
        $resolveImg = function (string $slug): ?string {
            $base = public_path("images/products/{$slug}");
            foreach (['.webp', '.png', '.jpg', '.jpeg'] as $ext) {
                if (file_exists($base . $ext)) {
                    return "/images/products/{$slug}{$ext}";
                }
            }
            return null;
        };

        $products = [
            // ========== Child & Neonates Care (12) ==========
            ['cat' => 'child-neonates', 'slug' => 'three-cool', 'name' => 'Three Cool', 'form' => 'Oral Drops 10 ml', 'image' => null, 'is_featured' => true,
             'description' => 'Lactase enzyme drops for lactose intolerance in children.',
             'composition' => 'Lactase Enzyme 750 ALU.',
             'uses' => 'Lactose intolerance in children.',
             'dose' => 'Add 18 drops to 500 ml of milk, water or juice.'],
            ['cat' => 'child-neonates', 'slug' => 'lc-plus-drops', 'name' => 'L.C. Plus Drops', 'form' => 'Oral Drops 10 ml', 'image' => null, 'is_featured' => false,
             'description' => 'Probiotic drops for infantile colic and gut balance.',
             'composition' => 'Lactobacillus Reuteri 100M CFU, Zinc 4 mg.',
             'uses' => 'FGID management and infantile colic.',
             'dose' => '¼ ml daily.'],
            ['cat' => 'child-neonates', 'slug' => 'vitosel-drops', 'name' => 'Vitosel Drops & Syrup', 'form' => 'Drops 30 ml / Syrup 120 ml', 'image' => null, 'is_featured' => true,
             'description' => 'Iron polymaltose + folic acid + B12 + Vitamin C for IDA in neonates and children.',
             'composition' => 'Iron Polymaltose, Folic Acid, Vitamin B12, Vitamin C.',
             'uses' => 'Iron-deficiency anaemia in neonates & children. Folic acid deficiency.',
             'dose' => '2-3 drops in neonates. ¼ ml in children daily.'],
            ['cat' => 'child-neonates', 'slug' => '3-fly-syrup', 'name' => '3 Fly Syrup', 'form' => 'Syrup 120 ml', 'image' => null, 'is_featured' => false,
             'description' => 'Palmitoylethanolamide syrup supporting the nervous system in children.',
             'composition' => 'Palmitoylethanolamide 150 mg.',
             'uses' => 'Support nervous system for children.',
             'dose' => '5 ml three times daily.'],
            ['cat' => 'child-neonates', 'slug' => 'zemylaise', 'name' => 'Zemylaise', 'form' => 'Syrup 120 ml', 'image' => null, 'is_featured' => false,
             'description' => 'Alpha-amylase enzyme syrup — anti-inflammatory & anti-edematous for kids.',
             'composition' => '200 CEIP.UNIT alpha-amylase / ml.',
             'uses' => 'Anti-inflammatory & anti-edematous.',
             'dose' => '1 tablespoonful three times daily.'],
            ['cat' => 'child-neonates', 'slug' => 'three-drops', 'name' => 'Three Drops 400/600 I.U', 'form' => 'Oral Drops 30 ml', 'image' => null, 'is_featured' => true,
             'description' => 'Vitamin D3 drops for infant bone growth and rickets treatment.',
             'composition' => 'Vitamin D3 400/600 IU.',
             'uses' => 'Bone growth in infants. Vitamin D3 deficiency. Treatment of rickets.',
             'dose' => '½ ml daily.'],
            ['cat' => 'child-neonates', 'slug' => 'umega-kids-drops', 'name' => 'Umega Kids Drops', 'form' => 'Oral Drops 30 ml', 'image' => null, 'is_featured' => true,
             'description' => 'Omega-3 with deodorized fish oil and vitamin E for cognitive function.',
             'composition' => 'Omega-3, Deodorized fish oil, Vitamin E.',
             'uses' => 'Adjuvant therapy in ADHD. Cognitive function in children. Immune enhancer.',
             'dose' => '½ ml daily.'],
            ['cat' => 'child-neonates', 'slug' => 'umega-syrup', 'name' => 'Umega Syrup', 'form' => 'Syrup 120 ml', 'image' => null, 'is_featured' => false,
             'description' => 'Omega-3 syrup supporting brain & heart function and ADHD in children.',
             'composition' => 'Omega-3 1600 mg / 5 ml (EPA 300 mg, DHA 200 mg).',
             'uses' => 'Support brain & heart function. ADHD in children.',
             'dose' => '5 ml three times daily.'],
            ['cat' => 'child-neonates', 'slug' => 'three-sharks', 'name' => 'Three Sharks', 'form' => 'Syrup 120 ml', 'image' => null, 'is_featured' => true,
             'description' => 'Multi-vitamin syrup with Omega-3 supporting healthy growth and brain development.',
             'composition' => 'Omega-3, B-complex (B1, B6, B12), Vit. D3, Vit. C, Vit. E, Niacin, Folic acid, Vit. A, Zinc.',
             'uses' => 'Multi-vitamins supported with Omega-3 to support healthy growth and brain.',
             'dose' => '5 ml three times daily.'],
            ['cat' => 'child-neonates', 'slug' => 'three-agar', 'name' => 'Three Agar', 'form' => 'Oral Drops 20 ml', 'image' => null, 'is_featured' => false,
             'description' => 'Agar-agar extract for management of indirect hyperbilirubinemia and infant jaundice.',
             'composition' => 'Agar-Agar Extract 983 mg.',
             'uses' => 'Management of indirect hyperbilirubinemia. Decrease infant jaundice.',
             'dose' => '½ ml daily.'],
            ['cat' => 'child-neonates', 'slug' => 'ivy-nutra', 'name' => 'IVY Nutra', 'form' => 'Syrup 120 ml', 'image' => null, 'is_featured' => true,
             'description' => 'Ivy leaf + N-acetyl cysteine + zinc for productive cough.',
             'composition' => 'IVY Leaf Extract, N-acetyl cysteine, Zinc.',
             'uses' => 'Treatment of productive cough.',
             'dose' => '5 ml three times daily.'],
            ['cat' => 'child-neonates', 'slug' => 'three-ivy', 'name' => 'Three Ivy', 'form' => 'Syrup 120 ml', 'image' => null, 'is_featured' => false,
             'description' => 'Ivy leaf, licorice root and thyme leaf extract for cough.',
             'composition' => 'IVY Leaf Extract, Licorice Root Extract, Thyme Leaf Extract.',
             'uses' => 'Treatment of cough.',
             'dose' => '5 ml three times daily.'],

            // ========== Pregnant & Women Care (9) ==========
            ['cat' => 'pregnant-women', 'slug' => 'ovawomen', 'name' => 'Ovawomen', 'form' => 'Tablet — Jar 20 tablets', 'image' => null, 'is_featured' => false,
             'description' => 'Myo-inositol + D-chiro inositol for fertility and ovulatory function.',
             'composition' => 'Myo-inositol 500 mg, D-chiro inositol 12.5 mg, Vitamin D 200 IU, Folate 85 mg, Zinc 2 mg.',
             'uses' => 'Increase fertilization rate. Improvement of insulin resistance. Restore ovulatory function. Improving IVF & ICSI outcomes.',
             'dose' => 'Once or twice daily.'],
            ['cat' => 'pregnant-women', 'slug' => 'feraminx-fe', 'name' => 'Feraminx Fe', 'form' => 'Tablet — Jar 20 tablets', 'image' => null, 'is_featured' => false,
             'description' => 'Ferrous bisglycinate chelate + lactoferrin + folic acid + Vitamin C for iron-deficiency anaemia.',
             'composition' => 'Ferrous Bisglycinate Chelate 73 mg, Lactoferrin 50 mg, Folic acid 400 mcg, Vit. C 100 mg.',
             'uses' => 'Treatment of iron deficiency anaemia, nutritional deficiency.',
             'dose' => 'Once or twice daily.'],
            ['cat' => 'pregnant-women', 'slug' => 'calcidol', 'name' => 'Calcidol Calcium', 'form' => 'Tablet — Jar 20 tablets', 'image' => null, 'is_featured' => false,
             'description' => 'Calcium + zinc + magnesium + vitamin D3 + selenium for pregnant/lactating women.',
             'composition' => 'Calcium 600 mg, Zinc 3 mg, Magnesium 100 mg, Vitamin D3 300 IU, Selenium 0.04 mg.',
             'uses' => 'Pregnant and lactating women. Muscle cramps. Osteoporosis.',
             'dose' => 'Once or twice daily.'],
            ['cat' => 'pregnant-women', 'slug' => 'umega-d', 'name' => 'Umega D', 'form' => 'Capsule — Jar 20 capsules', 'image' => null, 'is_featured' => false,
             'description' => 'Omega-3 with DHA, EPA and Vitamin D3 for fertility and pregnancy support.',
             'composition' => 'Omega-3 600 mg (DHA 216 mg, EPA 324 mg), Vitamin D3 400 IU.',
             'uses' => 'Male and female infertility. Prevention of placental insufficiency complications. Maternal depression control. Metabolic disorders in diabetes & hypertriglyceridemia. Respiratory immunization.',
             'dose' => 'Once or twice daily.'],
            ['cat' => 'pregnant-women', 'slug' => 'uhans-cde', 'name' => 'Uhans CDE', 'form' => 'Tablet — Jar 20 tablets', 'image' => null, 'is_featured' => false,
             'description' => 'Zinc + Vit. D3 + Vit. C + Cu + Selenium + Lactoferrin for fertility and immunity.',
             'composition' => 'Zinc 2.5 mg, Vit. D3 1000 IU, Vit. C 40 mg, Cu 250 mcg, Selenium 15 mg, Lactoferrin 10 mg.',
             'uses' => 'Male & female infertility, diabetic complications, anti-viral activity, anti-bacterial effect, general antioxidant.',
             'dose' => 'Once or twice daily.'],
            ['cat' => 'pregnant-women', 'slug' => 'olvitaamin', 'name' => 'Olvitaamin', 'form' => 'Tablet — Jar 20 tablets', 'image' => null, 'is_featured' => false,
             'description' => 'Benfotiamine + B12 + B6 + Methylfolate for neural tube defect and neuropathic pain.',
             'composition' => 'Benfotiamine 75 mg, Vit. B12 1000 mcg, Vit. B6 1000 mg, Methylfolate 1000 mcg.',
             'uses' => 'Neural tube defect. Neuropathic pain. Vitamin B deficiency. Diabetic neuropathy.',
             'dose' => 'Once or twice daily.'],
            ['cat' => 'pregnant-women', 'slug' => 'bloximin', 'name' => 'Bloximin', 'form' => 'Capsule — Box 30 capsules', 'image' => null, 'is_featured' => false,
             'description' => 'Diosmin + hesperidin for dysfunctional uterine bleeding and venous insufficiency.',
             'composition' => 'Diosmin 450 mg, Hesperidin 50 mg.',
             'uses' => 'Dysfunctional uterine bleeding. Intrauterine device bleeding. Chronic venous insufficiency. Hemorrhoids. Varicoceles.',
             'dose' => 'Once or twice daily.'],
            ['cat' => 'pregnant-women', 'slug' => 'herba-mam', 'name' => 'Herba Mam', 'form' => 'Capsule — 30 capsules', 'image' => null, 'is_featured' => false,
             'description' => 'Fenugreek + blessed thistle + fennel seed for breastfeeding mothers (galactagogue).',
             'composition' => 'Fenugreek seed extract, Blessed thistle extract, Fennel seed powder.',
             'uses' => 'Galactagogue (promotes lactation).',
             'dose' => 'Once or twice daily.'],

            // ========== Pain Management & Anti-inflammatory (11) ==========
            ['cat' => 'pain-management', 'slug' => '3-fly-300', 'name' => '3 Fly 300/400', 'form' => 'Tablet — 2 strips 20 tablets', 'image' => null, 'is_featured' => false,
             'description' => 'Palmitoylethanolamide for chronic pelvic pain and immune modulation.',
             'composition' => 'Palmitoylethanolamide 300 mg / 400 mg.',
             'uses' => 'Chronic pelvic pain. Immune system modulation. Postherpetic neuralgia and vaginal pains.',
             'dose' => 'Once or twice daily.'],
            ['cat' => 'pain-management', 'slug' => '3-fly-600', 'name' => '3 Fly 600/1200', 'form' => 'Tablet — 2 strips 20 tablets', 'image' => null, 'is_featured' => false,
             'description' => 'High-dose palmitoylethanolamide for peripheral neuropathy and sciatic pain.',
             'composition' => 'Palmitoylethanolamide 600 mg / 1200 mg.',
             'uses' => 'Peripheral neuropathy. Carpal tunnel syndrome. Sciatic pain. Neuropathic pain in stroke and multiple sclerosis.',
             'dose' => 'Once or twice daily.'],
            ['cat' => 'pain-management', 'slug' => 'trypsalin', 'name' => 'Trypsalin', 'form' => 'Tablet — 2 strips 20 tablets', 'image' => null, 'is_featured' => true,
             'description' => 'Anti-inflammatory enzyme blend with trypsin, bromelain and rutoside.',
             'composition' => 'Trypsin 41 mg, Bromelain 90 mg, Rutoside 100 mg.',
             'uses' => 'Anti-inflammatory, anti-edematous.',
             'dose' => 'Once or twice daily.'],
            ['cat' => 'pain-management', 'slug' => 'trypsalin-plus', 'name' => 'Trypsalin Plus', 'form' => 'Tablet — 2 strips 20 tablets', 'image' => null, 'is_featured' => false,
             'description' => 'Enhanced enzyme blend with carica papaya and alpha amylase.',
             'composition' => 'Trypsin 37.5 mg, Bromelain 125 mg, Carica papaya 62 mg, Alpha Amylase 50 mg.',
             'uses' => 'Anti-inflammatory, anti-edematous.',
             'dose' => 'Once daily.'],
            ['cat' => 'pain-management', 'slug' => 'trypsalin-advance', 'name' => 'Trypsalin Advance', 'form' => 'Tablet — 2 strips 20 tablets', 'image' => null, 'is_featured' => false,
             'description' => 'Advanced enzyme blend with pancreatin, papain, rutin and serrapeptase.',
             'composition' => 'Pancreatin 500 mg, Trypsin 125 mg, Bromelain 225 mg, Papain 300 mg, Rutin 250 mg, Serrapeptase 99 mg.',
             'uses' => 'Anti-inflammatory, anti-edematous.',
             'dose' => 'Once daily.'],
            ['cat' => 'pain-management', 'slug' => 'trypsalin-compound', 'name' => 'Trypsalin Compound', 'form' => 'Tablet — 2 strips 20 tablets', 'image' => null, 'is_featured' => false,
             'description' => 'Compound enzyme blend with L-leucine for inflammation control.',
             'composition' => 'Trypsin 82 mg, Bromelain 180 mg, Papain 300 mg, Rutoside 200 mg, L-Leucine 30 mg.',
             'uses' => 'Anti-inflammatory, anti-edematous.',
             'dose' => 'Once daily.'],
            ['cat' => 'pain-management', 'slug' => 'sp-whites', 'name' => 'SP Whites', 'form' => 'Tablet — 2 strips 20 tablets', 'image' => null, 'is_featured' => false,
             'description' => 'Serrapeptase + boswellia + turmeric + bromelain + papaya for inflammation.',
             'composition' => 'Serrapeptase 133 mg, Boswellia ext. 50 mg, Turmeric 100 mg, Bromelain 100 mg, Carica papaya 150 mg.',
             'uses' => 'Anti-inflammatory, anti-edematous.',
             'dose' => 'Once daily.'],
            ['cat' => 'pain-management', 'slug' => '7calm', 'name' => '7Calm', 'form' => 'Tablet — 3 strips 30 tablets', 'image' => null, 'is_featured' => false,
             'description' => 'Quercetin + N-acetylcysteine + Vit. C + nettle + bromelain for respiratory health.',
             'composition' => 'Quercetin, N-Acetylcysteine, Vitamin C, Nettle Leaf (Silica), Bromelain, Rutin, Dihydroquercetin, Ivy Extract.',
             'uses' => 'Supports healthy respiratory function.',
             'dose' => 'Once daily.'],
            ['cat' => 'pain-management', 'slug' => 'nt-300', 'name' => 'NT 300', 'form' => 'Tablet — 2 strips 20 tablets', 'image' => null, 'is_featured' => false,
             'description' => 'Alpha lipoic acid + benfotiamine + B-vitamins + D3 for neuropathic pain.',
             'composition' => 'Alpha Lipoic Acid 300 mg, Benfotiamine 75 mg, Vit. B12 500 mcg, Vit. B6 16 mg, Vitamin D3 500 mcg.',
             'uses' => 'Management & treatment of neuropathic pain; normal health for nerves.',
             'dose' => 'Twice daily.'],
            ['cat' => 'pain-management', 'slug' => 'nt-600', 'name' => 'NT 600', 'form' => 'Capsule — 2 strips 20 capsules', 'image' => null, 'is_featured' => false,
             'description' => 'High-strength alpha lipoic acid + benfotiamine + B-vitamins + D3.',
             'composition' => 'Alpha Lipoic Acid 600 mg, Benfotiamine 150 mg, Vit. B12 1000 mcg, Vit. B6 25 mg, Vitamin D3 1000 mcg.',
             'uses' => 'Management & treatment of neuropathic pain; normal health for nerves.',
             'dose' => 'Twice daily.'],

            // ========== Neuro Support (4) ==========
            ['cat' => 'neuro-support', 'slug' => 'colifly-500', 'name' => 'ColiFly 500', 'form' => '30 Film-Coated Tablets', 'image' => null, 'is_featured' => true,
             'description' => 'Citicoline 500 mg supporting cognitive function.',
             'composition' => 'Citicoline 500 mg.',
             'uses' => 'Supports cognitive function.',
             'dose' => 'Up to 2 g/day.'],
            ['cat' => 'neuro-support', 'slug' => 'colifly-plus-500', 'name' => 'ColiFly Plus 500', 'form' => '30 Film-Coated Tablets', 'image' => null, 'is_featured' => false,
             'description' => 'Citicoline + Ginkgo biloba for enhanced cognitive support.',
             'composition' => 'Citicoline 500 mg, Ginkgo biloba 100 mg.',
             'uses' => 'Supports cognitive function.',
             'dose' => 'Up to 2 g/day.'],
            ['cat' => 'neuro-support', 'slug' => 'colifly-1000', 'name' => 'ColiFly 1000', 'form' => '30 Film-Coated Tablets', 'image' => null, 'is_featured' => false,
             'description' => 'High-strength citicoline 1000 mg for cognitive support.',
             'composition' => 'Citicoline 1000 mg.',
             'uses' => 'Supports cognitive function.',
             'dose' => 'Up to 2 g/day.'],
            ['cat' => 'neuro-support', 'slug' => 'colifly-syrup', 'name' => 'ColiFly Syrup', 'form' => 'Syrup 120 ml', 'image' => null, 'is_featured' => false,
             'description' => 'Citicoline 250 mg syrup form for cognitive function support.',
             'composition' => 'Citicoline 250 mg.',
             'uses' => 'Supports cognitive function.',
             'dose' => 'Up to 2 g/day.'],

            // ========== Bone Care (6) ==========
            ['cat' => 'bone', 'slug' => 'cartino-plus', 'name' => 'Cartino Plus', 'form' => 'Capsule — 20 caps', 'image' => null, 'is_featured' => true,
             'description' => 'Chicken collagen + glucosamine + MSM + chondroitin + hyaluronic acid for osteoarthritis.',
             'composition' => 'Chicken Collagen 200 mg, Glucosamine HCl 180 mg, MSM 167 mg, Chondroitin sulfate 50 mg, Hyaluronic acid 20 mg, Curcuma 25 mg, Bromelain 6 mg.',
             'uses' => 'Osteoarthritis management.',
             'dose' => 'Once daily.'],
            ['cat' => 'bone', 'slug' => 'cartino-new', 'name' => 'Cartino New', 'form' => 'Sachet — 10 sachets', 'image' => null, 'is_featured' => false,
             'description' => 'Marine collagen + Vit. C sachets for joint and skin health.',
             'composition' => 'Marine Collagen 10 g, Vitamin C 90 mg.',
             'uses' => 'Osteoarthritis management.',
             'dose' => 'One sachet daily.'],
            ['cat' => 'bone', 'slug' => 'moonflex', 'name' => 'Moonflex Tablet', 'form' => 'Tablet — 30 tablets', 'image' => null, 'is_featured' => false,
             'description' => 'Glucosamine + chondroitin + MSM for osteoarthritis and joint health.',
             'composition' => 'Glucosamine HCl 750 mg, Chondroitin Sulphate 200 mg, MSM 500 mg.',
             'uses' => 'Osteoarthritis management.',
             'dose' => 'Once daily.'],
            ['cat' => 'bone', 'slug' => 'three-n-10000', 'name' => 'Three N 10,000 I.U.', 'form' => 'Tablet — 30 tablets', 'image' => null, 'is_featured' => false,
             'description' => 'High-dose Vitamin D3 for deficiency and osteoporosis management.',
             'composition' => 'Vitamin D3 (Cholecalciferol) 10,000 I.U.',
             'uses' => 'Vitamin D deficiency. Osteoporosis management. Hypoparathyroidism.',
             'dose' => 'Once daily.'],
            ['cat' => 'bone', 'slug' => 'hicool-massage', 'name' => 'Hicool Massage', 'form' => 'Cream — 120 g', 'image' => null, 'is_featured' => false,
             'description' => 'Cooling massage cream for sprains, strains and low-back pain.',
             'composition' => 'Menthol 2%, Camphor 1%, Eucalyptus 2%.',
             'uses' => 'Massage cream for strains, sprains, low back pain.',
             'dose' => 'Apply a thin layer to the skin and rub gently twice daily.'],
            ['cat' => 'bone', 'slug' => 'dolarex-massage', 'name' => 'Dolarex Massage', 'form' => 'Cream — 120 g', 'image' => null, 'is_featured' => false,
             'description' => 'Warming massage cream with capsicum for muscular discomfort.',
             'composition' => 'Menthol 2%, Camphor 1%, Eucalyptus 2%, Capsicum 1%.',
             'uses' => 'Massage cream for strains, sprains, low back pain.',
             'dose' => 'Apply a thin layer to the skin and rub gently twice daily.'],

            // ========== Antioxidant & Immunity (2) ==========
            ['cat' => 'antioxidant-immunity', 'slug' => 'sodi-sachet', 'name' => 'Sodi Sachet', 'form' => 'Sachet — 20 sachets', 'image' => null, 'is_featured' => true,
             'description' => 'Multivitamin and mineral sachet for immune enhancement.',
             'composition' => 'Vitamin C 1000 mg, Zinc 15 mg, Vitamin D3 1200 IU, Selenium 80 mcg, Beta-Carotene 2 mg, Vitamin E 20 mg.',
             'uses' => 'Immune enhancer. Treatment of recurrent infection.',
             'dose' => 'One to two sachets daily.'],
            ['cat' => 'antioxidant-immunity', 'slug' => 'vitosel-sachet', 'name' => 'Vitosel Sachet', 'form' => 'Sachet — 14 sachets', 'image' => null, 'is_featured' => false,
             'description' => 'Lactoferrin + zinc + Vit. C + selenium for immunity and iron support.',
             'composition' => 'Lactoferrin 100 mg, Zinc 12 mg, Vitamin C 80 mg, Selenium.',
             'uses' => 'Immune enhancer. Treatment of iron-deficiency anaemia, anti-viral activity, anti-bacterial effect.',
             'dose' => 'One to two sachets daily.'],

            // ========== GIT & Gut Health (2) ==========
            ['cat' => 'git-gut-health', 'slug' => 'stomicope', 'name' => 'Stomicope', 'form' => 'Capsule — 30 capsules', 'image' => null, 'is_featured' => true,
             'description' => 'Esomeprazole pellets for heartburn and erosive esophagitis.',
             'composition' => 'Esomeprazole pellets 40 mg.',
             'uses' => 'Treatment of heartburn. Healing of erosive esophagitis.',
             'dose' => 'One to two capsules daily.'],
            ['cat' => 'git-gut-health', 'slug' => 'lc-flora', 'name' => 'L.C. Flora', 'form' => 'Capsule — 20 capsules', 'image' => null, 'is_featured' => false,
             'description' => 'Probiotic + zinc capsules for GIT health and intestinal flora balance.',
             'composition' => 'Lactobacillus Reuteri 100 mg, Zinc 16 mg.',
             'uses' => 'GIT health. Helps regulate and maintain the balance of intestinal flora.',
             'dose' => 'One to two capsules daily.'],

            // ========== Skin Care (1) ==========
            ['cat' => 'skin-care', 'slug' => 'biotin-one', 'name' => 'Biotin One', 'form' => 'Tablet — 30 tablets', 'image' => null, 'is_featured' => true,
             'description' => 'Biotin + collagen + keratin + selenium + zinc for hair, nail and skin care.',
             'composition' => 'Biotin 10,000 mcg, Collagen, Keratin, Selenium, Zinc.',
             'uses' => 'For hair, nail and skin care & health.',
             'dose' => 'One to two tablets daily.'],
        ];

        $sortOrder = 0;
        foreach ($products as $p) {
            $category = Category::where('slug', $p['cat'])->firstOrFail();
            $sortOrder++;

            Product::updateOrCreate(
                ['slug' => $p['slug']],
                [
                    'category_id' => $category->id,
                    'name'        => $p['name'],
                    'form'        => $p['form'],
                    'image'       => $resolveImg($p['slug']),
                    'description' => $p['description'],
                    'composition' => $p['composition'] ?? null,
                    'uses'        => $p['uses'] ?? null,
                    'dose'        => $p['dose'] ?? null,
                    'is_featured' => $p['is_featured'] ?? false,
                    'is_active'   => true,
                    'sort_order'  => $sortOrder,
                ]
            );
        }
    }
}
