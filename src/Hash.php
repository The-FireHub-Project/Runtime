<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.5
 * @package Runtime
 */

namespace FireHub\Runtime;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Runtime\Hash\Algorithm;
use FireHub\Runtime\Exception\ {
    EmptyHashKeyException, HashByteLengthException, HashIterationException
};
use SensitiveParameter, Throwable;

use function hash;
use function hash_algos;
use function hash_equals;
use function hash_file;
use function hash_hkdf;
use function hash_hmac;
use function hash_hmac_algos;
use function hash_hmac_file;
use function hash_pbkdf2;

/**
 * ### PHP Runtime Hash Utilities
 *
 * Provides low-level wrappers for generating and comparing hashes using native PHP hash utilities while preserving
 * native runtime behavior.
 *
 * This component exposes PHP hashing capabilities through a consistent FireHub Runtime API without altering native
 * hashing semantics.
 * @since 1.0.0
 */
final class Hash extends NativeRuntime {

    /**
     * ### Generates a hash value
     * @since 1.0.0
     *
     * @param \FireHub\Runtime\Hash\Algorithm $algorithm <p>
     * The hashing algorithm to use.
     * </p>
     * @param string $data <p>
     * Message to be hashed.
     * </p>
     * @param bool $binary [optional] <p>
     * When set to true, outputs raw binary data. false outputs lowercase hexits.
     * </p>
     * @param array<string, mixed> $options [optional] <p>
     * An associative array of hashing options.
     * </p>
     *
     * @return non-empty-string Returns a string containing the calculated message digest as lowercase hexits unless
     * binary is set to true in which case the raw binary representation of the message digest is returned.
     */
    public static function hash (Algorithm $algorithm, string $data, bool $binary = false, array $options = []):string {

        return hash($algorithm->value, $data, $binary, $options);

    }

    /**
     * ### Generate a hash value using the contents of a given file
     * @since 1.0.0
     *
     * @param \FireHub\Runtime\Hash\Algorithm $algorithm <p>
     * The hashing algorithm to use.
     * </p>
     * @param string $data <p>
     * Message to be hashed.
     * </p>
     * @param bool $binary [optional] <p>
     * When set to true, outputs raw binary data. false outputs lowercase hexits.
     * </p>
     * @param array<string, mixed> $options [optional] <p>
     * An associative array of hashing options.
     * </p>
     *
     * @return non-empty-string|false Returns a string containing the calculated message digest as lowercase hexits
     * unless binary is set to true in which case the raw binary representation of the message digest is returned, or
     * false on failure.
     */
    public static function file (Algorithm $algorithm, string $data, bool $binary = false, array $options = []):string|false {

        return hash_file($algorithm->value, $data, $binary, $options);

    }

    /**
     * ### Gets available hashing algorithms
     * @since 1.0.0
     *
     * @return list<non-empty-string> Returns a numerically indexed array containing the list of supported hashing
     * algorithms.
     */
    public static function algorithms ():array {

        return hash_algos();

    }

    /**
     * ### Generate a keyed hash value using the HMAC method
     * @since 1.0.0
     *
     * @param \FireHub\Runtime\Hash\Algorithm $algorithm <p>
     * The hashing algorithm to use.
     * </p>
     * @param string $data <p>
     * Message to be hashed.
     * </p>
     * @param string $key <p>
     * Shared secret key used for generating the HMAC variant of the message digest
     * </p>
     * @param bool $binary [optional] <p>
     * When set to true, outputs raw binary data. false outputs lowercase hexits.
     * </p>
     *
     * @return non-empty-string Returns a string containing the calculated message digest as lowercase hexits unless
     * binary is set to true in which case the raw binary representation of the message digest is returned.
     */
    public static function hmacHash (Algorithm $algorithm, string $data, #[SensitiveParameter] string $key, bool $binary = false):string {

        return hash_hmac($algorithm->value, $data, $key, $binary);

    }

    /**
     * ### Generate a keyed hash value using the HMAC method
     * @since 1.0.0
     *
     * @param \FireHub\Runtime\Hash\Algorithm $algorithm <p>
     * The hashing algorithm to use.
     * </p>
     * @param string $data <p>
     * Message to be hashed.
     * </p>
     * @param string $key <p>
     * Shared secret key used for generating the HMAC variant of the message digest
     * </p>
     * @param bool $binary [optional] <p>
     * When set to true, outputs raw binary data. false outputs lowercase hexits.
     * </p>
     *
     * @return non-empty-string|false Returns a string containing the calculated message digest as lowercase hexits
     * unless binary is set to true in which case the raw binary representation of the message digest is returned.
     * Returns false if the file filename cannot be read.
     */
    public static function hmacFile (Algorithm $algorithm, string $data, #[SensitiveParameter] string $key, bool $binary = false):string|false {

        return hash_hmac_file($algorithm->value, $data, $key, $binary);

    }

