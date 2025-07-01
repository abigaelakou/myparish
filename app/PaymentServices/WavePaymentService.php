<?php

namespace App\PaymentServices;

class WavePaymentService
{
    public function processPayment($amount, $phoneNumber)
    {
        // Simulate API request for Wave
        $response = [
            'status' => 'success', // or 'failure'
            // 'transaction_id' => 'Wave123456789',
            'transaction_id' => uniqid(),
        ];

        return $response;
    }
}
