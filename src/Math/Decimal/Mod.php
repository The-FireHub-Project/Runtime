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

use DivisionByZeroError;

/**
 * ### Decimal Number Modulo
 * @since 1.0.0
 */
trait Mod {

    /**
     * ### Calculates the remainder of a decimal division
     *
     * The remainder follows truncation-toward-zero semantics. Its sign is the same as the dividend.
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Math\DecimalEngine::normalize() To normalize the decimal values.
     * @uses \FireHub\Runtime\Math\DecimalEngine::divide() To calculate the truncated quotient.
     * @uses \FireHub\Runtime\Math\DecimalEngine::multiply() To calculate the product of the quotient and divisor.
     * @uses \FireHub\Runtime\Math\DecimalEngine::subtract() To calculate the remainder.
     *
     * @param non-empty-string $left <p>
     * The dividend.
     * </p>
     * @param non-empty-string $right <p>
     * The divisor.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException If either decimal value is invalid.
     * @throws \DivisionByZeroError If the divisor is zero.
     *
     * @return numeric-string The remainder of the division.
     */
    public static function mod (string $left, string $right):string {

        [, $right_integer, $right_fraction] = self::normalize($right);

        if ($right_integer === '0' && $right_fraction === '')
            throw new DivisionByZeroError('Modulo by zero.');

        [, $left_integer, $left_fraction] = self::normalize($left);

        if ($left_integer === '0' && $left_fraction === '') return '0';

        $quotient = self::divide($left, $right, 0);
        $product = self::multiply($quotient, $right);

        /** @var numeric-string */
        return self::subtract($left, $product);

    }

}