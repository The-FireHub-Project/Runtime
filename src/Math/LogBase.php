<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.1
 * @package Runtime\Tests
 */

namespace FireHub\Runtime\Math;

use const M_E;
use const M_LN10;
use const M_LN2;
use const M_LOG10E;
use const M_LOG2E;

/**
 * ### PHP Runtime Logarithmic Bases
 *
 * Provides predefined logarithmic constants used for calculating logarithms with different mathematical bases while
 * preserving native runtime behavior.
 *
 * This enum exposes common logarithmic base values through a consistent FireHub Runtime API.
 * @since 1.0.0
 */
enum LogBase {

    /**
     * ### e
     * @since 1.0.0
     */
    case E;

    /**
     * ### log_2 e
     * @since 1.0.0
     */
    case LOG2E;

    /**
     * ### log_10 e
     * @since 1.0.0
     */
    case LOG10E;

    /**
     * ### log_e 2
     * @since 1.0.0
     */
    case LN2;

    /**
     * ### log_e 10
     * @since 1.0.0
     */
    case LN10;

    /**
     * ### Get the numerical value of the logarithmic base
     * @since 1.0.0
     *
     * @return float Log value.
     */
    public function value ():float {

        return match ($this) {
            self::E => M_E,
            self::LOG2E => M_LOG2E,
            self::LOG10E => M_LOG10E,
            self::LN2 => M_LN2,
            self::LN10 => M_LN10
        };

    }

}