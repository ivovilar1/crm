<?php

function obfuscate_email(?string $email = null): string
{

    if (!$email) {
        return '';
    }

    $split = explode('@', $email);

    if (count($split) !== 2) {
        return '';
    }

    $firstPart = $split[0];
    $quantity = (int) floor(strlen($firstPart) * 0.75);
    $remaining = strlen($firstPart) - $quantity;

    $maskedFirstPart = substr($firstPart, 0, $remaining) . str_repeat('*', $quantity);

    $secondPart = $split[1];
    $quantity = (int) floor(strlen($secondPart) * 0.75);
    $remaining = strlen($secondPart) - $quantity;

    $maskedSecondPart =  str_repeat('*', $quantity) . substr($secondPart, $remaining * - 1, $remaining);

    return $maskedFirstPart . '@' . $maskedSecondPart;

}
