<?php

namespace MailMug\ZentropyLaravel\Tests;

use Zentropy;

uses(TestCase::class);

it('can ping the server', function () {
    expect(Zentropy::ping())->toBeTrue();
});

it('can set and get a key', function () {
    Zentropy::set('foo', 'bar');
    expect(Zentropy::get('foo'))->toBe('bar');
});

it('can delete a key', function () {
    Zentropy::set('temp', '123');
    Zentropy::delete('temp');
    expect(Zentropy::exists('temp'))->toBeFalse();
});
