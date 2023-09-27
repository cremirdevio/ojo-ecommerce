<?php

namespace Database\Seeders;

use App\Models\PaymentPlatform;
use Illuminate\Database\Seeder;

class PaymentPlatformsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentPlatform::query()->firstOrCreate([
            'name' => 'PayPal',
            'slug' => 'paypal',
            'image' => 'paypal.png'
        ]);

        PaymentPlatform::query()->firstOrCreate([
            'name' => 'Stripe',
            'slug' => 'stripe',
            'image' => 'payment-method.png'
        ]);

        PaymentPlatform::query()->firstOrCreate([
            'name' => 'Razorpay',
            'slug' => 'razorpay',
            'image' => 'razorpay.png'
        ]);

        PaymentPlatform::query()->firstOrCreate([
            'name' => 'Bank',
            'slug' => 'bank',
            'image' => 'bank.png'
        ]);

        PaymentPlatform::query()->firstOrCreate([
            'name' => 'Sslcommerz',
            'slug' => 'sslcommerz',
            'image' => 'sslcommerz.png'
        ]);

        PaymentPlatform::query()->firstOrCreate([
            'name' => 'Flutterwave',
            'slug' => 'flutterwave',
            'image' => ''
        ]);
    }
}
