<?php

namespace MailMug\ZentropyLaravel;

use Zentropy\Client;
use Closure;

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

    public function setEx(string $key, string $value, int $seconds): bool
    {
        return $this->client->setEx($key, $value, $seconds);
    }

    public function setPx(string $key, string $value, int $milliSeconds): bool
    {
        return $this->client->setPx($key, $value, $milliSeconds);
    }

    /**
     * Get an item from the cache, or execute the given Closure and store the result.
     *
     * @param string $key
     * @param int $seconds
     * @param Closure $callback
     * @return mixed
     */
    public function remember(string $key, int $seconds, Closure $callback)
    {
        // Try to get the value from cache
        $value = $this->get($key);
        
        if (!is_null($value)) {
            return $this->unserialize($value);
        }
        
        // Execute the callback if value doesn't exist
        $value = $callback();
        
        // Store the value in cache
        $this->setEx($key, $this->serialize($value), $seconds);
        
        return $value;
    }

    /**
     * Get an item from the cache, or execute the given Closure and store the result forever.
     *
     * @param string $key
     * @param Closure $callback
     * @return mixed
     */
    public function rememberForever(string $key, Closure $callback)
    {
        // Try to get the value from cache
        $value = $this->get($key);
        
        if (!is_null($value)) {
            return $this->unserialize($value);
        }
        
        // Execute the callback if value doesn't exist
        $value = $callback();
        
        // Store the value in cache forever
        $this->set($key, $this->serialize($value));
        
        return $value;
    }

    /**
     * Get an item from the cache, or execute the given Closure and store the result for milliseconds.
     *
     * @param string $key
     * @param int $milliseconds
     * @param Closure $callback
     * @return mixed
     */
    public function rememberPx(string $key, int $milliseconds, Closure $callback)
    {
        // Try to get the value from cache
        $value = $this->get($key);
        
        if (!is_null($value)) {
            return $this->unserialize($value);
        }
        
        // Execute the callback if value doesn't exist
        $value = $callback();
        
        // Store the value in cache with millisecond precision
        $this->setPx($key, $this->serialize($value), $milliseconds);
        
        return $value;
    }

    public function get(string $key): ?string
    {
        return $this->client->get($key);
    }

    /**
     * Get the value and unserialize it
     *
     * @param string $key
     * @return mixed
     */
    public function pull(string $key)
    {
        $value = $this->get($key);
        
        if (!is_null($value)) {
            $this->delete($key);
            return $this->unserialize($value);
        }
        
        return null;
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

    /**
     * Serialize the value for storage
     *
     * @param mixed $value
     * @return string
     */
    protected function serialize($value): string
    {
        return serialize($value);
    }

    /**
     * Unserialize the stored value
     *
     * @param string $value
     * @return mixed
     */
    protected function unserialize(string $value)
    {
        return unserialize($value);
    }

    /**
     * Clear the entire cache (use with caution)
     *
     * @return bool
     */
    public function flush(): bool
    {
        // Note: This is a simple implementation. In production, you might want
        // to implement a more sophisticated flushing mechanism
        return $this->client->flushdb();
    }

    /**
     * Increment the value of an item in the cache.
     *
     * @param string $key
     * @param int $value
     * @return int|bool
     */
    public function increment(string $key, int $value = 1)
    {
        $current = $this->get($key);
        
        if (is_null($current)) {
            $this->set($key, $this->serialize($value));
            return $value;
        }
        
        $current = $this->unserialize($current);
        
        if (is_int($current)) {
            $newValue = $current + $value;
            $this->set($key, $this->serialize($newValue));
            return $newValue;
        }
        
        return false;
    }

    /**
     * Decrement the value of an item in the cache.
     *
     * @param string $key
     * @param int $value
     * @return int|bool
     */
    public function decrement(string $key, int $value = 1)
    {
        return $this->increment($key, $value * -1);
    }
}