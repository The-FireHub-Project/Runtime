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
    CopyFileException, DeleteFileException, EmptyPathException, FileNotFoundException, FileReadException,
    FileTimestampException, FileWriteException, ReadFileException, RenameFileException, UploadedFileMoveException
};

use const FILE_APPEND;
use const FILE_IGNORE_NEW_LINES;
use const FILE_SKIP_EMPTY_LINES;
use const LOCK_EX;

use function copy;
use function file;
use function file_exists;
use function file_get_contents;
use function file_put_contents;
use function is_file;
use function is_uploaded_file;
use function move_uploaded_file;
use function readfile;
use function rename;
use function touch;
use function unlink;

/**
 * ### PHP Runtime File Utilities
 *
 * Provides low-level wrappers for creating, reading, writing, copying, moving, and removing files while preserving
 * native PHP file system behavior.
 *
 * This component exposes PHP file manipulation capabilities through a consistent FireHub Runtime API without
 * altering native runtime semantics.
 * @since 1.0.0
 */
final class File extends NativeRuntime {

    /**
     * ### Checks whether a file or folder exists
     * @since 1.0.0
     *
     * @param string $path <p>
     * Path to the file or folder.
     * </p>
     *
     * @return bool True if the file or directory specified by filename exists, false otherwise.
     *
     * @note Because PHP's integer type is signed and many platforms use 32bit integers, some filesystem functions
     * may return unexpected results for files which are larger than 2GB.
     * @note The results of this function are cached.
     * See Metadata::clearCache() for more details.
     * @tip On Windows, use //computer_name/share/filename or \\computer_name\share\filename to check files on network
     * shares.
     */
    public static function exist (string $path):bool {

        return file_exists($path);

    }

    /**
     * ### Tells whether the path is a regular file
     * @since 1.0.0
     *
     * @param string $path <p>
     * Path to the file.
     * </p>
     *
     * @return bool True if the filename exists and is a regular file, false otherwise.
     *
     * @note Because PHP's integer type is signed and many platforms use 32bit integers, some filesystem functions
     * may return unexpected results for files which are larger than 2GB.
     * @note The results of this function are cached.
     * See Metadata::clearCache() for more details.
     */
    public static function isFile (string $path):bool {

        return is_file($path);

    }

    /**
     * ### Tells whether the file was uploaded via HTTP POST
     *
     * Returns true if the file named by filename was uploaded via HTTP POST.
     *
     * This is useful to help ensure that a malicious user hasn't tried to trick the script into working on files
     * upon which it shouldn't be working.
     *
     * This sort of check is especially important if there is any chance that anything done with uploaded files could
     * reveal their contents to the user, or even to other users on the same system.
     *
     * For proper working, the function File#isUploaded() needs an argument like $_FILES['userfile']['tmp_name'],
     * – the name of the uploaded file on the client's machine $_FILES['userfile']['name'] doesn't work.
     * @since 1.0.0
     *
     * @param string $path <p>
     * Path to the file.
     * </p>
     *
     * @return bool True on success or false on failure.
     */
    public static function isUploaded (string $path):bool {

        return is_uploaded_file($path);

    }

    /**
     * ### Copies file
     *
     * Makes a copy of the file $path to $to.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the file.
     * </p>
     * @param non-empty-string $to <p>
     * The destination path.
     *
     * If dest is a URL, the copy operation may fail if the wrapper doesn't support overwriting of existing files.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\CopyFileException If failed to copy a file.
     *
     * @return true True on success.
     *
     * @warning If the destination file already exists, it will be overwritten.
     */
    public static function copy (string $path, string $to):true {

        return copy($path, $to)
            ?: throw new CopyFileException;

    }

    /**
     * ### Renames a file or directory
     *
     * Attempts to rename $path to $to, moving it between directories if necessary.
     *
     * If renaming a file and $to exists, it will be overwritten.
     *
     * If renaming a directory and $to exists, this function will emit a warning.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * The old name path.
     * </p>
     * @param non-empty-string $to <p>
     * The new name.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\RenameFileException If failed to rename a file.
     *
     * @return true True on success.
     *
     * @note On Windows, if $new_name already exists, it must be writable, otherwise File::rename() fails and issues
     * E_WARNING.
     */
    public static function rename (string $path, string $to):true {

        return rename($path, $to)
            ?: throw new RenameFileException;

    }

    /**
     * ### Deletes a file
     *
     * Attempts to remove the folder named by $path.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the file.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\DeleteFileException If we couldn't delete the file.
     *
     * @return true True on success.
     */
    public static function delete (string $path):true {

        return unlink($path)
            ?: throw new DeleteFileException;

    }

    /**
     * ### Moves an uploaded file to a new location
     *
     * This function checks to ensure that the file designated by $from is a valid upload file (meaning that it was
     * uploaded via PHP's HTTP POST upload mechanism).
     *
     * If the file is valid, it will be moved to the filename given by $to.
     * @since 1.0.0
     *
     * @param non-empty-string $from <p>
     * Filename of the uploaded file.
     * </p>
     * @param non-empty-string $to <p>
     * Destination of the moved file.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\UploadedFileMoveException If we couldn't move the uploaded file.
     *
     * @return true True on success.
     *
     * @warning If the destination file already exists, it will be overwritten.
     * @note File::moveUploaded() is open_basedir aware.
     * However, restrictions are placed only on the path as to allow moving of uploaded files in which from may
     * conflict with such restrictions.
     * File::moveUploaded() ensures the safety of this operation by allowing only those files uploaded through PHP
     * to be moved.
     */
    public static function moveUploaded (string $from, string $to):true {

        return move_uploaded_file($from, $to)
            ?: throw new UploadedFileMoveException;

    }

