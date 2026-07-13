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

use FireHub\Core\Exception\Runtime\InvalidArgumentException;

/**
 * #### Invalid Range FireHub Exception
 *
 * Represents a failure caused by a value that is outside the valid range.
 * @since 1.0.0
 */
final class InvalidRangeException extends InvalidArgumentException {

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     */
    protected const string DEFAULT_MESSAGE = 'The provided value is outside the valid range.';

}