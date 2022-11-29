<?php

namespace SmashedEgg\LaravelConsoleEnhancements\Tests\Command;

use SmashedEgg\LaravelConsoleEnhancements\Command\AbstractCommand;

class TestCommand extends AbstractCommand
{
    protected $signature = 'my:command {name : An argument}';

    protected $alias = 'm:c';

    public function handle()
    {
        return 0;
    }
}
