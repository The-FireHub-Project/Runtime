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
 * ### Notification Code
 *
 * Defines native PHP stream constants for notificationcode operations.
 * @since 1.0.0
 */
enum NotificationCode:int {

    /**
     * ### Reports remote address resolution.
     * @since 1.0.0
     */
    case RESOLVE = STREAM_NOTIFY_RESOLVE;

    /**
     * ### Reports that a connection has been established.
     * @since 1.0.0
     */
    case CONNECT = STREAM_NOTIFY_CONNECT;

    /**
     * ### Reports that authentication is required.
     * @since 1.0.0
     */
    case AUTH_REQUIRED = STREAM_NOTIFY_AUTH_REQUIRED;

    /**
     * ### Reports the detected MIME type.
     * @since 1.0.0
     */
    case MIME_TYPE_IS = STREAM_NOTIFY_MIME_TYPE_IS;

    /**
     * ### Reports the detected resource size.
     * @since 1.0.0
     */
    case FILE_SIZE_IS = STREAM_NOTIFY_FILE_SIZE_IS;

    /**
     * ### Reports redirection to another resource.
     * @since 1.0.0
     */
    case REDIRECTED = STREAM_NOTIFY_REDIRECTED;

    /**
     * ### Reports stream transfer progress.
     * @since 1.0.0
     */
    case PROGRESS = STREAM_NOTIFY_PROGRESS;

    /**
     * ### Reports that the stream has completed.
     * @since 1.0.0
     */
    case COMPLETED = STREAM_NOTIFY_COMPLETED;

    /**
     * ### Reports a stream operation failure.
     * @since 1.0.0
     */
    case FAILURE = STREAM_NOTIFY_FAILURE;

    /**
     * ### Reports the result of authentication.
     * @since 1.0.0
     */
    case AUTH_RESULT = STREAM_NOTIFY_AUTH_RESULT;

}
