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

namespace FireHub\Runtime\Str\MB;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Core\Type\Str\Encoding;

use function mb_stripos;
use function mb_strpos;
use function mb_strripos;
use function mb_strrpos;

/**
 * ### PHP Multibyte String Runtime Wrapper Utility - Search
 *
 * Provides runtime wrappers for searching within multibyte string data, including encoding-aware substring lookup,
 * character occurrence detection, position retrieval, and string matching operations while preserving native PHP
 * behavior.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for character-aware string search
 * operations with support for Unicode and multibyte encodings without introducing domain logic, framework coupling,
 * or additional abstraction overhead.
 * @since 1.0.0
 */
final class Search extends NativeRuntime {

    /**
     * ### Find the position of the first occurrence for a substring in a string
     * @since 1.0.0
     *
     * @param string $search <p>
     * A string to find position.
     * </p>
     * @param string $string <p>
     * The string to search in.
     * </p>
     * @param bool $case_sensitive [optional] <p>
     * Search case-sensitive position.
     * </p>
     * @param int $offset [optional] <p>
     * If specified, search will start this number of characters counted from the beginning of the string.
     * </p>
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding [optional] <p>
     * Character encoding.
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @return false|non-negative-int Numeric position of the first occurrence or false if none exist.
     */
    public static function firstPosition (string $search, string $string, bool $case_sensitive = true, int $offset = 0, ?Encoding $encoding = null):false|int {

        if ($case_sensitive) return mb_strpos($string, $search, $offset, $encoding?->value);

        return mb_stripos($string, $search, $offset, $encoding?->value);

    }

    /**
     * ### Find the position of the last occurrence for a substring in a string
     * @since 1.0.0
     *
     * @param string $search <p>
     * A string to find position.
     * </p>
     * @param string $string <p>
     * The string to search in.
     * </p>
     * @param bool $case_sensitive [optional] <p>
     * Search case-sensitive position.
     * </p>
     * @param int $offset [optional] <p>
     * If specified, search will start this number of characters counted from the beginning of the string.
     * </p>
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding [optional] <p>
     * Character encoding.
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @return false|non-negative-int Numeric position of the last occurrence or false if none exist.
     */
    public static function lastPosition (string $search, string $string, bool $case_sensitive = true, int $offset = 0, ?Encoding $encoding = null):false|int {

        if ($case_sensitive) return mb_strrpos($string, $search, $offset, $encoding?->value);

        return mb_strripos($string, $search, $offset, $encoding?->value);

    }

}