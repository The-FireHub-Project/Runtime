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
 * ### Wrapper Metadata Operation
 *
 * Defines native PHP stream constants for wrappermetadataoperation operations.
 * @since 1.0.0
 */
enum WrapperMetadataOperation:int {

    /**
     * ### Updates timestamps for a stream resource.
     * @since 1.0.0
     */
    case TOUCH = STREAM_META_TOUCH;

    /**
     * ### Changes the numeric owner of a stream resource.
     * @since 1.0.0
     */
    case OWNER = STREAM_META_OWNER;

    /**
     * ### Changes the owner by name.
     * @since 1.0.0
     */
    case OWNER_NAME = STREAM_META_OWNER_NAME;

    /**
     * ### Changes the numeric group of a stream resource.
     * @since 1.0.0
     */
    case GROUP = STREAM_META_GROUP;

    /**
     * ### Changes the group by name.
     * @since 1.0.0
     */
    case GROUP_NAME = STREAM_META_GROUP_NAME;

    /**
     * ### Changes permissions on a stream resource.
     * @since 1.0.0
     */
    case ACCESS = STREAM_META_ACCESS;

}
