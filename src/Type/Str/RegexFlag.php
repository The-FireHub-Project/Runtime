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
 * ### Defines regular expression flags for string pattern operations
 *
 * Provides a set of flags that modify the behavior of regular expression processing when performing pattern-based
 * operations on strings.
 *
 * These flags control matching behavior such as case sensitivity, multiline handling, UTF mode, extended patterns,
 * and other PCRE-specific options.
 */
enum RegexFlag:string {

    /**
     * ### Makes the expression match case-insensitive
     *
     * If this modifier is set, letters in the pattern match both upper and lower case letters.
     * @since 1.0.0
     */
    case CASELESS = 'i';

    /**
     * ### Multiline characters
     *
     * By default, PCRE treats the subject string as consisting of a single "line" of characters (even if it actually
     * contains several newlines). The "start of line" metacharacter (^) matches only at the start of the string, while
     * the "end of line" metacharacter ($) matches only at the end of the string, or before a terminating newline
     * (unless D modifier is set). This is the same as Perl. When this modifier is set, the "start of line" and
     * "end of line" constructs match immediately following or immediately before any newline in the subject string,
     * respectively, as well as at the very start and end. This is equivalent to Perl's /m modifier.
     * If there are no "\n" characters in a subject string, or no occurrences of ^ or $ in a pattern, setting this
     * modifier has no effect.
     * @since 1.0.0
     */
    case MULTILINE = 'm';

    /**
     * ### Dot metacharacter matches all characters
     *
     * If this modifier is set, a dot metacharacter in the pattern matches all characters, including newlines.
     * Without it, newlines are excluded. This modifier is equivalent to Perl's /s modifier. A negative class such as
     * [^a] always matches a newline character, independent of the setting for this modifier.
     * @since 1.0.0
     */
    case DOT_ALL = 's';

    /**
     * ### Dot metacharacter matches all characters
     *
     * If this modifier is set, whitespace data characters in the pattern are totally ignored except when escaped
     * or inside a character class, and characters between an unescaped # outside a character class
     * and the next newline character, inclusive, are also ignored.
     * This is equivalent to Perl's /x modifier, and makes it possible to include commentary inside complicated
     * patterns.
     * Note, however, that this applies only to data characters.
     * Whitespace characters may never appear within special character sequences in a pattern, for example, within
     * the sequence (?( which introduces a conditional subpattern.
     * @since 1.0.0
     */
    case EXTENDED = 'x';

    /**
     * ### Anchored
     *
     * If this modifier is set, the pattern is forced to be "anchored"; that is, it is constrained to match only at
     * the start of the string which is being searched (the "subject string"). This effect can also be achieved by
     * appropriate constructs in the pattern itself, which is the only way to do it in Perl.
     * @since 1.0.0
     */
    case ANCHORED = 'A';

    /**
     * ### Dollar metacharacter matches only at the end
     *
     * If this modifier is set, a dollar metacharacter in the pattern matches only at the end of the subject string.
     * Without this modifier, a dollar also matches immediately before the final character if it is a newline (but not
     * before any other newlines). This modifier is ignored if m modifier is set. There is no equivalent to this
     * modifier in Perl.
     * @since 1.0.0
     */
    case DOLLAR_END_ONLY = 'D';

    /**
     * ### Extra analysis is performed
     *
     * When a pattern is going to be used several times, it is worth spending more time analyzing it to speed up
     * the time taken for matching. If this modifier is set, then this extra analysis is performed. At present,
     * studying a pattern is useful only for non-anchored patterns that don't have a single fixed starting character.
     * @since 1.0.0
     */
    case EXTRA_ANALYSIS = 'S';

    /**
     * ### Inverts the greediness
     *
     * This modifier inverts the "greediness" of the quantifiers so that they aren't greedy by default, but become
     * greedy if followed by ?. It is not compatible with Perl. It can also be set by a (?U) modifier setting within
     * the pattern or by a question mark behind a quantifier (for example: .*?).
     * @since 1.0.0
     *
     * @see https://www.php.net/manual/en/pcre.configuration.php#ini.pcre.backtrack-limit To see pcre.backtrack_limit
     * configuration.
     *
     * @note It is usually not possible to match more than pcre.backtrack_limit characters in un greedy mode.
     */
    case UN_GREEDY = 'U';

    /**
     * ### Backslash in a pattern that is followed by a letter that has no special meaning causes an error
     *
     * This modifier turns on additional functionality of PCRE that is incompatible with Perl. Any backslash in
     * a pattern that is followed by a letter that has no special meaning causes an error, thus reserving these
     * combinations for future expansion. By default, as in Perl, a backslash followed by a letter with no special
     * meaning is treated as a literal. There are at present no other features controlled by this modifier.
     * @since 1.0.0
     */
    case EXTRA = 'X';

    /**
     * ### Extra analysis is performed
     *
     * The (?J) internal option setting changes the local PCRE_DUPNAMES option. Allow duplicate names for
     * sub-patterns. As of PHP 7.2.0, J is supported as a modifier as well.
     * @since 1.0.0
     */
    case INFO_J_CHANGED = 'J';

    /**
     * ### Pattern and subject strings are treated as UTF-8
     *
     * This modifier turns on additional functionality of PCRE that is incompatible with Perl. Pattern and subject
     * strings are treated as UTF-8. An invalid subject will cause the preg_* function to match nothing; an invalid
     * pattern will trigger an error of level E_WARNING. Five and six-octet UTF-8 sequences are regarded as invalid.
     * @since 1.0.0
     */
    case MULTIBYTE = 'u';

    /**
     * ### Don't capture simple groups
     *
     * This modifier makes simple (xyz) groups non-capturing. Only named groups like (?<name>xyz) are captured.
     * This only affects which groups are captured, it is still possible to use numbered subpattern references, and
     * the matches array will still contain numbered results.
     * @since 1.0.0
     */
    case NO_AUTO_CAPTURE = 'n';

}