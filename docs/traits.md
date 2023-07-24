# Traits (Concerns)

This package provides (or will) various Traits that can be used to drop in extra functionality.

Below are the available traits.

- [AskAndValidate](#ask-and-validate) - Provides the ability to validate input from a question repetitively until validation passes.

## Ask and Validate

Adding this trait provides a new method `askAndValidate`.

With this trait you ask for input and validate in a loop until the value is correct.
The resulting code makes commands easy to read by combining the input and checking logic.

Simply add the trait `SmashedEgg\LaravelConsole\Concerns\AskAndValidate` to your existing commands.
You don't have to extend `SmashedEgg\LaravelConsole\Command` to use this feature.

Example code below:
```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SmashedEgg\LaravelConsole\Concerns\AskAndValidate;

class AgeCommand extends Command
{
    use AskAndValidate;

    protected $signature = 'ask-age';

    public function handle()
    {
        $age = $this->askAndValidate(question: 'Age ?', rules: ['integer'], messages: ['input.integer' => 'Input must be a number']);

        $this->info('You are ' . $age);

        return 0;
    }
}
```

The user will be prompted in a loop until the age is entered correctly.

```shell
vagrant@homestead:/var/www/vhosts/laravel9$ php artisan ask-age

 Age ?:
 > not an age

Invalid input:
Input must be a number

 Age ?:
 > 36
 
 You are 36

vagrant@homestead:/var/www/vhosts/laravel9$
```
