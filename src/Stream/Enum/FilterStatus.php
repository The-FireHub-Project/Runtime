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
 * ### Filter Status
 *
 * Defines native PHP stream constants for filterstatus operations.
 * @since 1.0.0
 */
enum FilterStatus:int {

    /**
     * ### Passes produced buckets to the next stream filter.
     * @since 1.0.0
     */
    case PASS_ON = PSFS_PASS_ON;

    /**
     * ### Requests more input before producing output.
     * @since 1.0.0
     */
    case FEED_ME = PSFS_FEED_ME;

    /**
     * ### Reports an unrecoverable filter error.
     * @since 1.0.0
     */
    case ERROR_FATAL = PSFS_ERR_FATAL;

}
