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
        // Disable foreign key checks to avoid constraint violations
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear the categories table
        DB::table('categories')->truncate(); // Resets auto-increment

        // Enable foreign key checks again
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

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
