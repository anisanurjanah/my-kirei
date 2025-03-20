<?php

if (!function_exists('formatPhone')) {
    function formatPhone($phone) {
        $phoneNumber = preg_replace('/[^\d]/', '', $phone);
    
        if (substr($phoneNumber, 0, 2) === "62") {
            $phoneNumber = substr($phoneNumber, 2);
        }
    
        if (strlen($phoneNumber) >= 10) {
            return substr($phoneNumber, 0, 3) . '-' . substr($phoneNumber, 3, 4) . '-' . substr($phoneNumber, 7);
        }
    
        return $phoneNumber;
    }
}