<?php

namespace MailMug\ZentropyLaravel;

use Zentropy\Client;

class ZentropyWrapper
{
    protected Client $client;

    public function __construct()
    {
        $unixSocket = config('zentropy.unix_socket');
        if ($unixSocket) {
            $this->client = Client::unixSocket($unixSocket);
        } else {
            $this->client = Client::tcp(
                config('zentropy.host'),
                config('zentropy.port'),
                config('zentropy.password')
            );
        }
    }

    public function set(string $key, string $value): bool
    {
        return $this->client->set($key, $value);
    }

    public function get(string $key): ?string
    {
        return $this->client->get($key);
    }

    public function delete(string $key): bool
    {
        return $this->client->delete($key);
    }

    public function exists(string $key): bool
    {
        return $this->client->exists($key);
    }

    public function ping(): bool
    {
        return $this->client->ping();
    }
}
