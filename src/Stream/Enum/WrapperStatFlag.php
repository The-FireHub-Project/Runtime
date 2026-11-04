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
 * ### Wrapper Stat Flag
 *
 * Defines native PHP stream constants for wrapperstatflag operations.
 * @since 1.0.0
 */
enum WrapperStatFlag:int {

    /**
     * ### Requests resource statistics without additional flags.
     * @since 1.0.0
     */
    case NONE = 0;

    /**
     * ### Requests information about a symbolic link itself.
     * @since 1.0.0
     */
    case LINK = STREAM_URL_STAT_LINK;

    /**
     * ### Suppresses error reporting during stat operations.
     * @since 1.0.0
     */
    case QUIET = STREAM_URL_STAT_QUIET;

    /**
     * ### Requests link statistics without error reporting.
     * @since 1.0.0
     */
    case LINK_QUIET = STREAM_URL_STAT_LINK | STREAM_URL_STAT_QUIET;

}
