<?php

namespace Tests\Unit;

use App\Helpers\TeHelper;
use Carbon\Carbon;

class TeHelperTest extends TestCase
{
    /**
     * Test willExpireAt method
     *
     * @return void
     */
    public function testWillExpireAt()
    {
        // test data
        $dueTime = Carbon::now()->addHours(3); // Example due time 3 hours from now
        $createdAt = Carbon::now(); // Example created at now

        // Call the method you want to test
        $result = TeHelper::willExpireAt($dueTime, $createdAt);

        // Expected expiry time based on the conditions in the method
        if ($dueTime->diffInHours($createdAt) <= 90) {
            $expected = $dueTime;
        } elseif ($dueTime->diffInHours($createdAt) <= 24) {
            $expected = $createdAt->copy()->addMinutes(90);
        } elseif ($dueTime->diffInHours($createdAt) > 24 && $dueTime->diffInHours($createdAt) <= 72) {
            $expected = $createdAt->copy()->addHours(16);
        } else {
            $expected = $dueTime->copy()->subHours(48);
        }

        $this->assertEquals($expected->format('Y-m-d H:i:s'), $result);
    }
}
