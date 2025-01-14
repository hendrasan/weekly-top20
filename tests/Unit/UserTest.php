<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Chart;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the charts method of the User model.
     *
     * @return void
     */
    public function testCharts()
    {
        $user = factory(User::class)->create();
        $chart = factory(Chart::class)->create(['user_id' => $user->id]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->charts);
        $this->assertTrue($user->charts->contains($chart));
    }
}
