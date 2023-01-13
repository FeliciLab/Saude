<?php

namespace Saude\Utils;

class Validation
{
    public static function checkValidDocument($document)
    {
        // Extrai somente os números
        $document = preg_replace('/[^0-9]/is', '', $document);

        // Verifica se o documento está completo
        if (strlen($document) !== 11) return false;

        // Verifica se o documento é uma sequência de números iguais
        if (preg_match('/(\d)\1{10}/', $document)) return false;

        // Faz o calculo para validar o CPF
        for ($digits = 9; $digits < 11; $digits++) {
            for ($sum_digits = 0, $digit_index = 0; $digit_index < $digits; $digit_index++) {
                $sum_digits += $document[$digit_index] * (($digits + 1) - $digit_index);
            }

            $sum_digits = ((10 * $sum_digits) % 11) % 10;

            if ($document[$digit_index] != $sum_digits) return false;
        }

        return true;
    }
}
