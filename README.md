<p align="center">
  <img src="https://raw.githubusercontent.com/smashed-egg/.github/05d922c99f1a3bddea88339064534566b941eca9/profile/main.jpg" width="300">
</p>

# Laravel Console

This package allows you to enhance your Console Commands by making it easier to:

- Add aliases 
- Use interactive functionality (Since writing this a similar feature exist in Laravel 10.x).
- Making repetitive tasks easier via Traits (Concerns) to drop in extra functionality for your commands.

You can still use this functionality in your current console commands, as Symfony provides this functionality.

The purpose of this package is to make its usage more Laravel like. 

## Requirements

* PHP 8.0+
* Laravel 9.21+

## Installation

To install this package please run:

```shell
composer require smashed-egg/laravel-console
```
## Usage

First you need to update your command, so it now extends:

`SmashedEgg\LaravelConsole\Command`

instead of

`Illuminate\Console\Command`

We extend this is our class, giving you the same Laravel functionality.

So your class might look like:

```php
<?php

namespace App\Console;

use SmashedEgg\LaravelConsole\Command;

class HelloCommand extends Command
{
    protected $signature = 'hello {name : An argument}';

    public function handle()
    {
        $this->info("Hello " . $this->argument('name'));
        return 0;
    }
}
```

Now we can enhance the command!

### Console Command Aliases

You can add 1 or more aliases to your console command. 
This can make local development quicker if you have to type less.

Using the console command above we can easily add an alias by adding the $alias property.

```php
<?php

namespace App\Console;

use SmashedEgg\LaravelConsole\Command;

class HelloCommand extends Command
{
    protected $signature = 'hello {name : An argument}';
    
    protected $alias = 'h';

    public function handle()
    {
        $this->info("Hello " . $this->argument('name'));
        return 0;
    }
}
```

So instead of running:

```
php artisan hello Tom
```

You can now run:

```
php artisan h Tom
```

You can also specify a list of multiple aliases:

```php
<?php

namespace App\Console;

use SmashedEgg\LaravelConsole\Command;

class HelloCommand extends Command
{
    protected $signature = 'hello {name : An argument}';
    
    protected $alias = [
        'h',
        'he
    ];

    public function handle()
    {
        $this->info("Hello " . $this->argument('name'));
        return 0;
    }
}
```

Which means you can run any of the following to run the console command:

```
php artisan hello Tom
php artisan h Tom
php artisan he Tom
```

### Interactive Console Commands

Did you know the arguments you specify in the command signature can also be provided interactively? I know right!

Using the same hello command example, lets make it interactive! For simplicity we'll remove the alias, so it's easier to read.

First we need to add a method `handleInteract`.

```php
<?php

namespace App\Console;

use SmashedEgg\LaravelConsole\Command;

class HelloCommand extends Command
{
    protected $signature = 'hello {name : An argument}';
   
    public function handle()
    {
        $this->info("Hello " . $this->argument('name'));
        return 0;
    }
    
    public function handleInteract()
    {
        
    }
}
```

Next we need to update this method to ask for the arguments not provided.

```php
<?php

namespace App\Console;

use SmashedEgg\LaravelConsole\Command;

class HelloCommand extends Command
{
    protected $signature = 'hello {name : An argument}';
   
    public function handle()
    {
        $this->info("Hello " . $this->argument('name'));
        return 0;
    }
    
    public function handleInteract()
    {
        if ( ! $this->argument('name')) {
            $this->setArgument('name', $this->ask('Name ?'));
        }
    }
}
```

And boom, we've now enhanced our command so it can be called via:

```shell
php artisan hello Tom
```

but also as:

```shell
php artisan hello
```

which will prompt for the additional input.

```shell
vagrant@homestead:/var/www/vhosts/laravel9$ php artisan hello

 Name ?:
 > Tom

Hello Tom
vagrant@homestead:/var/www/vhosts/laravel9$
```

## Traits (Concerns)

This package provides (or will) various Traits that can be used to drop in extra functionality.

Below are the available traits.

- [AskAndValidate](#ask-and-validate) - Provides the ability to validate input from a question repetitively until validate passes.


### Ask and Validate

Adding this trait provides a new method `askAndValidate`.

When running commands that require a lot of input from the user, if you get partway through and the input is incorrect in some way, 
you may have to run the command again (depending on how the command is written to handle bad input).

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

