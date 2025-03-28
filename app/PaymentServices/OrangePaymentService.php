<?php

namespace App\PaymentServices;

class OrangePaymentService
{
    public function processPayment($amount, $phoneNumber)
    {
        // Simulate API request for Orange
        $response = [
            'status' => 'success', // or 'failure'
            // 'transaction_id' => 'ORANGE123456789',
            'transaction_id' => uniqid(),
        ];

        return $response;
    }
}
