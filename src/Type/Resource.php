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

namespace FireHub\Runtime\Type;

/**
 * ### Supported PHP runtime resource types
 *
 * Represents resource types exposed by PHP native runtime functions.
 *
 * This enumeration contains stable resource identifiers returned by PHP resource inspection APIs while preserving
 * native runtime behavior.
 *
 * Extension-specific resources should be defined by their corresponding FireHub Capability modules.
 * @since 1.0.0
 */
enum Resource:string {

    /**
     * ### Stream resource
     * @since 1.0.0
     */
    case STREAM = 'stream';

    /**
     * ### Stream context resource
     * @since 1.0.0
     */
    case STREAM_CONTEXT = 'stream-context';

    /**
     * ### Process resource
     * @since 1.0.0
     */
    case PROCESS = 'process';

    /**
     * ### Unknown resource type
     *
     * Represents an unsupported or unidentified native resource type.
     * @since 1.0.0
     */
    case UNKNOWN = 'unknown';

}