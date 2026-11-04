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
 * ### Filter Flush Flag
 *
 * Defines native PHP stream constants for filterflushflag operations.
 * @since 1.0.0
 */
enum FilterFlushFlag:int {

    /**
     * ### Indicates normal filter processing.
     * @since 1.0.0
     */
    case NORMAL = PSFS_FLAG_NORMAL;

    /**
     * ### Indicates an incremental filter flush.
     * @since 1.0.0
     */
    case INCREMENTAL = PSFS_FLAG_FLUSH_INC;

    /**
     * ### Indicates the final flush before closing.
     * @since 1.0.0
     */
    case CLOSE = PSFS_FLAG_FLUSH_CLOSE;

}
