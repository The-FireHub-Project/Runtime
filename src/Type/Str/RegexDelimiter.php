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

namespace FireHub\Runtime\Type\Str;

/**
 * ### Defines delimiters used for regular expression patterns
 *
 * Provides supported delimiters used to wrap regular expression patterns when performing PCRE-based string operations.
 *
 * Delimiters separate the pattern body from optional regular expression modifiers and help avoid unnecessary
 * escaping of characters inside patterns.
 */
enum RegexDelimiter:string {

    /**
     * ### Forward slash delimiter
     *
     * The default delimiter is commonly used in PHP regular expressions.
     * @since 1.0.0
     */
    case SLASH = '/';

    /**
     * ### Hash delimiter
     *
     * Useful for patterns containing forward slashes such as URLs and paths.
     * @since 1.0.0
     */
    case HASH = '#';

    /**
     * ### Tilde delimiter
     *
     * Commonly used as an alternative delimiter for readable expressions.
     * @since 1.0.0
     */
    case TILDE = '~';

    /**
     * ### Percent delimiter
     *
     * Alternative delimiter for reducing escaping requirements.
     * @since 1.0.0
     */
    case PERCENT = '%';

    /**
     * ### At sign delimiter
     *
     * Alternative delimiter suitable for patterns containing common symbols.
     * @since 1.0.0
     */
    case AT = '@';

    /**
     * ### Exclamation delimiter
     *
     * Alternative delimiter for expressions where other delimiters are present.
     * @since 1.0.0
     */
    case EXCLAMATION = '!';

}