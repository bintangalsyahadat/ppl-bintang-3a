<?php

require_once 'Validator.php';

// Test Case 1: umur valid
try {
    $result = validateAge(25);
    echo "PASS: Umur 25 diterima\n";
} catch (Exception $e) {
    echo "FAIL: Umur 25 tidak diterima. Error: " . $e->getMessage() . "\n";
}

// Test Case 2: umur negatif
try {
    $result = validateAge(-5);
    echo "FAIL: Umur negatif diterima\n";
} catch (Exception $e) {
    echo "PASS: Umur negatif tidak diterima. Error: " . $e->getMessage() . "\n";
}