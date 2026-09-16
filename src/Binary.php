<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=7.4
 * @package Runtime
 */

namespace FireHub\Runtime;

use FireHub\Core\Boundary\Runtime\NativeRuntime;

use function pack;
use function unpack;

/**
 * ### Binary data operations
 *
 * Provides low-level operations for packing values into binary strings and unpacking binary strings into values
 * according to format definitions supported by the PHP runtime.
 *
 * Binary acts as a runtime boundary over native binary representation operations, providing a consistent FireHub
 * API while preserving the behavior and semantics of the underlying PHP runtime.
 * @since 1.0.0
 */
final class Binary extends NativeRuntime {

    /**
     * ### Pack data into a binary string
     *
     * Packs the specified values into a binary string according to the provided format definition.
     * @since 1.0.0
     *
     * @see https://www.php.net/manual/en/function.pack.php
     *
     * @param non-empty-string $format <p>
     * The format used to pack the values.
     * </p>
     *
     * @param mixed ...$values <p>
     * The values to pack into the binary string.
     * </p>
     *
     * @return string Returns a binary string containing data.
     */
    public static function pack (string $format, mixed ...$values):string {

        return pack($format, ...$values);

    }

    /**
     * ### Unpack data from binary string
     *
     * Unpacks values from the specified binary string according to the provided format definition.
     * @since 1.0.0
     *
     * @see https://www.php.net/manual/en/function.unpack.php
     *
     * @param non-empty-string $format <p>
     * The format used to unpack the binary data.
     * </p>
     *
     * @param string $data <p>
     * The packed data.
     * </p>
     *
     * @param non-negative-int $offset <p>
     * The offset to begin unpacking from.
     * </p>
     *
     * @return array<array-key, mixed>|false Returns an associative array containing unpacked elements of binary
     * string, or false on failure.
     */
    public static function unpack (string $format, string $data, int $offset = 0):array|false {

        return unpack($format, $data, $offset);

    }

}