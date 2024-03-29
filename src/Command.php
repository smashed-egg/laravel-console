<?php

namespace SmashedEgg\LaravelConsole;

use Illuminate\Console\Command as LaravelCommand;
use Illuminate\Support\Arr;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends LaravelCommand
{
    /**
     * The alias (or aliases) of the command
     *
     * @var string|array<string>
     */
    protected $alias;

    protected function configure()
    {
        parent::configure();

        // If we have any aliases set configure them
        if ($this->alias) {
            $this->setAliases(
                Arr::wrap($this->alias)
            );
        }
    }

    public function handleInteract()
    {
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        // Pass off Symfony interact method to our own
        $this->handleInteract();
    }

    protected function setArgument(string $name, $value)
    {
        // Set argument value against the console input
        $this->input->setArgument($name, $value);
    }

    protected function setOption(string $name, $value)
    {
        // Set option value against the console input
        $this->input->setOption($name, $value);
    }
}
