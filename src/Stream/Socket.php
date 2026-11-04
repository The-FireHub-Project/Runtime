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
use FireHub\Runtime\Stream\Enum\{
    ClientFlag, CryptoClientMethod, CryptoServerMethod, ReceiveFlag, SendFlag, ServerFlag, ShutdownMode, SocketDomain,
    SocketProtocol, SocketType
};

use function stream_socket_client;
use function stream_socket_server;
use function stream_socket_accept;
use function stream_socket_enable_crypto;
use function stream_socket_get_name;
use function stream_socket_pair;
use function stream_socket_recvfrom;
use function stream_socket_sendto;
use function stream_socket_shutdown;

/**
 * ### PHP Runtime Stream Socket Utilities
 *
 * Provides low-level wrappers for creating, connecting, accepting, configuring, and communicating through PHP stream
 * sockets.
 *
 * Supports native PHP socket transports, including TCP, UDP, Unix domain sockets, and encrypted transports.
 *
 * This component preserves native PHP stream socket behavior.
 * @since 1.0.0
 */
final readonly class Socket extends NativeRuntime {

    /**
     * ### Opens a client socket connection
     *
     * Opens a stream socket connection to the specified remote address.
     * @since 1.0.0
     *
     * @param string $address <p>
     * Remote socket address, including the transport protocol.
     * </p>
     * @param null|int &$error_code [optional] <p>
     * Receives the system-level error code if the connection fails.
     * </p>
     * @param null|string &$error_message [optional] <p>
     * Receives the error message if the connection fails.
     * </p>
     * @param null|float &$timeout [optional] <p>
     * Connection timeout in seconds. Null uses the default socket timeout.
     * </p>
     * @param \FireHub\Runtime\Stream\Enum\ClientFlag $flag [optional] <p>
     * Connection mode and persistence flags.
     * </p>
     * @param null|resource $context [optional] <p>
     * Optional stream context containing transport-specific options.
     * </p>
     *
     * @return resource|false Connected socket resource on success, false on failure.
     */
    public static function client (string $address, ?int &$error_code = null, ?string &$error_message = null, ?float $timeout = null, ClientFlag $flag = ClientFlag::CONNECT, mixed $context = null):mixed {

        return stream_socket_client(
            $address,
            $error_code,
            $error_message,
            $timeout,
            $flag->value,
            $context
        );

    }

    /**
     * ### Creates a server socket
     *
     * Creates a stream socket server bound to the specified local address.
     * @since 1.0.0
     *
     * @param string $address <p>
     * Local socket address, including the transport protocol.
     * </p>
     * @param null|int &$error_code [optional] <p>
     * Receives the system-level error code if the server cannot be created.
     * </p>
     * @param null|string &$error_message [optional] <p>
     * Receives the error message if the server cannot be created.
     * </p>
     * @param \FireHub\Runtime\Stream\Enum\ServerFlag $flag [optional] <p>
     * Binding and listening flags.
     * </p>
     * @param null|resource $context [optional] <p>
     * Optional stream context containing server-specific options.
     * </p>
     *
     * @return resource|false Server socket resource on success, false on failure.
     */
    public static function server (string $address, ?int &$error_code = null, ?string &$error_message = null, ServerFlag $flag = ServerFlag::BIND_LISTEN, mixed $context = null):mixed {

        return stream_socket_server(
            $address,
            $error_code,
            $error_message,
            $flag->value,
            $context
        );

    }

    /**
     * ### Accepts a connection on a server socket
     *
     * Accepts an incoming connection on an existing listening server socket.
     * @since 1.0.0
     *
     * @param resource $server_socket <p>
     * Listening server socket resource.
     * </p>
     * @param null|float $timeout [optional] <p>
     * Maximum time to wait for an incoming connection, in seconds.
     * Null uses the default socket timeout.
     * </p>
     * @param null|string &$peer_name [optional] <p>
     * Receives the remote peer address when a connection is accepted.
     * </p>
     * @param-out mixed $peer_name
     *
     * @return resource|false Accepted connection resource on success, false on failure.
     */
    public static function accept (mixed $server_socket, ?float $timeout = null, ?string &$peer_name = null):mixed {

        return stream_socket_accept($server_socket, $timeout, $peer_name);

    }

    /**
     * ### Enables or disables encryption on a socket
     *
     * Enables or disables encryption on an existing stream socket.
     *
     * For non-blocking streams, the operation may return zero when additional data is required to complete the
     * encryption handshake.
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream socket resource.
     * </p>
     * @param bool $enable <p>
     * Whether to enable or disable encryption.
     * </p>
     * @param null|\FireHub\Runtime\Stream\Enum\CryptoClientMethod|\FireHub\Runtime\Stream\Enum\CryptoServerMethod $crypto_method  [optional]<p>
     * Cryptographic method for the client or server.
     * </p>
     * @param null|resource $session_stream [optional] <p>
     * Optional stream resource used to reuse an existing encryption session.
     * </p>
     *
     * @return bool|int True on success, false on failure, or zero when additional data is required to complete the
     * handshake.
     */
    public static function enableCrypto (mixed $stream, bool $enable, CryptoClientMethod|CryptoServerMethod|null $crypto_method = null, mixed $session_stream = null):bool|int {

        return stream_socket_enable_crypto($stream, $enable, $crypto_method?->value, $session_stream);

    }

    /**
     * ### Gets the local or remote socket name
     *
     * Retrieves the local or remote address associated with a stream socket.
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream socket resource.
     * </p>
     * @param bool $remote <p>
     * Whether to retrieve the remote address. False retrieves the local address.
     * </p>
     *
     * @return string|false Socket address on success, false on failure.
     */
    public static function getName (mixed $stream, bool $remote):string|false {

        return stream_socket_get_name($stream, $remote);

    }

    /**
     * ### Creates a pair of connected sockets
     *
     * Creates two connected stream sockets using the specified domain, socket type, and protocol.
     * @since 1.0.0
     *
     * @param \FireHub\Runtime\Stream\Enum\SocketDomain $domain <p>
     * Socket protocol family.
     * </p>
     * @param \FireHub\Runtime\Stream\Enum\SocketType $type <p>
     * Socket communication type.
     * </p>
     * @param \FireHub\Runtime\Stream\Enum\SocketProtocol $protocol <p>
     * Socket transport protocol.
     * </p>
     *
     * @return array<resource>|false Pair of connected socket resources on success, false on failure.
     */
    public static function pair (SocketDomain $domain, SocketType $type, SocketProtocol $protocol):array|false {

        return stream_socket_pair($domain->value, $type->value, $protocol->value);

    }

    /**
     * ### Receives data from a socket
     *
     * Receives data from a connected or unconnected stream socket.
     * @since 1.0.0
     *
     * @param resource $socket <p>
     * Stream socket resource.
     * </p>
     * @param int<1, max> $length <p>
     * Maximum number of bytes to receive.
     * </p>
     * @param \FireHub\Runtime\Stream\Enum\ReceiveFlag $flag [optional] <p>
     * Receive behavior flags.
     * </p>
     * @param null|string $address [optional]<p>
     * Receives the address of the sender when available.
     * </p>
     * @param-out mixed $address
     *
     * @return string|false Received data on success, false on failure.
     */
    public static function receive (mixed $socket, int $length, ReceiveFlag $flag = ReceiveFlag::NONE, ?string &$address = null):string|false {

        return stream_socket_recvfrom($socket, $length, $flag->value, $address);

    }

    /**
     * ### Sends data through a socket
     *
     * Sends data through a connected stream socket or to a specified destination address.
     * @since 1.0.0
     *
     * @param resource $socket <p>
     * Stream socket resource.
     * </p>
     * @param string $data <p>
     * Data to send through the socket.
     * </p>
     * @param \FireHub\Runtime\Stream\Enum\SendFlag $flag [optional] <p>
     * Send behavior flags.
     * </p>
     * @param string $address [optional] <p>
     * Destination address. An empty string uses the connected peer.
     * </p>
     *
     * @return int|false Number of bytes sent on success, false on failure.
     */
    public static function send (mixed $socket, string $data, SendFlag $flag = SendFlag::NONE, string $address = ''):int|false {

        return stream_socket_sendto($socket, $data, $flag->value, $address);

    }

    /**
     * ### Shuts down a socket connection
     *
     * Shuts down the reading direction, writing direction, or both directions of an existing socket connection.
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream socket resource.
     * </p>
     * @param \FireHub\Runtime\Stream\Enum\ShutdownMode $mode <p>
     * Direction of shutdown.
     * </p>
     *
     * @return bool True on success, false on failure.
     */
    public static function shutdown (mixed $stream, ShutdownMode $mode):bool {

        return stream_socket_shutdown($stream, $mode->value);

    }

}