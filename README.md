<p align="center">
  <img src="https://raw.githubusercontent.com/smashed-egg/.github/05d922c99f1a3bddea88339064534566b941eca9/profile/main.jpg" width="300">
</p>

# Laravel Console

This package allows you to enhance your Console Commands by making it easier to add aliases and use interactive functionality.

You can still use this functionality in your current console commands, as Symfony provides this functionality.

The purpose of this package is to make its usage more Laravel like. 

## Requirements

* PHP 8.0+
* Laravel 9.21+

## Installation

To install this package please run:

```
composer require smashed-egg/laravel-console
```
## Usage

First you need to update your command, so it now extends:

`SmashedEgg\LaravelConsole\Command`

instead of

`Illuminate\Console\Command`

We extend this is our class, giving you the same Laravel functionality.

So your class might look like:

```
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

```
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

```
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

```
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

```
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



