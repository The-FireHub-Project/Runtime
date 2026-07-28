<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.3
 * @package Runtime
 */

namespace FireHub\Runtime\Exception;

use FireHub\Core\Exception\Runtime\SystemException;

/**
 * ### Represents a failure caused by a random byte length being too small
 * @since 1.0.0
 */
final class RandomByteLengthTooSmallException extends SystemException {

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     */
    protected const string DEFAULT_MESSAGE = 'The provided random byte length is too small.';

}