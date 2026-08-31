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

namespace FireHub\Runtime\Math;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Core\Meta\Enum\Side;
use FireHub\Runtime\Math\Decimal\ {
    Arithmetic, Divide, Mod, Multiply, Round
};
use FireHub\Runtime;
use FireHub\Runtime\Exception\InvalidDecimalNumberException;

/**
 * ### Arbitrary-precision decimal arithmetic
 *
 * The DecimalEngine class provides string-based arithmetic operations for decimal values without relying on
 * floating-point arithmetic or external arbitrary-precision extensions.
 *
 * The engine is responsible solely for decimal arithmetic execution, while value validation, immutability, and the
 * developer-facing API remain the responsibility of the Decimal Value Object.
 * @since 1.0.0
 */
final class DecimalEngine extends NativeRuntime {

    /**
     * ### Implements operations
     * @since 1.0.0
     */
    use Arithmetic, Divide, Mod, Multiply, Round;

    /**
     * ### Compares two positive decimal values
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Math::max() To get the maximum length of the two values.
     * @uses \FireHub\Runtime\Str\SB\Transform::reverse() To reverse the string.
     * @uses \FireHub\Runtime\Str\SB\Transform::pad() To pad the string with zeros.
     * @uses \FireHub\Runtime\Str\SB\Inspection::length() To get the length of the string.
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
     * @return int<-1, 1> Returns -1 if left is smaller, 0 if equal, or 1 if left is greater.
     */
    private static function comparePositive (string $left_integer, string $left_fraction, string $right_integer, string $right_fraction):int {

        $left_length = Runtime\Str\SB\Inspection::length($left_integer);
        $right_length = Runtime\Str\SB\Inspection::length($right_integer);

        if ($left_length !== $right_length) return $left_length > $right_length ? 1 : -1;

        if ($left_integer !== $right_integer) return $left_integer > $right_integer ? 1 : -1;

        $scale = Runtime\Math::max(
            Runtime\Str\SB\Inspection::length($left_fraction),
            Runtime\Str\SB\Inspection::length($right_fraction)
        );

        $leftFraction = Runtime\Str\SB\Transform::pad($left_fraction, $scale, '0');

        $rightFraction = Runtime\Str\SB\Transform::pad($right_fraction, $scale, '0');

        if ($leftFraction === $rightFraction) return 0;

        return $leftFraction > $rightFraction ? 1 : -1;

    }

    /**
     * ### Normalizes a decimal value
     *
     * Validates the decimal representation and returns its sign, integer part, and fractional part.
     *
     * The returned representation contains no unnecessary leading or trailing zeros.
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Str\SB\Regex::match() To check if the value is a valid decimal number.
     * @uses \FireHub\Runtime\Str\SB\Delimiter::explode() To split the value into integer and fractional parts.
     * @uses \FireHub\Runtime\Str\SB\Transform::trim() To trim leading and trailing zeros from the integer and
     * fractional parts.
     * @uses \FireHub\Core\Meta\Enum\Side::LEFT To trim the left side of the integer part.
     * @uses \FireHub\Core\Meta\Enum\Side::RIGHT To trim the right side of the fractional part.
     *
     * @param string $value <p>
     * The decimal value to normalize.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException If the value is not a valid decimal number.
     *
     * @return array{'+'|'-', numeric-string, string} Returns the sign, normalized integer part, and normalized
     * fractional part.
     */
    private static function normalize (string $value):array {

        if (Runtime\Str\SB\Regex::match('/^[+-]?\d+(?:\.\d+)?$/', $value) === false)
            throw new InvalidDecimalNumberException;

        $sign = '+';
        if ($value[0] === '-') {

            $sign = '-';
            $value = Runtime\Str\SB\Access::part($value, 1);

        } else if ($value[0] === '+') {

            $value = Runtime\Str\SB\Access::part($value, 1);

        }

        $parts = Runtime\Str\SB\Delimiter::explode($value, '.', 2);

        $integer = Runtime\Str\SB\Transform::trim($parts[0] ?? '', Side::LEFT, '0') ?: '0';

        $fraction = Runtime\Str\SB\Transform::trim($parts[1] ?? '', Side::RIGHT, '0');

        if ($integer === '0' && $fraction === '') return ['+', '0', ''];

        /** @var array{'+'|'-', numeric-string, string} */
        return [$sign, $integer, $fraction];

    }

    /**
     * ### Normalizes an integer representation and inserts the decimal point
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Math\DecimalEngine::normalize() To normalize the integer representation.
     * @uses \FireHub\Runtime\Str\SB\Transform::pad() To pad the integer representation with zeros.
     * @uses \FireHub\Runtime\Str\SB\Access::part() To get the integer and fractional parts.
     * @uses \FireHub\Runtime\Str\SB\Inspection::length() To get the length of the integer representation.
     * @uses \FireHub\Core\Meta\Enum\Side::LEFT To pad the left side of the integer representation.
     *
     * @param string $value <p>
     * The integer representation.
     * </p>
     * @param int $scale <p>
     * The decimal scale.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException If the value is not a valid decimal number.
     *
     * @return numeric-string The normalized decimal result.
     */
    private static function normalizeResult (string $value, int $scale):string {

        if ($scale === 0) return self::normalize($value)[1];

        $value = Runtime\Str\SB\Transform::pad($value, $scale + 1, '0', Side::LEFT);

        $position = Runtime\Str\SB\Inspection::length($value) - $scale;

        $value = Runtime\Str\SB\Access::part($value, 0, $position)
            .'.'
            .Runtime\Str\SB\Access::part($value, $position);

        /** @var numeric-string */
        return self::normalize($value)[1] // @phpstan-ignore varTag.type
            .(self::normalize($value)[2] !== ''
                ? '.'.self::normalize($value)[2]
                : ''
            );

    }

}