<?php

namespace SmashedEgg\LaravelConsole\Tests\Console;

use Illuminate\Console\OutputStyle;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use SmashedEgg\LaravelConsole\Command;
use SmashedEgg\LaravelConsole\Concerns\AskAndValidate;
use SmashedEgg\LaravelConsole\Tests\TestCase;
use SmashedEgg\LaravelConsole\Tests\TestServiceProvider;
use Mockery as m;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class CommandTest extends TestCase
{
    protected function getPackageProviders($app): array
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

    public function testQuestionCommandRunsUntilValidationPasses()
    {
        $this
            ->artisan('question:command')
            ->expectsQuestion('Name ?', '')
            ->expectsOutputToContain('Invalid input:')
            ->expectsOutputToContain('Input is required')
            ->expectsQuestion('Name ?', 'Tom')
            ->expectsOutputToContain('Hello Tom')
            ->assertExitCode(0)
        ;
    }

    public function testAskWithValidateAlternative()
    {
        // This test was written as part of a PR for a feature in Laravel 10.x
        // so thought id keep and reuse
        $output = m::mock(OutputStyle::class);

        $output->shouldReceive('ask')->twice()->with('Name ?', null)->andReturns('Tommy tommy tom tom tom tom', 'Tom');

        $output->shouldReceive('writeln')->once()->withArgs(function (...$args) {
            return $args[0] === '<error>Invalid input:</error>';
        });

        $output->shouldReceive('writeln')->once()->withArgs(function (...$args) {
            return $args[0] === '<error>input must be less than 25 characters</error>';
        });

        $validationMessages = [
            'input.required' => 'input is required',
            'input.max' => 'input must be less than 25 characters',
        ];

        $validator1 = m::mock(ValidatorContract::class);
        $validator2 = m::mock(ValidatorContract::class);

        $validationException = m::mock(ValidationException::class);

        $validationException
            ->shouldReceive('errors')
            ->once()
            ->andReturn([
                'input' => [
                    'input must be less than 25 characters',
                ],
            ])
        ;

        $validator1->shouldReceive('validate')
            ->once()
            ->andThrow($validationException)
        ;

        $validator2->shouldReceive('validate')
            ->once()
            ->andReturn([
                'input' => 'Tom'
            ])
        ;

        Validator::shouldReceive('make')
            ->twice()
            ->andReturns($validator1, $validator2)
        ;

        $command = new class extends Command {
            use AskAndValidate;
        };

        $command->setOutput($output);

        $command->askAndValidate(
            question: 'Name ?',
            rules: ['required', 'max:25'],
            messages: $validationMessages
        );
    }

    public function testAskWithCompletionAndValidate()
    {
        $output = m::mock(OutputStyle::class);

        //$output->shouldReceive('askQuestion')->twice()->with('Whats your favourite flavour?', null)->andReturns('cheese', 'chocolate');
        $output->shouldReceive('askQuestion')->twice()->with(m::any())->andReturns('cheese', 'chocolate');

        $output->shouldReceive('writeln')->once()->withArgs(function (...$args) {
            return $args[0] === '<error>Invalid input:</error>';
        });

        $output->shouldReceive('writeln')->once()->withArgs(function (...$args) {
            return $args[0] === '<error>the selected input is invalid</error>';
        });

        $validationMessages = [
            'input.required' => 'input is required',
            'input.in' => 'the selected input is invalid',
        ];

        $validator1 = m::mock(ValidatorContract::class);
        $validator2 = m::mock(ValidatorContract::class);

        $validationException = m::mock(ValidationException::class);

        $validationException
            ->shouldReceive('errors')
            ->once()
            ->andReturn([
                'input' => [
                    'the selected input is invalid',
                ],
            ])
        ;

        $validator1->shouldReceive('validate')
            ->once()
            ->andThrow($validationException)
        ;

        $validator2->shouldReceive('validate')
            ->once()
            ->andReturn([
                'input' => 'Tom'
            ])
        ;

        Validator::shouldReceive('make')
            ->twice()
            ->andReturns($validator1, $validator2)
        ;

        $command = new class extends Command {
            use AskAndValidate;
        };

        $command->setOutput($output);

        $choices = [
            'chocolate',
            'vanilla',
            'strawberry',
        ];

        $command->askWithCompletionAndValidate(
            question: 'Name ?',
            choices: $choices,
            rules: ['required', 'max:25'],
            messages: $validationMessages
        );
    }
}
