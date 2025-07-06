<?php

if (!function_exists('validateString')) {

    function validateString(
        $cadena = '',
        $max = 50
    ): bool {
        return is_null($cadena) || preg_match('/^.{0,' . $max . '}$/', $cadena);
    }
}
