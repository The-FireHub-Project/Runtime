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
use FireHub\Core\Type\FileSystem\PermissionMode;
use FireHub\Core\Meta\Enum\ {
    Order, FileSystem\PathSearchFlag
};
use FireHub\Runtime\Exception\ {
    CannotListFolderException, CreateFolderException, DeleteFolderException, MatchInFolderException
};

use const GLOB_ERR;
use const GLOB_MARK;
use const GLOB_NOSORT;
use const GLOB_ONLYDIR;
use const SCANDIR_SORT_ASCENDING;
use const SCANDIR_SORT_DESCENDING;
use const SCANDIR_SORT_NONE;

use function glob;
use function is_dir;
use function mkdir;
use function rmdir;
use function scandir;

/**
 * ### PHP Runtime Folder Utilities
 *
 * Provides low-level wrappers for managing file system folders, including creation, removal, scanning, and
 * directory inspection while preserving native PHP behavior.
 *
 * This component exposes PHP directory management capabilities through a consistent FireHub Runtime API without
 * altering native runtime semantics.
 * @since 1.0.0
 */
final class Folder extends NativeRuntime {

    /**
     * ### Tells whether the filename is a regular folder
     * @since 1.0.0
     *
     * @param string $path <p>
     * Path to the folder.
     *
     * If the filename is a relative filename, it will be checked relative to the current working folder.
     *
     * If the filename is a symbolic or hard link, then the link will be resolved and checked.
     *
     * If you've enabled open_basedir, further restrictions may apply.
     * </p>
     *
     * @return bool True if the filename exists and is a regular folder, false otherwise.
     *
     * @note The results of this function are cached.
     * See Metadata::clearCache() for more details.
     */
    public static function exists (string $path):bool {

        return is_dir($path);

    }

    /**
     * ### Makes folder
     *
     * Attempts to create the folder specified by $path.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Type\FileSystem\PermissionMode::decimal() To get decimal value of a permission mode.
     *
     * @param non-empty-string $path <p>
     * Path to folder ot disk partition.
     * </p>
     * @param \FireHub\Core\Type\FileSystem\PermissionMode $mode <p>
     * The permissions.
     * </p>
     * @param bool $recursive [optional] <p>
     * If true, then any parent folders to the $path specified will also be created, with the same permissions.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\CreateFolderException If we couldn't create a folder.
     *
     * @return true True on success.
     */
    public static function create (string $path, PermissionMode $mode, bool $recursive = false):true {

        return mkdir($path, $mode->decimal(), $recursive)
            ?: throw new CreateFolderException;

    }

    /**
     * ### Deletes folder
     *
     * Attempts to remove the folder named by $path.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to folder.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\DeleteFolderException If we couldn't delete the folder.
     *
     * @return true True on success.
     */
    public static function delete (string $path):true {

        return rmdir($path)
            ?: throw new DeleteFolderException;

    }

    /**
     * ### Find path-names matching a pattern
     *
     * This method searches for all the path-names matching patterns according to the rules used by the libc glob()
     * function, which is similar to the rules used by common shells.
     * @since 1.0.0
     *
     * @param string $pattern <p>
     * The pattern.
     *
     * No tilde expansion or parameter substitution is done.
     * - * – Matches zero or more characters.
     * - ? – Matches exactly one character (any character).
     * - [...] – Matches one character from a group of characters. If the first character is !, matches any character
     * not in the group.
     * - \ – Escapes the following character.
     * </p>
     * @param \FireHub\Core\Meta\Enum\FileSystem\PathSearchFlag ...$flags <p>
     * The flags.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\MatchInFolderException If there was an error while searching for a path.
     *
     * @return list<string> An array containing the matched files/folders, an empty array if no file matched.
     *
     * @note This function will not work on remote files as the file to be examined must be accessible via the
     * server's filesystem.
     * @note This function isn't available on some systems (for example, old Sun OS).
     */
    public static function match (string $pattern, PathSearchFlag ...$flags):array {

        $options = 0;

        foreach ($flags as $flag) {
            $options |= match ($flag) {
                PathSearchFlag::ERROR => GLOB_ERR,
                PathSearchFlag::MARK => GLOB_MARK,
                PathSearchFlag::NO_SORT => GLOB_NOSORT,
                PathSearchFlag::ONLY_DIRECTORY => GLOB_ONLYDIR,
            };
        }

        return ($glob = glob($pattern, $options)) !== false
            ? $glob : throw new MatchInFolderException;

    }

    /**
     * ### List files and folders inside the specified folder
     * @since 1.0.0
     *
     * @param non-empty-string $folder <p>
     * The folder that will be scanned.
     * </p>
     * @param null|\FireHub\Core\Meta\Enum\Order $order [optional] <p>
     * Result order.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\CannotListFolderException If $folder is empty, or we couldn't list files
     * and directories inside the specified folder.
     *
     * @return list<string> An array of filenames.
     */
    public static function list (string $folder, ?Order $order = null):array {

        $result = scandir(
            $folder,
            match ($order) {
                Order::ASC => SCANDIR_SORT_ASCENDING,
                Order::DESC => SCANDIR_SORT_DESCENDING,
                null => SCANDIR_SORT_NONE,
            }
        );

        return $result !== false
            ? $result
            : throw new CannotListFolderException;

    }

}