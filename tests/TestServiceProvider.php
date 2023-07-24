<?php

namespace SmashedEgg\LaravelConsole\Tests;

use Illuminate\Support\ServiceProvider;
use SmashedEgg\LaravelConsole\Tests\Command\InteractiveCommand;
use SmashedEgg\LaravelConsole\Tests\Command\MultipleAliasCommand;
use SmashedEgg\LaravelConsole\Tests\Command\QuestionCommand;
use SmashedEgg\LaravelConsole\Tests\Command\TestCommand;

class TestServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            TestCommand::class,
            MultipleAliasCommand::class,
            InteractiveCommand::class,
            QuestionCommand::class,
        ]);
    }
}
