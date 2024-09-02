<?php

namespace App\PaymentServices;

class MoovPaymentService
{
    public function processPayment($amount, $phoneNumber)
    {
        // Simulate API request for Moov
        $response = [
            'status' => 'success', // or 'failure'
            // 'transaction_id' => 'MOOV123456789',
            'transaction_id' => uniqid(),
        ];

        return $response;
    }
}
