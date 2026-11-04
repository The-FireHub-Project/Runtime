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
 * ### Internal Stream Flag
 *
 * Defines native PHP stream constants for internalstreamflag operations.
 * @since 1.0.0
 */
enum InternalStreamFlag:int {

    /**
     * ### Specifies no internal stream flags.
     * @since 1.0.0
     */
    case NONE = 0;

    /**
     * ### Disables plugin URL wrappers.
     * @since 1.0.0
     */
    case IGNORE_URL = STREAM_IGNORE_URL;

    /**
     * ### Requires a seekable stream.
     * @since 1.0.0
     */
    case MUST_SEEK = STREAM_MUST_SEEK;

    /**
     * ### Disables URL wrappers and requires a seekable stream.
     * @since 1.0.0
     */
    case IGNORE_URL_MUST_SEEK = STREAM_IGNORE_URL | STREAM_MUST_SEEK;

}
