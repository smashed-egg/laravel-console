<?php

namespace SmashedEgg\LaravelConsole\Tests\Command;

use SmashedEgg\LaravelConsole\Console\Command;

class MultipleAliasCommand extends Command
{
    protected $signature = 'multiple-alias:command {name : An argument}';

    protected $alias = [
        'ma:c',
        'ma:cm',
    ];

    public function handle()
    {
        return 0;
    }
}
