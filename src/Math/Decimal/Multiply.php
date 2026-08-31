<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=7.4
 * @package Runtime
 */

namespace FireHub\Runtime\Math\Decimal;

use FireHub\Core\Meta\Enum\Side;
use FireHub\Runtime;

/**
 * ### Decimal Number Multiplication
 * @since 1.0.0
 */
trait Multiply {

    /**
     * ### Multiplies two decimal values
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Math\DecimalEngine::normalize() To normalize the decimal values.
     * @uses \FireHub\Runtime\Math\DecimalEngine::multiplyPositive() To multiply the positive decimal values.
     *
     * @param non-empty-string $left <p>
     * The first decimal value to multiply.
     * </p>
     *
     * @param non-empty-string $right <p>
     * The second decimal value to multiply.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException If either decimal value is not a valid decimal number.
     *
     * @return string The product of the two decimal values.
     */
    public static function multiply (string $left, string $right):string {

        [$left_sign, $left_integer, $left_fraction] = self::normalize($left);
        [$right_sign, $right_integer, $right_fraction] = self::normalize($right);

        if (($left_integer === '0' && $left_fraction === '')
            || ($right_integer === '0' && $right_fraction === '')
        ) return '0';

        $result = self::multiplyPositive(
            $left_integer,
            $left_fraction,
            $right_integer,
            $right_fraction
        );

        if ($left_sign !== $right_sign && $result !== '0') return '-'.$result;

        return $result;

    }

    /**
     * ### Multiplies two positive decimal values
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Math\DecimalEngine::normalizeResult() To normalize the result.
     * @uses \FireHub\Runtime\Math::divideInt() To divide the sum by 10.
     * @uses \FireHub\Runtime\Str\SB\Inspection::length() To get the length of the string.
     * @uses \FireHub\Core\Meta\Enum\Side::LEFT To trim the left side of the string.
     * @uses \FireHub\Runtime\Str\SB\Transform::trim() To trim leading zeros from the string.
     * @uses \FireHub\Runtime\Arr\Structure::fill() To create an array of zeros.
     *
     * @param non-empty-string $left_integer <p>
     * The normalized integer part of the first value.
     * </p>
     * @param string $left_fraction <p>
     * The normalized fractional part of the first value.
     * </p>
     * @param non-empty-string $right_integer <p>
     * The normalized integer part of the second value.
     * </p>
     * @param string $right_fraction <p>
     * The normalized fractional part of the second value.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException If the value is not a valid decimal number.
     *
     * @return string The product of the two positive decimal values.
     */
    private static function multiplyPositive (string $left_integer, string $left_fraction, string $right_integer, string $right_fraction):string {

        $left = $left_integer.$left_fraction;
        $right = $right_integer.$right_fraction;

        /** @var int<1, max> $left_length */
        $left_length = Runtime\Str\SB\Inspection::length($left);
        /** @var int<1, max> $right_Length */
        $right_Length = Runtime\Str\SB\Inspection::length($right);

        $result = Runtime\Arr\Structure::fill(0, 0, $left_length + $right_Length);

        for ($i = $left_length - 1; $i >= 0; --$i) {

            $left_digit = (int)$left[$i];

            for ($j = $right_Length - 1; $j >= 0; --$j) {

                $right_digit = (int)$right[$j];

                $position = $i + $j + 1;

                $result[$position] += $left_digit * $right_digit; // @phpstan-ignore offsetAccess.notFound

            }

        }

        for ($i = $left_length + $right_Length - 1; $i > 0; --$i) {

            if ($result[$i] >= 10) { // @phpstan-ignore offsetAccess.notFound

                $result[$i - 1] += Runtime\Math::divideInt($result[$i], 10); // @phpstan-ignore offsetAccess.notFound

                $result[$i] %= 10; // @phpstan-ignore offsetAccess.notFound

            }

        }

        $value = '';
        foreach ($result as $digit)
            $value .= $digit;

        return self::normalizeResult(
            Runtime\Str\SB\Transform::trim($value, Side::LEFT, '0') ?: '0',
            Runtime\Str\SB\Inspection::length($left_fraction) + Runtime\Str\SB\Inspection::length($right_fraction)
        );

    }

}