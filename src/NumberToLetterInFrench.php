<?php

class NumberToLetterInFrench {
    private $frenchNumberWords;
    public function __construct() {
        $this->frenchNumberWords = [
            0 => "zéro", 1 => "un", 2 => "deux", 3 => "trois", 4 => "quatre", 5 => "cinq", 6 => "six", 7 => "sept",
            8 => "huit", 9 => "neuf", 10 => "dix", 11 => "onze", 12 => "douze", 13 => "treize", 14 => "quatorze",
            15 => "quinze", 16 => "seize", 17 => "dix-sept", 18 => "dix-huit", 19 => "dix-neuf", 20 => "vingt",
            30 => "trente", 40 => "quarante", 50 => "cinquante", 60 => "soixante", 70 => "soixante-dix",
            80 => "quatre-vingt", 90 => "quatre-vingt-dix", 100 => "cent", 1000 => "mille", 1000000 => "million",
            1000000000 => "milliard"
        ];
    }

    public function convert(int $number){
        if ($number < 0) {
            return "moins " . $this->convert(abs($number));
        }
    
        if (!is_numeric($number) || fmod($number, 1) != 0) {
            throw new InvalidArgumentException("Veuillez saisir un nombre entier valide");
        }
    
        $result = '';
    
        if ($number <= 20) {
            $result = $this->numberToLetterUnderTwenty($number);
        } elseif ($number < 100) {
            $result = $this->numberToLetterBetweenTwentyAndHundred($number);
        } elseif ($number < 1000) {
            $result = $this->numberToLetterBetweenHundredAndThousand($number);
        } elseif ($number < 1000000) {
            $result = $this->numberToLetterBetweenThousandAndMillion($number);
        } elseif ($number < 1000000000) {
            $result = $this->numberToLetterBetweenMillionAndBillion($number);
        } else {
            $result = $this->numberToLetterAboveBillion($number);
        }
    
        return $result;
    }

    private function numberToLetterUnderTwenty(int $number): string{
        return $this->frenchNumberWords[$number];
    }
    private function numberToLetterBetweenTwentyAndHundred(int $number): string{
        $base = 10 * floor($number / 10);
        $remainder = $number % 10;
        if ($remainder === 0) {
            return $this->frenchNumberWords[$base];
        }
        return $this->frenchNumberWords[$base] . '-' . $this->convert($remainder);
    }
    private function numberToLetterBetweenHundredAndThousand(int $number): string{
        $hundreds = floor($number / 100);
        $remainder = $number % 100;
        $hundredText = ($hundreds === 1.0) ? "cent" : $this->frenchNumberWords[$hundreds] . ' ' . $this->frenchNumberWords[100];
        if ($remainder === 0) {
            return $hundredText;
        } 
        return $hundredText . ' ' . $this->convert($remainder);
    }
    private function numberToLetterBetweenThousandAndMillion(int $number): string{
        $thousands = floor($number / 1000);
        $remainder = $number % 1000;
        $thousandText = ($thousands === 1.0 ?  '' : $this->convert($thousands)) . ' ' . $this->frenchNumberWords[1000];
        if ($remainder === 0) {
            return $thousandText;
        } 
        return $thousandText . ' ' . $this->convert($remainder);
    }
    private function numberToLetterBetweenMillionAndBillion(int $number): string{
        $millions = floor($number / 1000000);
        $remainder = $number % 1000000;
        $millionText = $this->convert($millions) . ' ' . $this->frenchNumberWords[1000000];
        if ($remainder === 0) {
            return $millionText;
        } 
        return $millionText . ' ' . $this->convert($remainder);
    }
    private function numberToLetterAboveBillion(int $number): string{
        $billions = floor($number / 1000000000);
        $remainder = $number % 1000000000;
        $billionText = $this->convert($billions) . ' ' . $this->frenchNumberWords[1000000000];
        if ($remainder === 0) {
            return $billionText;
        }
        return $billionText . ' ' . $this->convert($remainder);
    }


}
