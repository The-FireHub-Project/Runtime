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
 * ### Stream Opening Modes
 *
 * Defines the supported modes for opening native PHP streams.
 *
 * Binary modes are recommended for consistent behavior across platforms.
 * @since 1.0.0
 */
enum OpenMode:string {

    /**
     * ### Opens a stream for reading only
     *
     * The stream must exist. The pointer is positioned at the beginning.
     * @since 1.0.0
     */
    case READ = 'r';

    /**
     * ### Opens a stream for reading and writing
     *
     * The stream must exist. The pointer is positioned at the beginning.
     * @since 1.0.0
     */
    case READ_WRITE = 'r+';

    /**
     * ### Opens a stream for writing only
     *
     * Creates the file if it does not exist or truncates it if it exists.
     * @since 1.0.0
     */
    case WRITE = 'w';

    /**
     * ### Opens a stream for reading and writing
     *
     * Creates the file if it does not exist or truncates it if it exists.
     * @since 1.0.0
     */
    case WRITE_READ = 'w+';

    /**
     * ### Opens a stream for appending
     *
     * Creates the file if it does not exist.
     * Writes are always performed at the end of the file.
     * @since 1.0.0
     */
    case APPEND = 'a';

    /**
     * ### Opens a stream for reading and appending
     *
     * Creates the file if it does not exist.
     * Writes are always performed at the end of the file.
     * @since 1.0.0
     */
    case APPEND_READ = 'a+';

    /**
     * ### Creates a new stream for writing
     *
     * Fails if the file already exists.
     * @since 1.0.0
     */
    case CREATE = 'x';

    /**
     * ### Creates a new stream for reading and writing
     *
     * Fails if the file already exists.
     * @since 1.0.0
     */
    case CREATE_READ = 'x+';

    /**
     * ### Opens a stream for writing without truncation
     *
     * Creates the file if it does not exist.
     * @since 1.0.0
     */
    case CREATE_OR_OPEN = 'c';

    /**
     * ### Opens a stream for reading and writing without truncation
     *
     * Creates the file if it does not exist.
     * @since 1.0.0
     */
    case CREATE_OR_OPEN_READ = 'c+';

    /**
     * ### Opens a binary stream for reading only
     * @since 1.0.0
     */
    case READ_BINARY = 'rb';

    /**
     * ### Opens a binary stream for reading and writing
     * @since 1.0.0
     */
    case READ_WRITE_BINARY = 'r+b';

    /**
     * ### Opens a binary stream for writing only
     * @since 1.0.0
     */
    case WRITE_BINARY = 'wb';

    /**
     * ### Opens a binary stream for reading and writing
     * @since 1.0.0
     */
    case WRITE_READ_BINARY = 'w+b';

    /**
     * ### Opens a binary stream for appending
     * @since 1.0.0
     */
    case APPEND_BINARY = 'ab';

    /**
     * ### Opens a binary stream for reading and appending
     * @since 1.0.0
     */
    case APPEND_READ_BINARY = 'a+b';

    /**
     * ### Creates a new binary stream for writing
     * @since 1.0.0
     */
    case CREATE_BINARY = 'xb';

    /**
     * ### Creates a new binary stream for reading and writing
     * @since 1.0.0
     */
    case CREATE_READ_BINARY = 'x+b';

    /**
     * ### Opens a binary stream for writing without truncation
     * @since 1.0.0
     */
    case CREATE_OR_OPEN_BINARY = 'cb';

    /**
     * ### Opens a binary stream for reading and writing without truncation
     * @since 1.0.0
     */
    case CREATE_OR_OPEN_READ_BINARY = 'c+b';

}