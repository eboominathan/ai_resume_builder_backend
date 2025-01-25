<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Voter Id',
            'Aadhar',
            'Xerox',
            'Train Ticket',
            'Document Writing',
            'PAN',
            'PF Claim',
            'EC',
            'EB BILL',
            'SCAN',
            'ID CARD Print',
            'Online Exam',
            'Lamination',
            'Photo',
            'Patta / Chitta',
            'Mobile Recharge',
            'File',
            'Form Filling',
            'LLR',
            'Ration Card',
            'Money transfer',
            'Passport',
            'Education Loan',
            'Bus Booking',
            'Aadhar PVC',
            'PVC CARD',
            'Jeevan Praman',
            'Dish Recharge',
            'Protector',
            'UDID',
            'MSME',
            'ABHA',
            'Ayushman card',
            'Police Verification',
            'TAX',
            'Certificate',
            'Tirupathi Ticket',
            'Bank Statement'
        ];

        $timestamp = Carbon::now();

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ]);
        }
    }
}
