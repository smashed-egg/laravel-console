<?php

namespace SmashedEgg\LaravelConsole\Tests\Command;

use SmashedEgg\LaravelConsole\Console\Command;

class TestCommand extends Command
{
    protected $signature = 'my:command {name : An argument}';

    protected $alias = 'm:c';

    public function handle()
    {
        return 0;
    }
}
