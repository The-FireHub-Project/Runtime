<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.4
 * @package Runtime
 */

namespace FireHub\Runtime\Math\Decimal;

use FireHub\Core\Meta\Enum\Side;
use FireHub\Runtime;
use FireHub\Runtime\Exception\InvalidScaleNumberException;
use DivisionByZeroError;

/**
 * ### Decimal Number Division
 * @since 1.0.0
 */
trait Divide {

    /**
     * ### Divides one decimal value by another
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Math\DecimalEngine::normalize() To normalize the decimal values.
     * @uses \FireHub\Runtime\Math\DecimalEngine::dividePositive() To divide the positive decimal values.
     *
     * @param non-empty-string $left <p>
     * The dividend.
     * </p>
     * @param non-empty-string $right <p>
     * The divisor.
     * </p>
     * @param positive-int $scale [optional] <p>
     * The number of decimal places to calculate.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException If either decimal value is invalid.
     * @throws \FireHub\Runtime\Exception\InvalidScaleNumberException If the scale is less than zero.
     * @throws DivisionByZeroError If the divisor is zero.
     *
     * @return numeric-string The quotient of the two decimal values.
     *
     */
    public static function divide (string $left, string $right, int $scale = 18):string {

        [$left_sign, $left_integer, $left_fraction] = self::normalize($left);
        [$right_sign, $right_integer, $right_fraction] = self::normalize($right);

        if ($scale < 0)
            throw new InvalidScaleNumberException('Scale must be greater than or equal to zero.');

        if ($right_integer === '0' && $right_fraction === '') throw new DivisionByZeroError;

        if ($left_integer === '0' && $left_fraction === '') return '0';

        $result = self::dividePositive(
            $left_integer,
            $left_fraction,
            $right_integer,
            $right_fraction,
            $scale
        );

        /** @var numeric-string $result */
        if ($left_sign !== $right_sign && $result !== '0') return '-'.$result; // @phpstan-ignore return.type

        return $result;

    }

    /**
     * ### Divides two positive decimal values
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Math\DecimalEngine::comparePositive() To compare the positive decimal values.
     * @uses \FireHub\Runtime\Math\DecimalEngine::subtractPositive() To subtract the positive decimal values.
     * @uses \FireHub\Runtime\Math::divideInt() To divide the sum by 10.
     * @uses \FireHub\Runtime\Str\SB\Inspection::length() To get the length of the string.
     * @uses \FireHub\Core\Meta\Enum\Side::LEFT To trim the left side of the string.
     * @uses \FireHub\Runtime\Str\SB\Transform::trim() To trim leading zeros from the string.
     * @uses \FireHub\Runtime\Str\SB\Transform::repeat() To create a string of zeros.
     *
     * @param non-empty-string $left_integer <p>
     * The normalized integer part of the dividend.
     * </p>
     * @param string $left_fraction <p>
     * The normalized fractional part of the dividend.
     * </p>
     * @param non-empty-string $right_integer <p>
     * The normalized integer part of the divisor.
     * </p>
     * @param string $right_fraction <p>
     * The normalized fractional part of the divisor.
     * </p>
     * @param int $scale <p>
     * The number of decimal places to calculate.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException If the value is not a valid decimal number.
     *
     * @return numeric-string The quotient.
     */
    private static function dividePositive (string $left_integer, string $left_fraction, string $right_integer, string $right_fraction, int $scale):string {

        $left_scale = Runtime\Str\SB\Inspection::length($left_fraction);
        $right_scale = Runtime\Str\SB\Inspection::length($right_fraction);

        $dividend = $left_integer.$left_fraction;
        $divisor = $right_integer.$right_fraction;

        $dividend = Runtime\Str\SB\Transform::trim($dividend, Side::LEFT, '0') ?: '0';
        $divisor = Runtime\Str\SB\Transform::trim($divisor, Side::LEFT, '0') ?: '0';

        if ($right_scale > $left_scale) {

            $dividend .= Runtime\Str\SB\Transform::repeat('0', $right_scale - $left_scale);

        } else if ($left_scale > $right_scale) {

            $divisor .= Runtime\Str\SB\Transform::repeat('0', $left_scale - $right_scale);

        }

        $quotient = ''; $remainder = '0';
        $length = Runtime\Str\SB\Inspection::length($dividend);

        for ($i = 0; $i < $length; ++$i) {

            $remainder .= $dividend[$i];

            $remainder = Runtime\Str\SB\Transform::trim($remainder, Side::LEFT, '0') ?: '0';

            $digit = 0;
            while (
                self::comparePositive(
                    $remainder, // @phpstan-ignore argument.type
                    '',
                    $divisor,
                    ''
                ) >= 0
            ) {

                $remainder = self::subtractPositive(
                    $remainder, // @phpstan-ignore argument.type
                    '',
                    $divisor,
                    ''
                );

                ++$digit;

            }

            $quotient .= $digit;

        }

        /** @var numeric-string $quotient */
        $quotient = Runtime\Str\SB\Transform::trim($quotient, Side::LEFT, '0') ?: '0'; // @phpstan-ignore varTag.nativeType

        $fraction = '';
        for ($i = 0; $i < $scale; ++$i) {

            if ($remainder === '0') break;

            $remainder .= '0';

            $remainder = Runtime\Str\SB\Transform::trim($remainder, Side::LEFT, '0') ?: '0';

            $digit = 0;
            while (
                self::comparePositive(
                    $remainder, // @phpstan-ignore argument.type
                    '',
                    $divisor,
                    ''
                ) >= 0
            ) {

                $remainder = self::subtractPositive(
                    $remainder, // @phpstan-ignore argument.type
                    '',
                    $divisor,
                    ''
                );

                ++$digit;

            }

            $fraction .= $digit;

        }

        if ($fraction === '') return $quotient;

        /** @var numeric-string */
        return $quotient.'.'.$fraction; // @phpstan-ignore varTag.nativeType

    }

}