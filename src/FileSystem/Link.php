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

namespace FireHub\Runtime\FileSystem;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Runtime\Exception\ {
    ChangeSymlinkGroupException, ChangeSymlinkOwnerException, CreateLinkException, CreateSymbolicException,
    GetSymbolicException, LinkInfoException
};

use function is_link;
use function lchgrp;
use function lchown;
use function link;
use function linkinfo;
use function readlink;
use function symlink;

/**
 * ### PHP Runtime File Link Utilities
 *
 * Provides low-level wrappers for creating, reading, resolving, and inspecting file system links, including
 * symbolic and hard links while preserving native PHP behavior.
 *
 * This component exposes PHP link management capabilities through a consistent FireHub Runtime API without
 * altering native runtime semantics.
 * @since 1.0.0
 */
final class Link extends NativeRuntime {

    /**
     * ### Tells whether the path is a symbolic link
     * @since 1.0.0
     *
     * @param string $link <p>
     * Path to the link.
     * </p>
     *
     * @return bool True if the filename exists and is a symbolic link, false otherwise.
     *
     * @note The results of this function are cached.<br>
     * See Metadata::clearCache() for more details.
     */
    public static function symbolicExists (string $link):bool {

        return is_link($link);

    }

    /**
     * ### Create a hard link
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the file.
     * </p>
     * @param non-empty-string $link <p>
     * The link name.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\CreateLinkException If we couldn't create a hard link
     * for a path.
     *
     * @return true True on success.
     *
     * @note This function will not work on remote files as the file to be examined must be accessible via
     * the server's filesystem.
     * @note For Windows only: This function requires PHP to run in an elevated mode or with the UAC disabled.
     */
    public static function hard (string $path, string $link):true {

        return link($path, $link)
            ?: throw new CreateLinkException;

    }

    /**
     * ### Creates a symbolic link
     *
     * Creates a symbolic link to the existing $path with the specified name $link.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the symlink.
     * </p>
     * @param non-empty-string $link <p>
     * The link name.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\CreateSymbolicException If we couldn't create symlink for a path with a link.
     *
     * @return true True on success.
     */
    public static function symbolic (string $path, string $link):true {

        return symlink($path, $link)
            ?: throw new CreateSymbolicException();

    }

    /**
     * ### Returns the target of a symbolic link
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the symlink.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\GetSymbolicException If we couldn't symlink target for a path.
     *
     * @return string The contents of the symbolic link path.
     */
    public function getSymbolic (string $path):string {

        return readlink($path)
            ?: throw new GetSymbolicException;

    }

    /**
     * ### Gets information about a link (hard or symbolic)
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the link.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\LinkInfoException If we couldn't get information about a link.'
     *
     * @return int<min, -1>|int<1, max> Non-negative integer on success, -1 in case the link was not found.
     */
    public static function info (string $path):int {

        return linkinfo($path)
            ?: throw new LinkInfoException;

    }

    /**
     * ### Changes group ownership of symlink
     *
     * Attempts to change the group of the symlink filenames to group.
     *
     * Only the superuser may change the group of symlinks arbitrarily.
     *
     * Other users may change the group of symlinks to any group of which that user is a member.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the symlink.
     * </p>
     * @param non-empty-string|int $group <p>
     * The group is specified by name or number.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\ChangeSymlinkGroupException If we couldn't change a symlink group.
     *
     * @return true True on success.
     *
     * @note This function will not work on remote files as the file to be examined must be accessible via the
     * server's filesystem.
     * @note This function is not implemented on Windows platforms.
     * @tip Use posix_getgrgid() to resolve it to a group name.
     */
    public static function symlinkGroup (string $path, string|int $group):true {

        return lchgrp($path, $group)
            ?: throw new ChangeSymlinkGroupException;

    }

    /**
     * ### Changes user ownership of symlink
     *
     * Attempts to change the owner of the symlink $path to user $user.
     *
     * Only the superuser may change the owner of a symlink.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the symlink.
     * </p>
     * @param non-empty-string|int $user <p>
     * Username or number.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\ChangeSymlinkOwnerException If we couldn't change symlink ownership.
     *
     * @return true True on success.
     *
     * @note This function will not work on remote files as the file to be examined must be accessible via the
     * server's filesystem.
     * @note This function is not implemented on Windows platforms.
     * @tip Use posix_getpwuid() to resolve it to a username.
     */
    public static function symlinkOwner (string $path, string|int $user):true {

        return lchown($path, $user)
            ?: throw new ChangeSymlinkOwnerException;

    }

}