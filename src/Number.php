<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.1
 * @package Runtime
 */

namespace FireHub\Runtime;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Core\Meta\Enum\Number\Base;
use FireHub\Runtime\Exception\InvalidNumberBaseException;

use function base_convert;
use function number_format;

/**
 * ### PHP Number Utilities
 *
 * Provides low-level utilities for working with numeric values, including number base conversion, representation
 * transformation, and number formatting.
 *
 * This component provides helpers for converting numbers between different bases such as binary, octal, decimal, and
 * hexadecimal, as well as formatting numbers for display.
 * @since 1.0.0
 */
final class Number extends NativeRuntime {

    /**
     * ### Format a number with grouped thousands
     *
     * Formats a number with grouped thousands and optionally decimal digits using the rounding half-up rule.
     * @since 1.0.0
     *
     * @param int|float $number <p>
     * The number being formatted.
     * </p>
     * @param int $decimals <p>
     * Sets the number of decimal digits.
     *
     * If 0, the decimal_separator is omitted from the return value.
     *
     * When the value is negative, the num is rounded to decimal significant digits before the decimal point.
     * </p>
     * @param string $decimal_separator [optional] <p>
     * Sets the separator for the decimal point.
     * </p>
     * @param string $thousands_separator [optional] <p>
     * Sets the separator for thousands.
     * </p>
     *
     * @return non-empty-string A formatted version of the number.
     */
    public static function format (int|float $number, int $decimals, string $decimal_separator = '.', string $thousands_separator = ','):string {

        /** @var non-empty-string */
        return number_format(
            $number,
            $decimals,
            $decimal_separator,
            $thousands_separator
        );

    }

    /**
     * ### Convert a number between arbitrary bases
     *
     * Converts a number from one base representation to another.
     *
     * Supported bases range from binary (base 2) to base 36.
     * Digits above base 10 are represented using letters a-z.
     * @since 1.0.0
     *
     * @param string $number <p>
     * The number to convert.
     *
     * Any invalid characters in $number are silently ignored. As of PHP 7.4.0 supplying any invalid characters is
     * deprecated.
     * </p>
     * @param int<2, 36>|\FireHub\Core\Meta\Enum\Number\Base $from_base <p>
     * The base of the number in $number.
     * </p>
     * @param int<2, 36>|\FireHub\Core\Meta\Enum\Number\Base $to_base <p>
     * The base to convert the number to.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidNumberBaseException If $from_base or $to_base is not between 2 and 36.
     *
     * @return string $number converted to base $to_base.
     */
    public static function baseConverter (string $number, int|Base $from_base, int|Base $to_base):string {

        $from_base = $from_base instanceof Base
            ? $from_base->value
            : $from_base;

        $to_base = $to_base instanceof Base
            ? $to_base->value
            : $to_base;

        if ($from_base < 2 || $from_base > 36 || $to_base < 2 || $to_base > 36) {
            throw new InvalidNumberBaseException(
                'The base must be between 2 and 36.',
                [
                    'from_base' => $from_base,
                    'to_base' => $to_base,
                    'minimum' => 2,
                    'maximum' => 36,
                ]
            );
        }

        return base_convert($number, $from_base, $to_base);

    }

}