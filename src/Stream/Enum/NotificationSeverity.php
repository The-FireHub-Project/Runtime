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
 * ### Notification Severity
 *
 * Defines native PHP stream constants for notificationseverity operations.
 * @since 1.0.0
 */
enum NotificationSeverity:int {

    /**
     * ### Reports an informational notification.
     * @since 1.0.0
     */
    case INFO = STREAM_NOTIFY_SEVERITY_INFO;

    /**
     * ### Reports a noncritical warning.
     * @since 1.0.0
     */
    case WARNING = STREAM_NOTIFY_SEVERITY_WARN;

    /**
     * ### Reports a critical error.
     * @since 1.0.0
     */
    case ERROR = STREAM_NOTIFY_SEVERITY_ERR;

}
