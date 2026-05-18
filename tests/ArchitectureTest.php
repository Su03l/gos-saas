<?php

declare(strict_types=1);

namespace Tests;

test('controllers should have Controller suffix')
    ->expect('App\Http\Controllers')
    ->toHaveSuffix('Controller');

test('models should extend Eloquent Model')
    ->expect('App\Models')
    ->toExtend('Illuminate\Database\Eloquent\Model');

test('services should have Service suffix')
    ->expect('App\Services')
    ->toHaveSuffix('Service');

test('contracts should be interfaces')
    ->expect('App\Contracts')
    ->toBeInterfaces();

test('commands should have Command suffix')
    ->expect('App\Console\Commands')
    ->toHaveSuffix('Command');

test('events should be in App\Events namespace')
    ->expect('App\Events')
    ->toBeClasses();

test('listeners should have Listener suffix')
    ->expect('App\Listeners')
    ->toHaveSuffix('Listener');

test('jobs should implement ShouldQueue')
    ->expect('App\Jobs')
    ->toImplement('Illuminate\Contracts\Queue\ShouldQueue');
