<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.1
 * @package Runtime\Tests
 */

namespace FireHub\Runtime\Hash;

/**
 * ### Hash Algorithm
 *
 * Defines hashing algorithms supported by the PHP hash extension.
 * @since 1.0.0
 */
enum Algorithm:string {


    /* * ============================================================
     * MD
     * ============================================================ */

    /**
     * ### MD2 message-digest algorithm
     * @since 1.0.0
     */
    case MD2 = 'md2';

    /**
     * ### MD4 message-digest algorithm
     * @since 1.0.0
     */
    case MD4 = 'md4';

    /**
     * ### MD5 message-digest algorithm
     * @since 1.0.0
     */
    case MD5 = 'md5';


    /* * ============================================================
     * SHA-1 and SHA-2
     * ============================================================ */

    /**
     * ### SHA-1 secure hash algorithm
     * @since 1.0.0
     */
    case SHA1 = 'sha1';

    /**
     * ### SHA-224 secure hash algorithm
     * @since 1.0.0
     */
    case SHA224 = 'sha224';

    /**
     * ### SHA-256 secure hash algorithm
     * @since 1.0.0
     */
    case SHA256 = 'sha256';

    /**
     * ### SHA-384 secure hash algorithm
     * @since 1.0.0
     */
    case SHA384 = 'sha384';

    /**
     * ### SHA-512/224 secure hash algorithm
     * @since 1.0.0
     */
    case SHA512_224 = 'sha512/224';

    /**
     * ### SHA-512/256 secure hash algorithm
     * @since 1.0.0
     */
    case SHA512_256 = 'sha512/256';

    /**
     * ### SHA-512 secure hash algorithm
     * @since 1.0.0
     */
    case SHA512 = 'sha512';


    /* * ============================================================
     * SHA-3
     * ============================================================ */

    /**
     * ### SHA3-224 secure hash algorithm
     * @since 1.0.0
     */
    case SHA3_224 = 'sha3-224';

    /**
     * ### SHA3-256 secure hash algorithm
     * @since 1.0.0
     */
    case SHA3_256 = 'sha3-256';

    /**
     * ### SHA3-384 secure hash algorithm
     * @since 1.0.0
     */
    case SHA3_384 = 'sha3-384';

    /**
     * ### SHA3-512 secure hash algorithm
     * @since 1.0.0
     */
    case SHA3_512 = 'sha3-512';


    /* * ============================================================
     * RIPEMD
     * ============================================================ */

    /**
     * ### RIPEMD-128 message-digest algorithm
     * @since 1.0.0
     */
    case RIPEMD128 = 'ripemd128';

    /**
     * ### RIPEMD-160 message-digest algorithm
     * @since 1.0.0
     */
    case RIPEMD160 = 'ripemd160';

    /**
     * ### RIPEMD-256 message-digest algorithm
     * @since 1.0.0
     */
    case RIPEMD256 = 'ripemd256';

    /**
     * ### RIPEMD-320 message-digest algorithm
     * @since 1.0.0
     */
    case RIPEMD320 = 'ripemd320';


    /* * ============================================================
     * Whirlpool
     * ============================================================ */

    /**
     * ### Whirlpool cryptographic hash algorithm
     * @since 1.0.0
     */
    case WHIRLPOOL = 'whirlpool';


    /* * ============================================================
     * Tiger
     * ============================================================ */

    /**
     * ### Tiger-128 hash algorithm with three passes
     * @since 1.0.0
     */
    case TIGER128_3 = 'tiger128,3';

    /**
     * ### Tiger-160 hash algorithm with three passes
     * @since 1.0.0
     */
    case TIGER160_3 = 'tiger160,3';

    /**
     * ### Tiger-192 hash algorithm with three passes
     * @since 1.0.0
     */
    case TIGER192_3 = 'tiger192,3';

    /**
     * ### Tiger-128 hash algorithm with four passes
     * @since 1.0.0
     */
    case TIGER128_4 = 'tiger128,4';

    /**
     * ### Tiger-160 hash algorithm with four passes
     * @since 1.0.0
     */
    case TIGER160_4 = 'tiger160,4';

    /**
     * ### Tiger-192 hash algorithm with four passes
     * @since 1.0.0
     */
    case TIGER192_4 = 'tiger192,4';


    /* * ============================================================
     * Snefru
     * ============================================================ */

    /**
     * ### Snefru hash algorithm
     * @since 1.0.0
     */
    case SNEFRU = 'snefru';

    /**
     * ### Snefru-256 hash algorithm
     * @since 1.0.0
     */
    case SNEFRU256 = 'snefru256';


    /* * ============================================================
     * GOST
     * ============================================================ */

    /**
     * ### GOST hash algorithm
     * @since 1.0.0
     */
    case GOST = 'gost';

    /**
     * ### GOST CryptoPro hash algorithm
     * @since 1.0.0
     */
    case GOST_CRYPTO = 'gost-crypto';


    /* * ============================================================
     * Checksums
     * ============================================================ */

    /**
     * ### Adler-32 checksum algorithm
     * @since 1.0.0
     */
    case ADLER32 = 'adler32';

    /**
     * ### CRC-32 checksum algorithm
     * @since 1.0.0
     */
    case CRC32 = 'crc32';

    /**
     * ### CRC-32B checksum algorithm
     * @since 1.0.0
     */
    case CRC32B = 'crc32b';

