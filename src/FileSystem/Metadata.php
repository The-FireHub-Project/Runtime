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
use FireHub\Runtime\ {
    Arr, DataIs, Number, Str
};
use FireHub\Core\Type\FileSystem\PermissionMode;
use FireHub\Core\Meta\Enum\ {
    FileSystem\Permission, Number\Base
};
use FireHub\Runtime\Exception\ {
    PathGroupException, PathInodeException, PathOwnerException, PathPermissionsException, PathSizeException,
    PathStatisticsException, PathTimestampException
};

use function chgrp;
use function chmod;
use function chown;
use function clearstatcache;
use function fileatime;
use function filectime;
use function filemtime;
use function fileinode;
use function filegroup;
use function fileowner;
use function fileperms;
use function filesize;
use function lstat;
use function stat;
use function touch;

/**
 * ### PHP Runtime File Metadata Utilities
 *
 * Provides low-level wrappers for retrieving file system metadata, including timestamps, ownership, permissions,
 * identifiers, and file information while preserving native PHP behavior.
 *
 * This component exposes PHP metadata inspection capabilities through a consistent FireHub Runtime API without
 * altering native runtime semantics.
 * @since 1.0.0
 */
final class Metadata extends NativeRuntime {

    /**
     * ### Gets file size
     * @param non-empty-string $path <p>
     * Path to the file.
     * </p>
     *
     * @return non-negative-int The size of the file in bytes.
     *
     * @note Because PHP's integer type is signed and many platforms use 32bit integers, some filesystem functions
     * may return unexpected results for files which are larger than 2GB.
     * @note The results of this function are cached.
     * See Metadata::clearCache() for more details.
     *@throws \FireHub\Runtime\Exception\PathSizeException If we couldn't get file size for a file.
     *
     * @since 1.0.0
     *
     */
    public static function size (string $path):int {

        return ($size = filesize($path)) !== false
            ? $size : throw new PathSizeException(
                'We couldn\'t get file size for a file.'
            );

    }

    /**
     * ### Gets last access time of a path
     * @param string $path <p>
     * Path to file or folder.
     * </p>
     *
     * @return non-negative-int The time the file was last accessed (the time is returned as a Unix timestamp).
     *
     * @note The atime of a file is supposed to change whenever the data blocks of a file are being read.
     * This can be costly performance-wise when an application regularly accesses a huge number of files or
     * directories.
     * Some Unix filesystems can be mounted with atime updates disabled to increase the performance of such
     * applications; USENET news spools are a common example.
     * On such filesystems this function will be useless.
     * @note Note that time resolution may differ from one file system to another.
     * @note The results of this function are cached.
     * See Metadata::clearCache() for more details.
     *@throws \FireHub\Runtime\Exception\PathTimestampException If failed get last accessed time for a path.
     *
     * @since 1.0.0
     *
     */
    public static function lastAccessed (string $path):int {

        return ($time = fileatime($path)) !== false
            ? $time : throw new PathTimestampException;

    }

    /**
     * ### Gets last modification time of a path
     *
     * Represents when the data or content is changed or modified, not including that of metadata such as ownership or
     * owner group.
     * @param string $path <p>
     * Path to file or folder.
     * </p>
     *
     *@return non-negative-int The time the file was last modified (the time is returned as a Unix timestamp).
     *
     * @note Note that time resolution may differ from one file system to another.
     * @note The results of this function are cached.
     * See Metadata::clearCache() for more details.
     *@throws \FireHub\Runtime\Exception\PathTimestampException If failed get last modified time for a path.
     *
     * @since 1.0.0
     *
     */
    public static function lastModified (string $path):int {

        return ($time = filemtime($path)) !== false
            ? $time : throw new PathTimestampException;

    }

    /**
     * ### Gets inode change time of a path
     *
     * Represents the time when the metadata or inode data of a file is altered, such as the change of permissions,
     * ownership, or group.
     * @param string $path <p>
     * Path to file or folder.
     * </p>
     *
     * @return non-negative-int The time the file was last changed (the time is returned as a Unix timestamp).
     *
     * @note In most Unix filesystems, a file is considered changed when its inode data is changed; that is, when the
     * permissions, owner, group, or other metadata from the inode is updated.
     * See also Metadata#lastModified() (which is what you want to use when you want to create "Last Modified"
     * footers on web pages) and Metadata#lastAccessed().
     * @note On Windows, this function will return creating time but on UNIX inode change time.
     * @note Note that time resolution may differ from one file system to another.
     * @note The results of this function are cached.
     * See Metadata::clearCache() for more details.
     *@throws \FireHub\Runtime\Exception\PathTimestampException If failed get last changed time for a path.
     *
     * @since 1.0.0
     *
     */
    public static function lastChanged (string $path):int {

        return ($time = filectime($path)) !== false
            ? $time : throw new PathTimestampException;

    }

