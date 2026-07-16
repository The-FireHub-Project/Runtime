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
use FireHub\Runtime\Exception\InvalidEncodingException;

use function mb_internal_encoding;

/**
 * ### PHP Multibyte String Runtime Wrapper Utility - Configuration
 *
 * Provides runtime wrappers for configuring multibyte string behavior, including internal character encoding
 * settings used by the PHP mbstring extension.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for managing multibyte string
 * runtime configuration while preserving native PHP behavior, encoding support, and runtime performance.
 * @since 1.0.0
 */
final class Configuration extends NativeRuntime {

    /**
     * ### Set/Get internal character encoding
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Type\Str\Encoding The encoding parameter for character encoding.
     *
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding [optional] <p>
     * Encoding is the character encoding name used for the HTTP input character encoding conversion, HTTP output
     * character encoding conversion, and the default character encoding for string functions defined by the mbstring
     * module.
     *
     * You should notice that the internal encoding is totally different from the one for multibyte regex.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidEncodingException If the current runtime encoding is not supported by FireHub.
     *
     * @return ($encoding is null ? \FireHub\Core\Type\Str\Encoding : true) If encoding is set, then
     * returns true.
     * In this case, the character encoding for multibyte regex is NOT changed.
     * If encoding is omitted, then the current character encoding name is returned.
     */
    public static function encoding (?Encoding $encoding = null):true|Encoding {

        return $encoding !== null
            ? mb_internal_encoding($encoding->value)
            : (($new_encoding = Encoding::tryFrom($internal_encoding = mb_internal_encoding())) !== null
                ? $new_encoding
                : throw new InvalidEncodingException(
                    'Unsupported internal encoding returned by mbstring.',
                    [
                        'encoding' => $internal_encoding,
                    ]
                ));

    }

}