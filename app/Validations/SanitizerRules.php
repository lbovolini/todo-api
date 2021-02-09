<?php

namespace App\Validations;

class SanitizerRules {

    public function is_sanitized_number($number) {       
        $sanitizedNumber = filter_var($number, FILTER_SANITIZE_NUMBER_INT);

        return $number == $sanitizedNumber;
    }

    public function is_sanitized_string($string) {
        $sanitizedString = filter_var($string, FILTER_SANITIZE_STRING);

        return strcmp($string, $sanitizedString) === 0;
    }

    public function is_sanitized_email($email) {
        $sanitizedEmail= filter_var($email, FILTER_SANITIZE_EMAIL);

        return strcmp($email, $sanitizedEmail) === 0;
    }

    public function required_in_update($data) {
        $request = service('request');
        $method = $request->getMethod();

        if (strcasecmp($method, 'PUT') === 0 || strcasecmp($method, 'PATCH') === 0) {
            return !is_null($data);
        }

        return true;
    }

}