    /**
     * ### CRC-32C checksum algorithm
     * @since 1.0.0
     */
    case CRC32C = 'crc32c';


    /* * ============================================================
     * FNV
     * ============================================================ */

    /**
     * ### FNV-1 32-bit non-cryptographic hash algorithm
     * @since 1.0.0
     */
    case FNV132 = 'fnv132';

    /**
     * ### FNV-1a 32-bit non-cryptographic hash algorithm
     * @since 1.0.0
     */
    case FNV1A32 = 'fnv1a32';

    /**
     * ### FNV-1 64-bit non-cryptographic hash algorithm
     * @since 1.0.0
     */
    case FNV164 = 'fnv164';

    /**
     * ### FNV-1a 64-bit non-cryptographic hash algorithm
     * @since 1.0.0
     */
    case FNV1A64 = 'fnv1a64';


    /* * ============================================================
     * Jenkins
     * ============================================================ */

    /**
     * ### Jenkins one-at-a-time non-cryptographic hash algorithm
     * @since 1.0.0
     */
    case JOAAT = 'joaat';


    /* * ============================================================
     * MurmurHash
     * ============================================================ */

    /**
     * ### MurmurHash3 32-bit hash algorithm
     * @since 1.0.0
     */
    case MURMUR3A = 'murmur3a';

    /**
     * ### MurmurHash3 128-bit x86 hash algorithm
     * @since 1.0.0
     */
    case MURMUR3C = 'murmur3c';

    /**
     * ### MurmurHash3 128-bit x64 hash algorithm
     * @since 1.0.0
     */
    case MURMUR3F = 'murmur3f';


    /* * ============================================================
     * xxHash
     * ============================================================ */

    /**
     * ### xxHash 32-bit non-cryptographic hash algorithm
     * @since 1.0.0
     */
    case XXH32 = 'xxh32';

    /**
     * ### xxHash 64-bit non-cryptographic hash algorithm
     * @since 1.0.0
     */
    case XXH64 = 'xxh64';

    /**
     * ### XXH3 64-bit non-cryptographic hash algorithm
     * @since 1.0.0
     */
    case XXH3 = 'xxh3';

    /**
     * ### XXH3 128-bit non-cryptographic hash algorithm
     * @since 1.0.0
     */
    case XXH128 = 'xxh128';


    /* * ============================================================
     * HAVAL
     * ============================================================ */

    /**
     * ### HAVAL-128 hash algorithm with three passes
     * @since 1.0.0
     */
    case HAVAL128_3 = 'haval128,3';

    /**
     * ### HAVAL-160 hash algorithm with three passes
     * @since 1.0.0
     */
    case HAVAL160_3 = 'haval160,3';

    /**
     * ### HAVAL-192 hash algorithm with three passes
     * @since 1.0.0
     */
    case HAVAL192_3 = 'haval192,3';

    /**
     * ### HAVAL-224 hash algorithm with three passes
     * @since 1.0.0
     */
    case HAVAL224_3 = 'haval224,3';

    /**
     * ### HAVAL-256 hash algorithm with three passes
     * @since 1.0.0
     */
    case HAVAL256_3 = 'haval256,3';

    /**
     * ### HAVAL-128 hash algorithm with four passes
     * @since 1.0.0
     */
    case HAVAL128_4 = 'haval128,4';

    /**
     * ### HAVAL-160 hash algorithm with four passes
     * @since 1.0.0
     */
    case HAVAL160_4 = 'haval160,4';

    /**
     * ### HAVAL-192 hash algorithm with four passes
     * @since 1.0.0
     */
    case HAVAL192_4 = 'haval192,4';

    /**
     * ### HAVAL-224 hash algorithm with four passes
     * @since 1.0.0
     */
    case HAVAL224_4 = 'haval224,4';

    /**
     * ### HAVAL-256 hash algorithm with four passes
     * @since 1.0.0
     */
    case HAVAL256_4 = 'haval256,4';

    /**
     * ### HAVAL-128 hash algorithm with five passes
     * @since 1.0.0
     */
    case HAVAL128_5 = 'haval128,5';

    /**
     * ### HAVAL-160 hash algorithm with five passes
     * @since 1.0.0
     */
    case HAVAL160_5 = 'haval160,5';

    /**
     * ### HAVAL-192 hash algorithm with five passes
     * @since 1.0.0
     */
    case HAVAL192_5 = 'haval192,5';

    /**
     * ### HAVAL-224 hash algorithm with five passes
     * @since 1.0.0
     */
    case HAVAL224_5 = 'haval224,5';

    /**
     * ### HAVAL-256 hash algorithm with five passes
     * @since 1.0.0
     */
    case HAVAL256_5 = 'haval256,5';

    /**
     * ### Checks whether the algorithm supports HMAC
     * @since 1.0.0
     *
     * @return bool True if the algorithm supports HMAC, false otherwise.
     */
    public function supportsHmac ():bool {

        return match ($this) {
            self::ADLER32, self::CRC32, self::CRC32B, self::CRC32C,
            self::FNV132, self::FNV1A32, self::FNV164, self::FNV1A64,
            self::JOAAT,
            self::MURMUR3A, self::MURMUR3C, self::MURMUR3F,
            self::XXH32, self::XXH64, self::XXH3, self::XXH128
                => false,
            default => true
        };

    }

}