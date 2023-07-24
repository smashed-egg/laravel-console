<?php

namespace SmashedEgg\LaravelConsole\Tests\Command;

use SmashedEgg\LaravelConsole\Command;
use SmashedEgg\LaravelConsole\Concerns\AskAndValidate;

class QuestionCommand extends Command
{
    use AskAndValidate;

    protected $signature = 'question:command';

    protected $alias = 'q:c';

    public function handle()
    {
        $name = $this->askAndValidate(question: 'Name ?', rules: ['required'], messages: ['input.required' => 'Input is required']);

        $this->info('Hello ' . $name);

        return 0;
    }
}