    /**
     * ### Gets available hashing algorithms suitable for hmac hashing
     * @since 1.0.0
     *
     * @return list<non-empty-string> Returns a numerically indexed array containing the list of supported hashing
     * algorithms suitable for hmac hashing.
     */
    public static function hmacAlgorithms ():array {

        return hash_hmac_algos();

    }

    /**
     * ### Timing attack safe string comparison
     * @since 1.0.0
     *
     * @param string $known <p>
     * The known string that must be kept secret.
     * </p>
     * @param string $user <p>
     * The user-supplied string to compare against.
     * </p>
     *
     * @return bool Returns true when the two strings are equal, false otherwise.
     */
    public static function equals (#[SensitiveParameter] string $known, #[SensitiveParameter] string $user):bool {

        return hash_equals($known, $user);

    }

    /**
     * ### Generate a HKDF key derivation of a supplied key input
     * @since 1.0.0
     *
     * @param \FireHub\Runtime\Hash\Algorithm $algorithm <p>
     * The hashing algorithm to use.
     * </p>
     * @param non-empty-string $key <p>
     * Input keying material (raw binary).
     * </p>
     * @param non-negative-int $length [optional] <p>
     * Desired output length in bytes.
     *
     * Cannot be greater than 255 times the chosen hash function size.
     *
     * If length is 0, the output length will default to the chosen hash function size.
     * </p>
     * @param string $info [optional] <p>
     * Application/context-specific info string.
     * </p>
     * @param string $salt [optional] <p>
     * Salt to use during derivation.
     *
     * While optional, adding random salt significantly improves the strength of HKDF.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\EmptyHashKeyException If the key is empty.
     * @throws \FireHub\Runtime\Exception\HashByteLengthException If the key is too long.
     *
     * @return non-empty-string Returns a string containing a raw binary representation of the derived key (also
     * known as output keying material - OKM).
     */
    public static function hkdf (Algorithm $algorithm, #[SensitiveParameter] string $key, int $length = 0, string $info = '', string $salt = ''):string {

        if ($key === '') throw new EmptyHashKeyException;

        try {

            return hash_hkdf($algorithm->value, $key, $length, $info, $salt);

        } catch (Throwable $e) {

            throw new HashByteLengthException($e->getMessage());
        }

    }

    /**
     * ### Generates a PBKDF2 key derivation
     *
     * Generates a PBKDF2 key derivation using the specified hashing algorithm, password, salt, iteration count,
     * and output length.
     * @since 1.0.0
     *
     * @param \FireHub\Runtime\Hash\Algorithm $algorithm <p>
     * The hashing algorithm to use.
     * </p>
     * @param string $password <p>
     * The password to use for the derivation.
     * </p>
     * @param string $salt <p>
     * The salt to use for the derivation. This value should be generated randomly.
     * </p>
     * @param positive-int $iterations <p>
     * The number of internal iterations to perform for the derivation.
     * </p>
     * @param non-negative-int $length <p>
     * The length of the output string. If binary is true this corresponds to the byte-length of the derived key, if
     * binary is false this corresponds to twice the byte-length of the derived key (as every byte of the key is
     * returned as two hexits).
     *
     * If 0 is passed, the entire output of the supplied algorithm is used.
     * </p>
     * @param bool $binary <p>
     * Whether to return raw binary data instead of lowercase hexadecimal output.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\HashIterationException If the number of iterations is less than one.
     * @throws \FireHub\Runtime\Exception\HashByteLengthException If the key is too long.
     *
     * @return non-empty-string Returns a string containing the derived key as lowercase hexits unless binary is set
     * to true in which case the raw binary representation of the derived key is returned.
     */
    public static function pbkdf2 (Algorithm $algorithm, #[SensitiveParameter] string $password, string $salt, int $iterations, int $length = 0, bool $binary = false):string {

        if ($iterations < 1) throw new HashIterationException("The number of iterations must be greater than zero.");

        try {

            return hash_pbkdf2(
                $algorithm->value,
                $password,
                $salt,
                $iterations,
                $length,
                $binary
            );

        } catch (Throwable $e) {

            throw new HashByteLengthException($e->getMessage());
        }

    }

}