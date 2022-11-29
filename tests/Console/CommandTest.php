<?php

namespace SmashedEgg\LaravelConsoleEnhancements\Tests\Console;

use Orchestra\Testbench\Console\Kernel;
use SmashedEgg\LaravelConsoleEnhancements\Tests\TestCase;
use SmashedEgg\LaravelConsoleEnhancements\Tests\TestServiceProvider;

class CommandTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            TestServiceProvider::class,
        ];
    }

    public function testAliasIsAssignedToCommand()
    {
        $this
            ->artisan('m:c', [
                'name' => 'Tom'
            ])
            ->assertExitCode(0)
        ;
    }

    public function testMultipleAliasesAreAssignedToCommand()
    {
        $this
            ->artisan('ma:c', [
                'name' => 'Tom'
            ])
            ->assertExitCode(0)
        ;

        $this
            ->artisan('ma:cm', [
                'name' => 'Tom'
            ])
            ->assertExitCode(0)
        ;
    }

    public function testInteractiveCommandWithArgument()
    {
        $this
            ->artisan('interactive:command', [
                'name' => 'Tom'
            ])
            ->expectsOutputToContain('Hello, Tom')
            ->assertExitCode(0)
        ;
    }

    public function testInteractiveCommandWithoutArgument()
    {
        $this
            ->artisan('interactive:command')
            ->expectsQuestion('Name ?', 'Dave')
            ->expectsOutputToContain('Hello, Dave')
            ->assertExitCode(0)
        ;
    }

    public function getKernel(): Kernel
    {
        return $this->app->make(\Illuminate\Contracts\Console\Kernel::class);
    }
}
