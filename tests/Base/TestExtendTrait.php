<?php

namespace Tests\Base;

trait TestExtendTrait
{

    public static function commandRun($commandClass)
    {
        static::assertIsString($commandClass);

        /** @var \Illuminate\Console\Command $command */
        $command = new $commandClass();

        $command->setLaravel(app());
        $command->ignoreValidationErrors();

        return $command->run(
            new \Symfony\Component\Console\Input\ArgvInput,
            new \Symfony\Component\Console\Output\ConsoleOutput,
        );
    }

}
