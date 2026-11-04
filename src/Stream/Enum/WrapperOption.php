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
 * ### Wrapper Option
 *
 * Defines native PHP stream constants for wrapperoption operations.
 * @since 1.0.0
 */
enum WrapperOption:int {

    /**
     * ### Changes the stream blocking mode.
     * @since 1.0.0
     */
    case BLOCKING = STREAM_OPTION_BLOCKING;

    /**
     * ### Changes the stream read buffer.
     * @since 1.0.0
     */
    case READ_BUFFER = STREAM_OPTION_READ_BUFFER;

    /**
     * ### Changes the stream write buffer.
     * @since 1.0.0
     */
    case WRITE_BUFFER = STREAM_OPTION_WRITE_BUFFER;

    /**
     * ### Changes the stream read timeout.
     * @since 1.0.0
     */
    case READ_TIMEOUT = STREAM_OPTION_READ_TIMEOUT;

}
