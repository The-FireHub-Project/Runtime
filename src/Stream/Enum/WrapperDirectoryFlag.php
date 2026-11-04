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
 * ### Wrapper Directory Flag
 *
 * Defines native PHP stream constants for wrapperdirectoryflag operations.
 * @since 1.0.0
 */
enum WrapperDirectoryFlag:int {

    /**
     * ### Creates or removes a directory without recursion.
     * @since 1.0.0
     */
    case NONE = 0;

    /**
     * ### Requests recursive directory handling.
     * @since 1.0.0
     */
    case RECURSIVE = STREAM_MKDIR_RECURSIVE;

}
