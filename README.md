# Zentropy Laravel

[![Latest Version](https://img.shields.io/packagist/v/mailmug/zentropy-laravel.svg?style=flat-square)](https://packagist.org/packages/mailmug/zentropy-laravel)
[![License](https://img.shields.io/packagist/l/mailmug/zentropy-laravel.svg?style=flat-square)](LICENSE)

**Zentropy Laravel** is a simple and powerful **Laravel wrapper for MailMug's Zentropy PHP client** — a high-performance **Redis alternative**. Easily store, retrieve, and manage key-value data using **TCP or Unix socket connections** directly from your Laravel applications.  

---

## Features

- ✅ Full Laravel 10, 11, 12 support  
- ✅ Facade access for clean and readable syntax  
- ✅ Supports **TCP connections** with optional authentication  
- ✅ Supports **Unix socket connections** (no authentication required)  
- ✅ Common key-value operations: `set`, `get`, `delete`, `exists`, `ping`  
- ✅ Easily configurable via published `zentropy.php` config  
- ✅ Lightweight and high-performance alternative to Redis  

---

## Installation

Install via Composer:

```bash
composer require mailmug/zentropy-laravel
```

## Publish Config and Service Provider
To publish the configuration file:
```bash
php artisan vendor:publish --provider="MailMug\ZentropyLaravel\ZentropyWrapperServiceProvider" --tag="config"
```

This will create config/zentropy.php where you can configure host, port, password, and Unix socket.

## Add to .env
```env
ZENTROPY_HOST=127.0.0.1
ZENTROPY_PORT=6383
ZENTROPY_PASSWORD=null
ZENTROPY_UNIX_SOCKET=null
```

* ZENTROPY_HOST – the host of your Zentropy server (default 127.0.0.1)

* ZENTROPY_PORT – TCP port of your server (default 6383)

* ZENTROPY_PASSWORD – optional password for TCP

* ZENTROPY_UNIX_SOCKET – optional Unix socket path


## Usage

```php
use MailMug\ZentropyLaravel\Facades\Zentropy;

// Set a value
Zentropy::set('foo', 'bar');

// Get a value
$value = Zentropy::get('foo');

// Check if a key exists
$exists = Zentropy::exists('foo');

// Delete a key
Zentropy::delete('foo');

// Ping the server
$ping = Zentropy::ping();
```

## License

This project is licensed under the MIT License.