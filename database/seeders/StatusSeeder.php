<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            'pending',
            'Payment Confirmed',
            'Processing',
            'Shipped',
            'Delivered',
            'Cancelled',
            'Refunded',
        ];

        foreach ($statuses as $name) {
            Status::firstOrCreate(['name' => $name]);
        }
    }
}