    /**
     * ### Gets file inode
     *
     * Inode are special disk blocks they are created when the file system is created.
     * @param non-empty-string $path <p>
     * Path to file or folder.
     * </p>
     *
     * @return non-negative-int The inode number of the file.
     *
     * @note The results of this function are cached.
     * See Metadata::clearCache() for more details.
     *@throws \FireHub\Runtime\Exception\PathInodeException If failed to get inode for a path.
     *
     * @since 1.0.0
     *
     */
    public static function inode (string $path):int {

        return ($inode = fileinode($path)) !== false
            ? $inode : throw new PathInodeException;

    }

    /**
     * ### Sets last access and modification time of a path
     *
     * Attempts to set the access and modification times of the file named in the filename parameter to the value
     * given in mtime. Note that the access time is always modified, regardless of the number of parameters.
     * @param non-empty-string $path <p>
     * Path to file or folder.
     * </p>
     * @param null|int $last_accessed [optional] <p>
     * f not null, the access time of the given filename is set to the value of atime.
     *
     * Otherwise, it is set to the value passed to the mtime parameter.
     *
     * If both are null, the current system time is used.
     * </p>
     * @param null|int $last_modified [optional] <p>
     * The modifed time.
     *
     * If $last_modified is null, the current system time() is used.
     * </p>
     *
     * @return true True on success.
     *
     * @note If the file doesn't exist, it will be created.
     * @note Note that time resolution may differ from one file system to another.
     *@throws \FireHub\Runtime\Exception\PathTimestampException If failed to set the last access and modification
     * time of a path.
     *
     * @since 1.0.0
     *
     */
    public static function setTimestamps (string $path, ?int $last_accessed = null, ?int $last_modified = null):true {

        return touch($path, $last_modified, $last_accessed)
            ?: throw new PathTimestampException;

    }

    /**
     * ### Gets a file or folder group
     *
     * Gets the file or folder group. The group ID is returned in numerical format.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path of the file or folder.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\PathGroupException If we couldn't get a group for a file.
     *
     * @return non-negative-int The group ID of the file.
     *
     * @warning This method doesn't work on Windows.
     * @note The results of this function are cached.
     * See Metadata::clearCache() for more details.
     * @tip Use posix_getgrgid() to resolve it to a group name.
     */
    public static function getGroup (string $path):int {

        return ($group = filegroup($path)) === false
            ? throw new PathGroupException
            : $group;

    }

    /**
     * ### Changes file or folder group
     *
     * Attempts to change the group of the files or folder $path to $group.
     *
     * Only the superuser may change the group of files arbitrarily; other users may change the group of files to any
     * group of which that user is a member.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path of the file or folder.
     * </p>
     * @param non-empty-string|int $group <p>
     * A group name or number.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\PathGroupException If we couldn't set a group for file
     * or folder.
     *
     * @return true True on success.
     *
     * @warning This method doesn't work on Windows.
     * @tip Use posix_getgrgid() to resolve it to a group name.
     */
    public static function setGroup (string $path, string|int $group):true {

        return chgrp($path, $group)
            ?: throw new PathGroupException;

    }

    /**
     * ### Gets a file or folder owner
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path of the file or folder.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\PathOwnerException If we couldn't get an owner for a file or folder.
     *
     * @return non-negative-int The user ID of the owner for the file or folder.
     *
     * @warning This method doesn't work on Windows.
     * @note The results of this function are cached.
     * See Metadata::clearCache() for more details.
     * @tip Use posix_getpwuid() to resolve it to a username.
     */
    public static function getOwner (string $path):int {

        return ($owner = fileowner($path)) === false
            ? throw new PathOwnerException
            : $owner;

    }

    /**
     * ### Gets a file or folder owner
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Pth of the file or folder.
     * </p>
     * @param non-empty-string|int $user <p>
     * A username or number.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\PathOwnerException If we couldn't get an owner for a file or folder.
     *
     * @return true True on success.
     *
     * @warning This method doesn't work on Windows.
     * @note This function will not work on remote files as the file to be examined must be accessible via the
     * server's filesystem.
     * @tip Use posix_getpwuid() to resolve it to a username.
     */
    public static function setOwner (string $path, string|int $user):true {

        return chown($path, $user)
            ?: throw new PathOwnerException;

    }

    /**
     * ### Gets path permissions
     *
     * Gets permissions for the given path.
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Str\SB\Access::part() To get part of the decoct() function.
     * @uses \FireHub\Runtime\Number::baseConverter() To convert a number to a base.
     * @uses \FireHub\Core\Meta\Enum\Number\Base::DECIMAL To convert a number to a base.
     * @uses \FireHub\Core\Meta\Enum\Number\Base::OCTAL To convert a number to a base.
     *
     * @param non-empty-string $path <p>
     * The path.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\PathPermissionsException If failed to permissions for a path.
     * @throws \FireHub\Runtime\Exception\InvalidNumberBaseException If failed to convert a number to a base.
     *
     * @return \FireHub\Core\Type\FileSystem\PermissionMode Path permissions.
     *
     * @note The results of this function are cached.
     * See Metadata::clearCache() for more details.
     */
    public static function getPermissions (string $path):PermissionMode {

        $permissions = fileperms($path);

        if ($permissions === false) throw new PathPermissionsException;

        $permissions = Str\SB\Access::part(
            Number::baseConverter((string)$permissions, Base::DECIMAL, Base::OCTAL),
            -3
        );

        return new PermissionMode(
            Permission::from((int)$permissions[0]),
            Permission::from((int)$permissions[1]),
            Permission::from((int)$permissions[2])
        );

    }

