<?php

use PHPUnit\Framework\TestCase;

require_once "Validator.php";

class ValidatorTest extends TestCase {
    public function testValidAge() {
        $this->assertTrue(validateAge(30));
        $this->assertFalse(validateAge(-30));
    }

    public function testEmptyAgeThrowException() {
        $this->expectException(InvalidArgumentException::class);
        validateAge("");
    }
}