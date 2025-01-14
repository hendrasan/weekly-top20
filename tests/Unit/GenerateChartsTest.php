<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Console\Commands\GenerateCharts;
use App\Services\Spotify;
use App\Models\User;
use Mockery;

class GenerateChartsTest extends TestCase
{
    use RefreshDatabase;

    public function testHandle()
    {
        $spotifyMock = Mockery::mock(Spotify::class);
        $spotifyMock->shouldReceive('generateChart')->andReturn(true);

        $this->app->instance(Spotify::class, $spotifyMock);

        $user = factory(User::class)->create();

        $command = new GenerateCharts($spotifyMock);
        $this->artisan('chart:generate')
            ->expectsOutput('Starting chart generation...')
            ->expectsOutput('Chart for ' . $user->name . ' generated successfully!')
            ->expectsOutput('All charts generated successfully!')
            ->assertExitCode(0);
    }
}
