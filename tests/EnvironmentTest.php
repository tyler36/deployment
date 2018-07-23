<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Tests\TestCase;
use Tyler36\Deployment\Environment;

/**
 * Class EnvironmentTest
 *
 * @test
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class EnvironmentTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_get_an_array_of_environments()
    {
        config()->set('deployment.envs', [
            'test' => 'test',
        ]);

        $package = new Environment();

        $this->assertSame(['.env.test'], $package->getAvailableEnvironments('test'));
    }
}
