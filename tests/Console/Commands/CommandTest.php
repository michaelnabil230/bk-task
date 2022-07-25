<?php

namespace Tests\Console\Commands;

use Tests\TestCase;

class CommandTest extends TestCase
{
    public function test_the_reorder_students_command()
    {
        $this->artisan('reorder-students')
            ->expectsOutput('Order students successfully')
            ->assertExitCode(0);
    }
}