    /**
     * ### Outputs a file
     *
     * Reads a file and writes it to the output buffer.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * The filename path being read.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\ReadFileException If we couldn't put a read file on a path, or a path is
     * empty.
     * @throws \FireHub\Runtime\Exception\EmptyPathException If the path is empty.
     *
     * @return non-negative-int The number of bytes read from the file.
     *
     * @note File::read() will not present any memory issues, even when sending large files, on its own.
     * If you encounter an out-of-memory error, ensures that output buffering is off with ob_get_level().
     */
    public static function read (string $path):int {

        if ($path === '') throw new EmptyPathException;

        return ($bytes = readfile($path)) !== false
            ? $bytes
            : throw new ReadFileException;

    }

    /**
     * ### Reads the entire file into a string
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path of the file to read.
     * </p>
     * @param int $offset [optional] <p>
     * The offset where the reading starts on the original stream.
     *
     * Negative offsets count from the end of the stream.
     *
     * Seeking ($offset) is not supported with remote files.
     *
     * Attempting to seek on non-local files may work with small offsets, but this is unpredictable because it works
     * on the buffered stream.
     * </p>
     * @param null|non-negative-int $length [optional] <p>
     * Maximum length of data read. The default is to read until the end of the file is reached.
     *
     * Note that this parameter is applied to the stream processed by the filters.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\FileReadException If we can't get content from a path.
     *
     * @return string The read data.
     *
     * @note If you're opening a URI with special characters, such as spaces, you need to encode the URI with
     * urlencode().
     */
    public static function getContent (string $path, int $offset = 0, ?int $length = null):string {

        return ($content = file_get_contents($path, false, null, $offset, $length)) !== false
            ? $content : throw new FileReadException;

    }

    /**
     * ### Reads the entire file into an array
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the file.
     * </p>
     * @param bool $skip_empty_lines [optional] <p>
     * Skip empty lines.
     * </p>
     * @param bool $ignore_new_lines [optional] <p>
     * Omit a newline at the end of each array element.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\FileReadException If we can't get content from a path.
     *
     * @return list<string> The file contents as an array of lines.
     *
     * @warning When using SSL, Microsoft IIS will violate the protocol by closing the connection without sending a
     * close_notify indicator.
     * PHP will report this as "SSL: Fatal Protocol Error" when you reach the end of the data.
     * To work around this, the value of error_reporting should be lowered to a level that doesn't include warnings.
     * PHP can detect buggy IIS server software when you open the stream using the https:// wrapper and will suppress
     * the warning.
     * When using fsockopen() to create a ssl:// socket, the developer is responsible for detecting and suppressing
     * this warning.
     * @note Each line in the resulting array will include the line ending, unless $ignore_new_lines is used.
     * @tip If PHP doesn't properly recognize the line endings when reading files either on or created by a
     * Macintosh computer enabling the auto_detect_line_endings runtime configuration option may help resolve the
     * problem.
     * @tip A URL can be used as a $path.
     */
    public static function getContentArray (string $path, bool $skip_empty_lines = false, bool $ignore_new_lines = false):array {

        return ($content = file($path, match (true) {
            $skip_empty_lines && $ignore_new_lines => FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES,
            $skip_empty_lines => FILE_SKIP_EMPTY_LINES,
            $ignore_new_lines => FILE_IGNORE_NEW_LINES,
            default => 0
        })) !== false
            ? $content : throw new FileReadException;

    }

    /**
     * ### Write data to a file
     * @since 1.0.0
     *
     * @uses self::isFile() To tell whether the $file is a regular file.
     *
     * @param non-empty-string $path <p>
     * Path to the file where to write the data.
     * </p>
     * @param string|string[] $data <p>
     * The data to write.
     * </p>
     * @param bool $append [optional] <p>
     * Append the data to the file instead of overwriting it.
     * </p>
     * @param bool $lock [optional] <p>
     * Acquire an exclusive lock on the file while proceeding to the writing.
     * </p>
     * @param bool $create_file [optional] <p>
     * Is true, the method will create a new file if one doesn't exist.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\FileNotFoundException If $path is not file.
     * @throws \FireHub\Runtime\Exception\FileWriteException If the $create_file option is off or couldn't put
     * content on a path.
     *
     * @return non-negative-int The number of bytes that were written to the file.
     */
    public static function putContent (string $path, array|string $data, bool $append = false, bool $lock = true, bool $create_file = true):int {

        if (!$create_file && !self::isFile($path)) throw new FileNotFoundException(
            context: [
                'path' => $path,
                'create_file' => $create_file,
                'file_exists' => self::isFile($path),
            ]
        );

        return file_put_contents($path, $data, match (true) {
            $append && $lock => FILE_APPEND | LOCK_EX,
            $append => FILE_APPEND,
            $lock => LOCK_EX,
            default => 0
        }) ?: throw new FileWriteException;

    }

    /**
     * ### Sets last access and modification time of a path
     *
     * Attempts to set the access and modification times of the file named in the filename parameter to the value
     * given in mtime. Note that the access time is always modified, regardless of the number of parameters.
     * @since 1.0.0
     *
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
     * @throws \FireHub\Runtime\Exception\FileTimestampException If failed to set the last access and modification
     * time of a path.
     *
     * @return true True on success.
     *
     * @note If the file doesn't exist, it will be created.
     * @note Note that time resolution may differ from one file system to another.
     */
    public static function setTimestamps (string $path, ?int $last_accessed = null, ?int $last_modified = null):true {

        return touch($path, $last_modified, $last_accessed)
            ?: throw new FileTimestampException;

    }

}