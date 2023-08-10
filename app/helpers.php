<?php
/**
 * Return value including tax
 * @param float $value
 * @param float $percentage
 * @param bool $formatted
 * @return float|string
 */
function getIncludingVat(float $value, float $percentage, bool $formatted = false)
{
    $inclVat = round($value + (($value / 100) * $percentage), 2);
    if ($formatted) {
        return "£" . number_format($inclVat, 2);
    }
    return $inclVat;
}

/**
 * Return value excluding tax
 * @param float $value
 * @param float $percentage
 * @param bool $formatted
 * @return float|string
 */
function getExcludingVat(float $value, float $percentage, bool $formatted = false)
{
    $exclVat = round((($value / ($percentage + 100)) * 100), 2);
    if ($formatted) {
        return "£" . number_format($exclVat, 2);
    }
    return $exclVat;
}

/**
 * Return vat total
 * @param float $value
 * @param float $percentage
 * @param int $included
 * @return string
 */
function getVatTotal(float $value, float $percentage, int $included): string
{
    $included = (bool)$included;
    $vatSubtracted = getExcludingVat($value, $percentage);
    if ($included) {
        return number_format(round(($value - $vatSubtracted), 2), 2);
    }
    return number_format(round(((($value / 100) * $percentage)), 2), 2);
}

