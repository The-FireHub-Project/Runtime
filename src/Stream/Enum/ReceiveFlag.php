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

namespace FireHub\Runtime\Stream\Enum;

/**
 * ### Receive Flag
 *
 * Defines native PHP stream constants for receiveflag operations.
 * @since 1.0.0
 */
enum ReceiveFlag:int {

    /**
     * ### Receives socket data without additional flags.
     * @since 1.0.0
     */
    case NONE = 0;

    /**
     * ### Receives out-of-band socket data.
     * @since 1.0.0
     */
    case OUT_OF_BAND = STREAM_OOB;

    /**
     * ### Reads socket data without consuming it.
     * @since 1.0.0
     */
    case PEEK = STREAM_PEEK;

    /**
     * ### Peeks at out-of-band socket data.
     * @since 1.0.0
     */
    case OUT_OF_BAND_PEEK = STREAM_OOB | STREAM_PEEK;

}
