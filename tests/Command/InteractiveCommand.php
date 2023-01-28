<?php

namespace SmashedEgg\LaravelConsole\Tests\Command;

use SmashedEgg\LaravelConsole\Command;

class InteractiveCommand extends Command
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
