<?php

namespace Tests;

use App\Role;
use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use WithFaker;

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     * @throws \ReflectionException
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(\get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * @param string $key
     * @param string $value
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function setConfigurationString(string $key, string $value): TestResponse
    {
        return $this->postJson('/api/configurations/', [
            'key' => $key,
            'value' => $value,
        ]);
    }

    protected function setUp()
    {
        parent::setUp();

        $superadmin = User::whereHas('role', function ($query) {
            $query->where('name', 'like', 'superadmin');
        })->get()->first();

        Passport::actingAs($superadmin);
    }
}
