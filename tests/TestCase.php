<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    use \Tests\Base\BaseLaravel9ControllerTestTrait;
    use \Tests\Base\TestExtendTrait;

}