    /**
     * ### Sets path permissions
     *
     * Attempts to change the mode of the specified path to that given in permissions.
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Str\SB\Transform::format() To format a string.
     * @uses \FireHub\Runtime\Number::baseConverter() To convert a number to a base.
     * @uses \FireHub\Core\Meta\Enum\Number\Base::DECIMAL To convert a number to a base.
     * @uses \FireHub\Core\Meta\Enum\Number\Base::OCTAL To convert a number to a base.
     *
     * @param non-empty-string $path <p>
     * The path.
     * </p>
     * @param \FireHub\Core\Type\FileSystem\PermissionMode $mode <p>
     * The permissions.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\PathPermissionsException If failed to set permissions for a path.
     * @throws \FireHub\Runtime\Exception\InvalidNumberBaseException If failed to convert a number to a base.
     *
     * @return True Only true.
     *
     * @note The current user is the user under which PHP runs.
     * It is probably different from the user you use for normal shell or FTP access.
     * The mode can be changed only by the user who owns the file on most systems.
     * @note This function will not work on remote files as the file to be examined must be accessible via the
     * server's filesystem.
     */
    public static function setPermissions (string $path, PermissionMode $mode):true {

        return chmod(
            $path,
            (int)Number::baseConverter(
                Str\SB\Transform::format(
                    '0%d%d%d',
                    $mode->owner->value,
                    $mode->group->value,
                    $mode->other->value
                ),
                BASE::OCTAL,
                BASE::DECIMAL
            )
        ) ?: throw new PathPermissionsException;

    }

    /**
     * ### Gives information about a file or folder
     *
     * Gathers the statistics of the file named by filename.
     *
     * If the filename is a symbolic link, statistics are from the file itself, not the symlink – use $symlink
     * argument to change that behavior.
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Arr\Transform::filter() To filter string keys in statistics.
     * @uses \FireHub\Runtime\DataIs::string() To find whether the statistics key is string or not.
     *
     * @param non-empty-string $path <p>
     * Path to the file or folder.
     * </p>
     * @param bool $symlink [optional] <p>
     * If true, the method gives information about a file or symbolic link.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\PathStatisticsException If we couldn't get statistics for a path.
     *
     * @return array{
     *   dev: int,
     *   ino: int,
     *   mode: int,
     *   nlink: int,
     *   uid: int,
     *   gid: int,
     *   rdev: int,
     *   size: int,
     *   atime: int,
     *   mtime: int,
     *   ctime: int,
     *   blksize: int,
     *   blocks: int
     * } Statistics about a file or folder.
     */
    public static function statistics (string $path, bool $symlink = false):array {

        /** @var array{
         *   dev: int,
         *   ino: int,
         *   mode: int,
         *   nlink: int,
         *   uid: int,
         *   gid: int,
         *   rdev: int,
         *   size: int,
         *   atime: int,
         *   mtime: int,
         *   ctime: int,
         *   blksize: int,
         *   blocks: int
         * }
         */
        return Arr\Transform::filter(
            ($statistics = $symlink ? lstat($path) : stat($path)) !== false
                ? $statistics
                : throw new PathStatisticsException,
            static fn(int $value, int|string $key) => DataIs::string($key)
        );

    }

    /**
     * ### Clears file status cache
     *
     * When you use FileSystem#statistics() or any of the other functions listed in the affected functions list (below),
     * PHP caches the information those functions return to provide faster performance.
     *
     * However, in certain cases, you may want to clear the cached information.
     *
     * For instance, if the same file is being checked multiple times within a single script, and that file is in
     * danger of being removed or changed during that script's operation, you may elect to clear the status cache.
     *
     * In these cases, you can use the Metadata::clearCache() function to clear the information that PHP caches
     * about a file.
     *
     * You should also note that PHP doesn't cache information about non-existent files.
     *
     * So, if you call File::exist() on a file which doesn't exist, it will return false until you create
     * the file.
     *
     * If you create the file, it will return true even if you then delete the file.
     *
     * However, File::delete() clears the cache automatically.
     * @since 1.0.0
     *
     * @param bool $clear_realpath_cache [optional] <p>
     * Whether to also clear the realpath cache.
     * </p>
     * @param string $path [optional] <p>
     * Clear the realpath cache for a specific filename only.
     *
     * Only used if $clear_realpath_cache is true.
     * </p>
     *
     * @return void
     *
     * @phpstan-impure
     *
     * @note This function caches information about specific filenames, so you only need to call Metadata::clearCache
     * () if you are performing multiple operations on the same filename and require the information about that
     * particular file to not be cached.
     */
    public static function clearCache (bool $clear_realpath_cache = false, string $path = ''):void {

        clearstatcache($clear_realpath_cache, $path);

    }

}