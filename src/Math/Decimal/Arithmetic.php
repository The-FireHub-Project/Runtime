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

use FireHub\Runtime;

/**
 * ### Decimal Number Arithmetic
 * @since 1.0.0
 */
trait Arithmetic {

    /**
     * ### Adds two decimal values together
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Math\DecimalEngine::normalize() To normalize the decimal values.
     * @uses \FireHub\Runtime\Math\DecimalEngine::addPositive() To add the positive decimal values.
     * @uses \FireHub\Runtime\Math\DecimalEngine::subtractPositive() To subtract the positive decimal values.
     * @uses \FireHub\Runtime\Math\DecimalEngine::comparePositive() To compare the decimal values.
     *
     * @param non-empty-string $left <p>
     * The first decimal value to add.
     * </p>
     *
     * @param non-empty-string $right <p>
     * The second decimal value to add.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException If either decimal value is not a valid decimal number.
     *
     * @return numeric-string The sum of the two decimal values.
     */
    public static function add (string $left, string $right):string {

        [$left_sign, $left_integer, $left_fraction] = self::normalize($left);
        [$right_sign, $right_integer, $right_fraction] = self::normalize($right);

        if ($left_sign === $right_sign) {

            $result = self::addPositive(
                $left_integer,
                $left_fraction,
                $right_integer,
                $right_fraction
            );

            /** @var numeric-string $result */
            return $left_sign === '-' && $result !== '0' // @phpstan-ignore return.type
                ? '-'.$result
                : $result;

        }

        $comparison = self::comparePositive(
            $left_integer,
            $left_fraction,
            $right_integer,
            $right_fraction
        );

        if ($comparison === 0) return '0';

        if ($comparison > 0) {

            $result = self::subtractPositive(
                $left_integer,
                $left_fraction,
                $right_integer,
                $right_fraction
            );

            /** @var numeric-string $result */
            return $left_sign === '-' && $result !== '0' // @phpstan-ignore return.type
                ? '-'.$result
                : $result;

        }

        $result = self::subtractPositive(
            $right_integer,
            $right_fraction,
            $left_integer,
            $left_fraction
        );

        /** @var numeric-string $result */
        return $right_sign === '-' && $result !== '0' // @phpstan-ignore return.type
            ? '-'.$result
            : $result;

    }

    /**
     * ### Subtracts one decimal value from another
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Math\DecimalEngine::normalize() To normalize the decimal values.
     * @uses \FireHub\Runtime\Math\DecimalEngine::add() To subtract the decimal value from another decimal value.
     *
     * @param non-empty-string $left <p>
     * The decimal value from which to subtract.
     * </p>
     *
     * @param non-empty-string $right <p>
     * The decimal value to subtract.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException If either decimal value is not a valid decimal number.
     *
     * @return numeric-string The difference between the two decimal values.
     */
    public static function subtract (string $left, string $right):string {

        [$right_sign, $right_integer, $right_fraction] = self::normalize($right);

        return self::add(
            $left,
            ($right_sign === '-' ? '' : '-')
            .$right_integer
            .($right_fraction !== '' ? '.'.$right_fraction : '')
        );

    }

    /**
     * ### Adds two positive decimal values
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Math::max() To get the maximum length of the two values.
     * @uses \FireHub\Runtime\Str\SB\Transform::reverse() To reverse the string.
     * @uses \FireHub\Runtime\Str\SB\Transform::pad() To pad the string with zeros.
     * @uses \FireHub\Runtime\Str\SB\Inspection::length() To get the length of the string.
     * @uses \FireHub\Runtime\Math::divideInt() To divide the sum by 10.
     * @uses \FireHub\Runtime\Math\DecimalEngine::normalizeResult() To normalize the result.
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
     * @return numeric-string The sum of the two positive decimal values.
     */
    private static function addPositive (string $left_integer, string $left_fraction, string $right_integer, string $right_fraction):string {

        $scale = Runtime\Math::max(
            Runtime\Str\SB\Inspection::length($left_fraction),
            Runtime\Str\SB\Inspection::length($right_fraction)
        );

        $left = Runtime\Str\SB\Transform::reverse(
            $left_integer.Runtime\Str\SB\Transform::pad($left_fraction, $scale, '0')
        );
        $right = Runtime\Str\SB\Transform::reverse(
            $right_integer.Runtime\Str\SB\Transform::pad($right_fraction, $scale, '0')
        );

        $length = Runtime\Math::max(
            Runtime\Str\SB\Inspection::length($left),
            Runtime\Str\SB\Inspection::length($right)
        );

        $carry = 0; $result = '';
        for ($i = 0; $i < $length; ++$i) {

            $sum = (int)($left[$i] ?? '0')
                + (int)($right[$i] ?? '0')
                + $carry;

            $result .= $sum % 10;

            $carry = Runtime\Math::divideInt($sum, 10);

        }

        if ($carry > 0) $result .= $carry;

        return self::normalizeResult(
            Runtime\Str\SB\Transform::reverse($result),
            $scale
        );

    }

    /**
     * ### Subtracts a positive decimal value from another positive decimal value
     *
     * The left value must be greater than or equal to the right value.
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Math::max() To get the maximum length of the two values.
     * @uses \FireHub\Runtime\Str\SB\Transform::reverse() To reverse the string.
     * @uses \FireHub\Runtime\Str\SB\Transform::pad() To pad the string with zeros.
     * @uses \FireHub\Runtime\Str\SB\Inspection::length() To get the length of the string.
     * @uses \FireHub\Runtime\Math\DecimalEngine::normalizeResult() To normalize the result.
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
     * @return numeric-string The difference between the two positive decimal values.
     */
    private static function subtractPositive (string $left_integer, string $left_fraction, string $right_integer, string $right_fraction):string {

        $scale = Runtime\Math::max(
            Runtime\Str\SB\Inspection::length($left_fraction),
            Runtime\Str\SB\Inspection::length($right_fraction)
        );

        $left = Runtime\Str\SB\Transform::reverse(
            $left_integer.Runtime\Str\SB\Transform::pad($left_fraction, $scale, '0')
        );
        $right = Runtime\Str\SB\Transform::reverse(
            $right_integer.Runtime\Str\SB\Transform::pad($right_fraction, $scale, '0')
        );

        $length = Runtime\Str\SB\Inspection::length($left);

        $borrow = 0; $result = '';
        for ($i = 0; $i < $length; ++$i) {

            $difference = (int)($left[$i] ?? '0')
                - (int)($right[$i] ?? '0')
                - $borrow;

            if ($difference < 0) {

                $difference += 10;
                $borrow = 1;

            } else {

                $borrow = 0;

            }

            $result .= $difference;

        }

        return self::normalizeResult(
            Runtime\Str\SB\Transform::reverse($result),
            $scale
        );

    }

}