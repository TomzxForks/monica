<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser as DuskBrowser;

class Browser extends DuskBrowser
{
    /*
     * To scroll down/up, until the selector is visible
     */
    public function scrollTo($selector) {
        //$element = $this->element($selector);
        //$this->driver->executeScript("arguments[0].scrollIntoView(true);",[$element]);

        $selectorby = $this->resolver->format($selector);
        $this->driver->executeScript("$(\"html, body\").animate({scrollTop: $(\"$selectorby\").offset().top}, 0);");

        return $this;
    }

    public function hasDivAlert()
    {
        $res = $this->elements('alert');

        return count($res) > 0;
    }

    public function getDivAlert()
    {
        $res = $this->elements('alert');
        if (count($res) > 0) {
            return $res[0];
        }
    }
}
