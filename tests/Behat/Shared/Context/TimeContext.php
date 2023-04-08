<?php

namespace App\Tests\Behat\Shared\Context;

use Behat\Behat\Context\Context;
use SlopeIt\ClockMock\ClockMock;

class TimeContext implements Context
{
    /**
     * @Given The time is frozen at :time
     */
    public function theTimeIsFrozenAt(string $time)
    {
        ClockMock::freeze(new \DateTimeImmutable($time));
    }

    /**
     * @AfterScenario @withFrozenTime
     */
    public function theTimeIsUnfrozen()
    {
        ClockMock::reset();
    }
}
