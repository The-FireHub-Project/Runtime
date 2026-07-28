<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.4
 * @package Runtime
 */

namespace FireHub\Runtime\System;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Core\Type\Php\Ini\AccessLevel;
use FireHub\Runtime\Str;
use FireHub\Runtime\Exception\ {
    ConfigurationOptionNotFoundException, ConfigurationRetrievalException, ExtensionNotFoundException,
    FailedToSetConfigurationOptionException, InvalidConfigurationQuantityException
};

use function ini_get;
use function ini_get_all;
use function ini_restore;
use function ini_parse_quantity;
use function ini_set;
use function php_ini_loaded_file;

/**
 * ### PHP Runtime Configuration Utilities
 *
 * Provides low-level access to PHP runtime configuration values, including reading, modifying, and restoring
 * configuration directives while preserving native PHP behavior.
 *
 * This component exposes PHP configuration management capabilities through a consistent FireHub Runtime API without
 * altering the underlying PHP configuration system.
 * @since 1.0.0
 */
final class Configuration extends NativeRuntime {

    /**
     * ### Retrieve a path to the loaded php.ini file
     * @since 1.0.0
     *
     * @return non-empty-string|false The loaded php.ini path, or false if one is not loaded.
     */
    public static function getPath ():string|false {

        return php_ini_loaded_file();

    }

    /**
     * ### Gets the value of a configuration option
     * @since 1.0.0
     *
     * @param non-empty-string $option <p>
     * The configuration option name.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\ConfigurationOptionNotFoundException If configuration option is not valid.
     *
     * @return string Value of the configuration option as a string on success, or an empty string for null
     * values.
     *
     * @note A boolean ini value of off will be returned as an empty string or "0" while a boolean ini value of on
     * will be returned as "1".
     * The function can also return the literal string of INI value.
     * @note Method can't read array ini options such as pdo.dsn.*, and returns false in this case.
     */
    public static function get (string $option):string {

        return ($value = ini_get($option)) !== false
            ? $value
            : throw new ConfigurationOptionNotFoundException;

    }

    /**
     * ### Gets all configuration options
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Type\Php\Ini\AccessLevel To set an access level.
     * @uses \FireHub\Runtime\System\Extension::hasExtension() To check if the extension is loaded.
     *
     * @param null|non-empty-string $extension <p>
     * An optional extension name.
     *
     * If not null or the string core, the function returns only options specific for that extension.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\ExtensionNotFoundException If the extension is not valid.
     * @throws \FireHub\Runtime\Exception\ConfigurationRetrievalException If failed to retrieve configuration.
     *
     * @return array<non-empty-string, array{global_value: null|int|string, local_value: null|int|string, access: \FireHub\Core\Type\Php\Ini\AccessLevel}>
     * Associative array with a directive name as the array key.
     *
     * @note Method ignores "array" ini options such as pdo.dsn.*.
     */
    public static function getAll (?string $extension = null):array {

        if ($extension !== null && Extension::hasExtension($extension) === false)
            throw new ExtensionNotFoundException;

        /** @var array<non-empty-string, array{
         *   global_value: null|int|string,
         *   local_value: null|int|string,
         *   access: int
         * }>|false $options
         */
        $options = ini_get_all($extension);

        if ($options === false)
            throw new ConfigurationRetrievalException;

        foreach ($options as $option => $values)
            $options[$option]['access'] = AccessLevel::from($values['access']);

        return $options;

    }

    /**
     * ### Sets the value of a configuration option
     *
     * Sets the value of the given configuration option.
     *
     * The configuration option will keep this new value during the script's execution and will be restored at the
     * script's ending.
     * @since 1.0.0
     *
     * @param non-empty-string $option <p>
     * The configuration option name.
     * </p>
     * @param null|scalar $value <p>
     * The new value for the option.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\FailedToSetConfigurationOptionException If failed to set configuration option.
     *
     * @return True Always true.
     *
     * @note A boolean ini value of off will be returned as an empty string or "0" while a boolean ini value of on
     * will be returned as "1".
     * The function can also return the literal string of INI value.
     * @note Method can't read array ini options such as pdo.dsn.*, and returns false in this case.
     */
    public static function set (string $option, null|int|float|string|bool $value):true {

        return ini_set($option, $value) !== false
            ? true : throw new FailedToSetConfigurationOptionException;

    }

    /**
     * ### Restores the value of a configuration option to its original value
     * @since 1.0.0
     *
     * @uses self::get() To get the original value.
     *
     * @param non-empty-string $option <p>
     * The configuration option name.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\ConfigurationOptionNotFoundException If configuration option is not valid.
     *
     * @return string Value of the configuration option as a string on success, or an empty string for null
     * values.
     *
     * @note A boolean ini value of off will be returned as an empty string or "0" while a boolean ini value of on
     * will be returned as "1".
     * The function can also return the literal string of INI value.
     * @note Method can't read array ini options such as pdo.dsn.*, and returns false in this case.
     */
    public static function restore (string $option):string {

        ini_restore($option);

        return self::get($option);

    }

    /**
     * ### Get interpreted size from ini shorthand syntax
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Str\SB\Transform::trim() To trim the input string.
     * @uses \FireHub\Runtime\Str\SB\Regex::match() To validate the input string.
     *
     * @param non-empty-string $shorthand <p>
     * Ini shorthand to parse, there must be a number followed by an optional multiplier.
     *
     * The following multipliers are supported: k/K (1024), m/M (1048576), g/G (1073741824).
     *
     * The number can be a decimal, hex (prefixed with 0x or 0X), octal (prefixed with 0o, 0O, or 0) or binary
     * (prefixed with 0b or 0B).
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidConfigurationQuantityException If shorthand is not valid.
     * @throws \FireHub\Runtime\Exception\InvalidPatternException If shorthand is not valid.
     *
     * @return non-negative-int Interpreted size in bytes on success from ini shorthand.
     */
    public static function parseQuantity (string $shorthand):int {

        /** @var non-negative-int */
        return Str\SB\Regex::match(
            '/^(?:0x[0-9a-fA-F]+|0b[01]+|0o[0-7]+|\d+)[KMG]?$/x',
            Str\SB\Transform::trim($shorthand)
        ) === false
            ? throw new InvalidConfigurationQuantityException
            : ini_parse_quantity($shorthand);

    }

}