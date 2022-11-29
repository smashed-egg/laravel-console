<?php

namespace SmashedEgg\LaravelConsoleEnhancements\Tests;

use Illuminate\Support\ServiceProvider;
use SmashedEgg\LaravelConsoleEnhancements\Tests\Command\InteractiveCommand;
use SmashedEgg\LaravelConsoleEnhancements\Tests\Command\MultipleAliasCommand;
use SmashedEgg\LaravelConsoleEnhancements\Tests\Command\TestCommand;

class TestServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            TestCommand::class,
            MultipleAliasCommand::class,
            InteractiveCommand::class,
        ]);
    }
}
