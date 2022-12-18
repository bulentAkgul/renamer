<?php

namespace Bakgul\Renamer\Tests\Feature\CommandTests;

use Bakgul\Renamer\Tests\TestCase;

class RenameCommandTest extends TestCase
{
    /** @test */
    public function command_will_ask_for_confirmation_when_env_is_not_testing()
    {
        $_ENV['APP_ENV'] = 'something';
        config()->set('app.env', 'something');

        $message = "This command will be executed in console,\n and change the files. Do you want to proceed?\n";

        $this->artisan('refactor x y')
            ->expectsConfirmation($message, false)
            ->assertExitCode(0);

        $this->artisan('refactor x y')
            ->expectsConfirmation($message, true)
            ->assertExitCode(1);
    }

    /** @test */
    public function rename_command_will_be_called_for_file()
    {
        $this->artisan('rename Randomize Employee')
            ->expectsConfirmation('Do you want to proceed?', 'yes');
    }

    /** @test */
    public function rename_command_will_be_called_for_folder()
    {
        $this->artisan('rename MostOriginals NotOriginals -f');
    }
}
