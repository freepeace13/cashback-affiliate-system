<?php

namespace Cashback\Tests;

use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Facade;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory as ValidationFactory;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected FakerGenerator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = FakerFactory::create();

        $translator = new Translator(new ArrayLoader(), 'en');
        $container = new Container;
        $container->instance('translator', $translator);
        $container->singleton('validator', fn () => new ValidationFactory($translator));
        Facade::setFacadeApplication($container);
    }
}
