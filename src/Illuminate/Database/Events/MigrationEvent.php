<?php

namespace Illuminate\Database\Events;

use Illuminate\Contracts\Database\Events\MigrationEvent as MigrationEventContract;
use Illuminate\Database\Migrations\Migration;

abstract class MigrationEvent implements MigrationEventContract
{
    /**
     * An migration instance.
     *
     * @var \Illuminate\Database\Migrations\Migration
     */
    public $migration;

    /**
     * The migration method that was called.
     *
     * @var string
     */
    public $method;

    /**
     * Create a migration event instance.
     *
     * @param \Illuminate\Database\Migrations\Migration $migration
     * @param string $method
     * @return void
     */
    public function __construct(Migration $migration, $method)
    {
        $this->migration = $migration;
        $this->method = $method;
    }
}
