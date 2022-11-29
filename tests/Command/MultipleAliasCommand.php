<?php

namespace SmashedEgg\LaravelConsoleEnhancements\Tests\Command;

use SmashedEgg\LaravelConsoleEnhancements\Command\AbstractCommand;

class MultipleAliasCommand extends AbstractCommand
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
