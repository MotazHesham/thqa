<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name' => 'الرياض', 'country_id' => 188],
            ['name' => 'جدة', 'country_id' => 188],
            ['name' => 'مكة', 'country_id' => 188],
            ['name' => 'المدينة المنورة', 'country_id' => 188],
            ['name' => 'الدمام', 'country_id' => 188],
            ['name' => 'الخبر', 'country_id' => 188],
            ['name' => 'تبوك', 'country_id' => 188],
            ['name' => 'بريدة', 'country_id' => 188],
            ['name' => 'القطيف', 'country_id' => 188],
            ['name' => 'الظهران', 'country_id' => 188],
            ['name' => 'الهفوف', 'country_id' => 188],
            ['name' => 'أبها', 'country_id' => 188],
            ['name' => 'خميس مشيط', 'country_id' => 188],
            ['name' => 'حائل', 'country_id' => 188],
            ['name' => 'جازان', 'country_id' => 188],
            ['name' => 'نجران', 'country_id' => 188],
            ['name' => 'الخبر', 'country_id' => 188],
            ['name' => 'ينبع', 'country_id' => 188],
            ['name' => 'الباحة', 'country_id' => 188],
            ['name' => 'الجبيل', 'country_id' => 188],
            ['name' => 'الأحساء', 'country_id' => 188],
            ['name' => 'القريات', 'country_id' => 188],
            ['name' => 'عرعر', 'country_id' => 188],
            ['name' => 'المجمعة', 'country_id' => 188],
            ['name' => 'الدرعية', 'country_id' => 188],
            ['name' => 'تربة', 'country_id' => 188],
            ['name' => 'بيشة', 'country_id' => 188],
            ['name' => 'النماص', 'country_id' => 188],
            ['name' => 'رابغ', 'country_id' => 188],
            ['name' => 'المذنب', 'country_id' => 188],
            ['name' => 'البكيرية', 'country_id' => 188],
            ['name' => 'الزلفي', 'country_id' => 188],
            ['name' => 'القنفذة', 'country_id' => 188],
            ['name' => 'الخرج', 'country_id' => 188],
            ['name' => 'الدوادمي', 'country_id' => 188],
            ['name' => 'الوجه', 'country_id' => 188],
            ['name' => 'ضباء', 'country_id' => 188],
            ['name' => 'تيماء', 'country_id' => 188],
            ['name' => 'عفيف', 'country_id' => 188],
            ['name' => 'القويعية', 'country_id' => 188],
            ['name' => 'الحناكية', 'country_id' => 188],
            ['name' => 'النعيرية', 'country_id' => 188],
            ['name' => 'المندق', 'country_id' => 188],
            ['name' => 'السليل', 'country_id' => 188],
            ['name' => 'الليث', 'country_id' => 188],
            ['name' => 'الحائط', 'country_id' => 188],
            ['name' => 'رفحاء', 'country_id' => 188],
            ['name' => 'بدر', 'country_id' => 188],
            ['name' => 'حوطة بني تميم', 'country_id' => 188],
            ['name' => 'شرورة', 'country_id' => 188],
        ];

        City::insert($cities);
    }
}
