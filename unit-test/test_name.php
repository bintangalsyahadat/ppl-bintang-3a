<?php

require_once 'Validator.php';

// Test Case 1: nama lengkap valid (huruf saja)
try {
    validateName('Bintang Aji');
    echo "PASS: Nama lengkap 'Bintang Aji' diterima\n";
} catch (Exception $e) {
    echo "FAIL: Nama lengkap tidak diterima. Error: " . $e->getMessage() . "\n";
}

// Test Case 2: nama mengandung angka (1212)
try {
    validateName('Bintang1212');
    echo "FAIL: Nama dengan angka 1212 diterima\n";
} catch (Exception $e) {
    echo "PASS: Nama dengan angka 1212 tidak diterima. Error: " . $e->getMessage() . "\n";
}

// Test Case 3: nama hanya angka (1212)
try {
    validateName('1212');
    echo "FAIL: Nama hanya angka '1212' diterima\n";
} catch (Exception $e) {
    echo "PASS: Nama hanya angka '1212' tidak diterima. Error: " . $e->getMessage() . "\n";
}

// Test Case 4: data kosong
try {
    validateName('');
    echo "FAIL: Nama kosong diterima\n";
} catch (Exception $e) {
    echo "PASS: Nama kosong tidak diterima. Error: " . $e->getMessage() . "\n";
}

// Test Case 5: hanya spasi (dianggap kosong)
try {
    validateName('   ');
    echo "FAIL: Nama berisi spasi saja diterima\n";
} catch (Exception $e) {
    echo "PASS: Nama berisi spasi saja tidak diterima. Error: " . $e->getMessage() . "\n";
}
