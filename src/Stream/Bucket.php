<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.2
 * @package Runtime
 */

namespace FireHub\Runtime\Stream;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use StreamBucket;

use function stream_bucket_make_writeable;
use function stream_bucket_new;
use function stream_bucket_append;
use function stream_bucket_prepend;

/**
 * ### PHP Runtime Stream Bucket Utilities
 *
 * Provides low-level wrappers for managing buckets within PHP stream filter brigades.
 *
 * Supports creating buckets, retrieving writable buckets, and adding buckets to the beginning or end of a brigade.
 *
 * This component preserves native PHP stream bucket behavior.
 * @since 1.0.0
 */
final readonly class Bucket extends NativeRuntime {

    /**
     * ### Retrieves a writable bucket
     *
     * Retrieves and removes the next bucket from the specified bucket brigade.
     *
     * Returns null when no bucket is available.
     * @since 1.0.0
     *
     * @param resource $brigade <p>
     * Bucket brigade resource from which a writable bucket will be retrieved.
     * </p>
     *
     * @return null|StreamBucket Writable stream bucket, or null when the brigade contains no available buckets.
     */
    public static function makeWriteable (mixed $brigade):?StreamBucket {

        return stream_bucket_make_writeable($brigade);

    }

    /**
     * ### Creates a new stream bucket
     *
     * Creates a new bucket containing the specified data and associates it with the provided stream.
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream resource associated with the new bucket.
     * </p>
     * @param string $data <p>
     * Data to store in the newly created bucket.
     * </p>
     *
     * @return StreamBucket Newly created stream bucket.
     */
    public static function create (mixed $stream, string $data):StreamBucket {

        return stream_bucket_new($stream, $data);

    }

    /**
     * ### Appends a bucket to a brigade
     *
     * Adds the specified bucket to the end of the provided bucket brigade.
     * @since 1.0.0
     *
     * @param resource $brigade <p>
     * Bucket brigade resource to modify.
     * </p>
     * @param StreamBucket $bucket <p>
     * Stream bucket to append to the brigade.
     * </p>
     *
     * @return void
     */
    public static function append (mixed $brigade, StreamBucket $bucket):void {

        stream_bucket_append($brigade, $bucket);

    }

    /**
     * ### Prepends a bucket to a brigade
     *
     * Adds the specified bucket to the beginning of the provided bucket brigade.
     * @since 1.0.0
     *
     * @param resource $brigade <p>
     * Bucket brigade resource to modify.
     * </p>
     * @param StreamBucket $bucket <p>
     * Stream bucket to prepend to the brigade.
     * </p>
     *
     * @return void
     */
    public static function prepend (mixed $brigade, StreamBucket $bucket):void {

        stream_bucket_prepend($brigade, $bucket);

    }

}