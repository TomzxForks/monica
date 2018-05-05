<?php

namespace Tests;

use Tests\Browser\Browser;
use Tests\Traits\SignIn;
use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication, SignIn;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static::useChromedriver(__DIR__.'/../vendor/bin/chromedriver');
        if (env('SAUCELABS') != '1') {
            static::startChromeDriver();
        }
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $capabilities = DesiredCapabilities::chrome();
        if (env('SAUCELABS') == '1') {
            $capabilities->setCapability('tunnel-identifier', env('TRAVIS_JOB_NUMBER'));

            return RemoteWebDriver::create(
                'http://'.env('SAUCE_USERNAME').':'.env('SAUCE_ACCESS_KEY').'@localhost:4445/wd/hub', $capabilities
            );
        } else {
            return RemoteWebDriver::create(
                'http://localhost:9515', $capabilities
            );
        }
    }

    /**
     * @param \Facebook\WebDriver\Remote\RemoteWebDriver $driver
     * @return \Tests\Browser\Browser
     */
    public function newBrowser($driver)
    {
        return new Browser($driver);
    }
}
