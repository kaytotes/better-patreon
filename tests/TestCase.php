<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Sets up Laravel Passport.
     *
     */
    public function setUpPassport()
    {
        \Artisan::call('passport:install', ['-vvv' => true]);
    }
}
