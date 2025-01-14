<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Chart;
use App\Models\User;

class ChartTest extends TestCase
{
    public function testUser()
    {
        $chart = factory(Chart::class)->create();
        $this->assertInstanceOf(User::class, $chart->user);
    }
}
