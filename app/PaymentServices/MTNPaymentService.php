<?php

namespace App\PaymentServices;

class MTNPaymentService
{
    public function processPayment($amount, $phoneNumber)
    {
        // Simulate API request for MTN
        $response = [
            'status' => 'success', // or 'failure'
            // 'transaction_id' => 'MTN123456789',
            'transaction_id' => uniqid(),
        ];

        return $response;
    }
}
