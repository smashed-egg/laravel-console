<?php

namespace SmashedEgg\LaravelConsole\Tests\Command;

use SmashedEgg\LaravelConsole\Command;
use SmashedEgg\LaravelConsole\Concerns\AskAndValidate;

class SecretCommand extends Command
{
    use AskAndValidate;

    protected $signature = 'secret:command';

    protected $alias = 's:c';

    public function handle()
    {
        $name = $this->secretAndValidate(question: 'Password ?', rules: ['required'], messages: ['input.required' => 'Input is required']);

        $this->info($name);

        return 0;
    }
}
