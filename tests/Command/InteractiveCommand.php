<?php

namespace SmashedEgg\LaravelConsoleEnhancements\Tests\Command;

use SmashedEgg\LaravelConsoleEnhancements\Command\AbstractCommand;

class InteractiveCommand extends AbstractCommand
{
    protected $signature = 'interactive:command {name : An argument}';

    public function handle()
    {
        $this->output->writeln('Hello, ' . $this->argument('name'));
        return 0;
    }

    public function handleInteract()
    {
        if ( ! $this->argument('name')) {
            $this->setArgument('name', $this->ask('Name ?'));
        }
    }
}
