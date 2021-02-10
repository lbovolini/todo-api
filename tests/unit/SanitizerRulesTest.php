<?php

declare(strict_types=1);

namespace unit;


use App\Validations\SanitizerRules;
use CodeIgniter\Test\CIUnitTestCase;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

class SanitizerRulesTest extends CIUnitTestCase {

    private SanitizerRules $sanitizer;

    protected function setUp(): void {

        parent::setUp();

        $this->sanitizer = new SanitizerRules();
    }

    // is_sanitized_number method test cases

    /**
     * @test
     */
    public function shouldValidateWithZeroAsInput(): void {

        $validInput = 0;

        // Should test ONLY this method
        $isValid = $this->sanitizer->is_sanitized_number($validInput);

        // Assertions
        $this->assertTrue($isValid);
    }

    /**
     * @test
     */
    public function shouldValidateWithNegativeNumberAsInput(): void {

        $validInput = -9_223_372_036_854_775_807;

        // Should test ONLY this method
        $isValid = $this->sanitizer->is_sanitized_number($validInput);

        // Assertions
        $this->assertTrue($isValid);
    }

    /**
     * @test
     */
    public function shouldValidateWithPositiveNumberAsInput(): void {

        $validInput = 9_223_372_036_854_775_807;

        // Should test ONLY this method
        $isValid = $this->sanitizer->is_sanitized_number($validInput);

        // Assertions
        $this->assertTrue($isValid);
    }

    /**
     * @test
     */
    public function shouldThrowTypeErrorWhenInputWithNegativeThatExceedsLongMinValue(): void {

        $validInput = -9_223_372_036_854_775_808;

        // Assertions
        $this->expectException(\TypeError::class);

        // Should test ONLY this method
        $isValid = $this->sanitizer->is_sanitized_number($validInput);
    }

    /**
     * @test
     */
    public function shouldThrowTypeErrorWhenInputWithPositiveThatExceedsLongMaxValue(): void {

        $validInput = 9_223_372_036_854_775_808;

        // Assertions
        $this->expectException(\TypeError::class);

        // Should test ONLY this method
        $isValid = $this->sanitizer->is_sanitized_number($validInput);
    }


    // is_sanitized_string method test cases

    /**
     * @test
     */
    public function shouldValidateWithSanitizedString(): void {

        $validInput = 'Lucas';

        // Should test ONLY this method
        $isValid = $this->sanitizer->is_sanitized_string($validInput);

        // Assertions
        $this->assertTrue($isValid);
    }

    /**
     * @test
     */
    public function shouldValidateWithStringWithEspecialPersonNameCharacters(): void {

        $validInput = 'Smithʼs Müller';

        // Should test ONLY this method
        $isValid = $this->sanitizer->is_sanitized_string($validInput);

        // Assertions
        $this->assertTrue($isValid);
    }

    /**
     * @test
     */
    public function shouldNotValidateWithNotSanitizedString(): void {

        $validInput = "Luc'as";

        // Should test ONLY this method
        $isValid = $this->sanitizer->is_sanitized_string($validInput);

        // Assertions
        $this->assertFalse($isValid);
    }


    // is_sanitized_email method test cases

    /**
     * @test
     */
    public function shouldValidateWithValidEmail(): void {

        $validInput = 'lbovolini94@gmail.com';

        // Should test ONLY this method
        $isValid = $this->sanitizer->is_sanitized_email($validInput);

        // Assertions
        $this->assertTrue($isValid);
    }

    /**
     * @test
     */
    public function shouldNotValidateWithInvalidEmail(): void {

        $validInput = 'ç@gmail.com';

        // Should test ONLY this method
        $isValid = $this->sanitizer->is_sanitized_email($validInput);

        // Assertions
        $this->assertFalse($isValid);
    }


    // required_in_update method test cases

    /**
     * @test
     */
    public function shouldRequireFieldInPatchRequest(): void {

        $id = null;

        $request = service('request');
        $request->setMethod('PATCH');

        // Should test ONLY this method
        $isNotRequiredOrIsPresent = $this->sanitizer->required_in_update($id);

        // Assertions
        assertFalse($isNotRequiredOrIsPresent);
    }

    /**
     * @test
     */
    public function shouldRequireFieldInPutRequest(): void {

        $id = null;

        $request = service('request');
        $request->setMethod('PUT');

        // Should test ONLY this method
        $isNotRequiredOrIsPresent = $this->sanitizer->required_in_update($id);

        // Assertions
        assertFalse($isNotRequiredOrIsPresent);
    }

    /**
     * @test
     */
    public function shouldNotRequireField(): void {

        $id = null;

        $request = service('request');
        $request->setMethod('POST');

        // Should test ONLY this method
        $isNotRequiredOrIsPresent = $this->sanitizer->required_in_update($id);

        // Assertions
        assertTrue($isNotRequiredOrIsPresent);
    }
}