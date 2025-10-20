<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Connection Settings
    |--------------------------------------------------------------------------
    |
    | Define how the wrapper connects to the Zentropy server. You can use
    | either a TCP host/port with optional password, or a Unix socket path.
    |
    */
    'host' => env('ZENTROPY_HOST', '127.0.0.1'),
    'port' => env('ZENTROPY_PORT', 6383),
    'password' => env('ZENTROPY_PASSWORD', null),
    'unix_socket' => env('ZENTROPY_UNIX_SOCKET', null),
];
