<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Enums\DocumentEnum;
use App\Models\Document;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (DocumentEnum::cases() as $case) {
            Document::create([
                'code' => $case->name,
                'description' => $case->value,
            ]);
        }
    }
}
