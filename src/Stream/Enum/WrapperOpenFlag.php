<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8..1
 * @package Runtime
 */

namespace FireHub\Runtime\Stream\Enum;

/**
 * ### Wrapper Open Flag
 *
 * Defines native PHP stream constants for wrapperopenflag operations.
 * @since 1.0.0
 */
enum WrapperOpenFlag:int {

    /**
     * ### Opens a wrapper resource without additional flags.
     * @since 1.0.0
     */
    case NONE = 0;

    /**
     * ### Uses the configured include path.
     * @since 1.0.0
     */
    case USE_PATH = STREAM_USE_PATH;

    /**
     * ### Requests reporting of wrapper errors.
     * @since 1.0.0
     */
    case REPORT_ERRORS = STREAM_REPORT_ERRORS;

    /**
     * ### Uses the include path and requests error reporting.
     * @since 1.0.0
     */
    case USE_PATH_REPORT_ERRORS = STREAM_USE_PATH | STREAM_REPORT_ERRORS;

}
