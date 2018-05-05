<?php

namespace Tests;

use Faker\Generator;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Faker\Factory as Faker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /** @var Generator */
    protected static $faker;

    public static function setUpBeforeClass()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUpBeforeClass();
        self::$faker = Faker::create();
    }
}
