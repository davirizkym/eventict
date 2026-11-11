<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Cyber Security',
                'description' => 'Keamanan siber, ethical hacking, digital forensics, analisis kerentanan, dan pertahanan jaringan komputer.',
                'icon' => 'shield',
                'color' => 'blue',
            ],
            [
                'name' => 'Kecerdasan Buatan & Data Science',
                'description' => 'Machine learning, generative AI, deep learning, NLP, data analytics, dan analitika data modern.',
                'icon' => 'cpu',
                'color' => 'purple',
            ],
            [
                'name' => 'Pengembangan Web & Mobile',
                'description' => 'Fullstack development, arsitektur REST API, framework modern (Laravel, React, Flutter), dan mobile apps.',
                'icon' => 'code',
                'color' => 'emerald',
            ],
            [
                'name' => 'Cloud Computing & DevOps',
                'description' => 'Infrastruktur cloud (AWS/GCP/Azure), containerization Docker, orkestrasi Kubernetes, dan CI/CD automation.',
                'icon' => 'server',
                'color' => 'sky',
            ],
            [
                'name' => 'UI/UX & Desain Produk',
                'description' => 'User experience research, design system, usability testing, wireframing, dan prototyping interaktif Figma.',
                'icon' => 'palette',
                'color' => 'pink',
            ],
            [
                'name' => 'Jaringan Komputer & IoT',
                'description' => 'Konfigurasi routing & switching, mikrotik, cisco networking, sensor pintar, dan implementasi Internet of Things.',
                'icon' => 'globe',
                'color' => 'amber',
            ],
            [
                'name' => 'Teknologi & Rekayasa',
                'description' => 'Rekayasa perangkat lunak, sistem cerdas, dan penerapan teknologi rekayasa modern.',
                'icon' => 'terminal',
                'color' => 'blue',
            ],
            [
                'name' => 'Kedokteran & Kesehatan',
                'description' => 'Informatika medis, telemedicine, regulasi kesehatan, dan bioinformatika modern.',
                'icon' => 'shield',
                'color' => 'emerald',
            ],
            [
                'name' => 'Hukum & Kebijakan',
                'description' => 'Etika siber, regulasi digital, kepatuhan hukum, dan tata kelola privasi data.',
                'icon' => 'book',
                'color' => 'purple',
            ],
            [
                'name' => 'Ekonomi & Bisnis',
                'description' => 'Manajemen produk startup, akselerasi bisnis teknologi, dan transformasi digital finansial.',
                'icon' => 'briefcase',
                'color' => 'amber',
            ],
        ];

        foreach ($categories as $cat) {
            $createdCat = Category::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'description' => $cat['description'],
                    'icon' => $cat['icon'],
                    'color' => $cat['color'],
                ]
            );

            Event::where('category', $cat['name'])
                ->whereNull('category_id')
                ->update(['category_id' => $createdCat->id]);
        }
    }
}
