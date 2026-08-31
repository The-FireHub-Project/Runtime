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
use FireHub\Runtime\Math\RoundMode;
use FireHub\Runtime\Exception\InvalidPrecisionException;

/**
 * ### Decimal Number Rounding
 * @since 1.0.0
 */
trait Round {

    /**
     * ### Rounds a decimal value
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Math\DecimalEngine::normalize() To normalize the decimal value.
     * @uses \FireHub\Runtime\Str\SB\Access::part() To get the integer and fractional parts.
     * @uses \FireHub\Runtime\Str\SB\Inspection::length() To get the length of the string.
     * @uses \FireHub\Runtime\Str\SB\Transform::pad() To pad the string with zeros.
     * @uses \FireHub\Runtime\Math\Decimal\Round::shouldRound() To determine whether the value should be rounded.
     * @uses \FireHub\Runtime\Math\DecimalEngine::add() To increment the value.
     *
     * @param non-empty-string $value <p>
     * The decimal value to round.
     * </p>
     * @param int<0, max> $precision <p>
     * The number of fractional digits to preserve.
     * </p>
     * @param \FireHub\Runtime\Math\RoundMode $mode [optional] <p>
     * The rounding mode.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException If the value is not a valid decimal number.
     * @throws \FireHub\Runtime\Exception\InvalidPrecisionException If the precision is less than zero.
     *
     * @return string The rounded decimal value.
     */
    public static function round (string $value, int $precision = 0, RoundMode $mode = RoundMode::HALF_AWAY_FROM_ZERO):string {

        [$sign, $integer, $fraction] = self::normalize($value);

        if ($precision < 0) throw new InvalidPrecisionException('Precision must be greater than or equal to zero.');

        if (Runtime\Str\SB\Inspection::length($fraction) <= $precision)
            return $sign === '-' && ($integer !== '0' || $fraction !== '')
                ? '-'.$integer.($fraction !== '' ? '.'.$fraction : '')
                : $integer.($fraction !== '' ? '.'.$fraction : '');

        $kept = Runtime\Str\SB\Access::part($fraction, 0, $precision);

        /** @var non-empty-string $discarded */
        $discarded = Runtime\Str\SB\Access::part($fraction, $precision);

        if (self::shouldRound($sign, $integer, $kept, $discarded, $mode)) {

            $number = Runtime\Math\DecimalEngine::add($integer.$kept, '1');

            if ($precision > 0) {

                $number = Runtime\Str\SB\Transform::pad($number, $precision + 1, '0', Side::LEFT);

                $integer_length = Runtime\Str\SB\Inspection::length($number) - $precision;

                $integer = Runtime\Str\SB\Access::part($number, 0, $integer_length);

                $kept = Runtime\Str\SB\Access::part($number, $integer_length);

            } else {

                $integer = $number;
                $kept = '';

            }

        }

        if ($precision > 0) {

            $kept = Runtime\Str\SB\Transform::pad($kept, $precision, '0');

            $result = $integer.'.'.$kept;

        } else $result = $integer;

        return $sign === '-' && $result !== '0'
            ? '-'.$result
            : $result;

    }

    /**
     * ### Determines whether a decimal value should be rounded
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Str\SB\Inspection::length() To get the length of the string.
     *
     * @param '+'|'-' $sign <p>
     * The sign of the decimal value.
     * </p>
     * @param non-empty-string $integer <p>
     * The integer part of the decimal value.
     * </p>
     * @param string $kept <p>
     * The fractional digits that are kept.
     * </p>
     * @param non-empty-string $discarded <p>
     * The fractional digits that are discarded.
     * </p>
     * @param \FireHub\Runtime\Math\RoundMode $mode <p>
     * The rounding mode.
     * </p>
     *
     * @return bool Returns true if the retained value should be incremented.
     */
    private static function shouldRound (string $sign, string $integer, string $kept, string $discarded, RoundMode $mode):bool {

        $first = (int)$discarded[0];

        /** Less than half */
        if ($first < 5) {

            return match ($mode) {
                RoundMode::TOWARDS_ZERO, RoundMode::HALF_AWAY_FROM_ZERO, RoundMode::HALF_TOWARDS_ZERO,
                RoundMode::HALF_EVEN, RoundMode::HALF_ODD
                    => false,
                RoundMode::AWAY_FROM_ZERO
                    => true,
                RoundMode::POSITIVE_INFINITY
                    => $sign === '+',
                RoundMode::NEGATIVE_INFINITY
                    => $sign === '-'
            };

        }

        /** Greater than half */
        if ($first > 5)

            return match ($mode) {
                RoundMode::TOWARDS_ZERO
                    => false,
                RoundMode::NEGATIVE_INFINITY
                    => $sign === '-',
                RoundMode::POSITIVE_INFINITY
                    => $sign === '+',
                RoundMode::AWAY_FROM_ZERO, RoundMode::HALF_AWAY_FROM_ZERO, RoundMode::HALF_TOWARDS_ZERO,
                RoundMode::HALF_EVEN, RoundMode::HALF_ODD
                    => true

            };

        /** The first discarded digit is 5 */
        for ($i = 1, $length = Runtime\Str\SB\Inspection::length($discarded); $i < $length; ++$i) {

            if ($discarded[$i] !== '0') {

                /** Greater than half.*/
                return match ($mode) {
                    RoundMode::TOWARDS_ZERO
                        => false,
                    RoundMode::NEGATIVE_INFINITY
                        => $sign === '-',
                    RoundMode::POSITIVE_INFINITY
                        => $sign === '+',
                    RoundMode::AWAY_FROM_ZERO, RoundMode::HALF_AWAY_FROM_ZERO, RoundMode::HALF_TOWARDS_ZERO,
                    RoundMode::HALF_EVEN, RoundMode::HALF_ODD
                        => true
                };

            }

        }

        /** Exactly halfway */
        $last = (int)($kept !== '' ? $kept[-1] : $integer[-1]);

        return match ($mode) {
            RoundMode::HALF_AWAY_FROM_ZERO, RoundMode::AWAY_FROM_ZERO
                => true,
            RoundMode::HALF_TOWARDS_ZERO, RoundMode::TOWARDS_ZERO
                => false,
            RoundMode::HALF_EVEN
                => $last % 2 !== 0,
            RoundMode::HALF_ODD
                => $last % 2 === 0,
            RoundMode::NEGATIVE_INFINITY
                => $sign === '-',
            RoundMode::POSITIVE_INFINITY
                => $sign === '+'
        };

    }

}