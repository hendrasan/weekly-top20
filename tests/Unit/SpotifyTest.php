<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\Spotify;
use App\Models\User;
use App\Models\Chart;
use Mockery;
use Carbon\Carbon;
use SpotifyWebAPI\SpotifyWebAPI;

class SpotifyTest extends TestCase
{
    protected $spotify;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->spotify = Mockery::mock(SpotifyWebAPI::class);
        $this->user = factory(User::class)->create();
    }

    public function testGenerateChart()
    {
        $spotifyService = new Spotify($this->spotify);

        $this->spotify->shouldReceive('setAccessToken')
            ->once()
            ->with($this->user->spotify_access_token);

        $this->spotify->shouldReceive('getMyTop')
            ->once()
            ->with('tracks', ['limit' => 20, 'time_range' => 'short_term'])
            ->andReturn((object)[
                'items' => [
                    (object)[
                        'id' => 'track1',
                        'name' => 'Track 1',
                        'artists' => [(object)['name' => 'Artist 1']]
                    ],
                    (object)[
                        'id' => 'track2',
                        'name' => 'Track 2',
                        'artists' => [(object)['name' => 'Artist 2']]
                    ]
                ]
            ]);

        $spotifyService->generateChart($this->user);

        $this->assertDatabaseHas('charts', [
            'user_id' => $this->user->id,
            'track_spotify_id' => 'track1',
            'track_name' => 'Track 1',
            'track_artist' => 'Artist 1',
            'position' => 1
        ]);

        $this->assertDatabaseHas('charts', [
            'user_id' => $this->user->id,
            'track_spotify_id' => 'track2',
            'track_name' => 'Track 2',
            'track_artist' => 'Artist 2',
            'position' => 2
        ]);
    }

    public function testCreatePlaylist()
    {
        $spotifyService = new Spotify($this->spotify);

        $this->spotify->shouldReceive('createUserPlaylist')
            ->once()
            ->with($this->user->spotify_id, ['name' => 'Your Top Songs 2018'])
            ->andReturn((object)['id' => 'playlist1']);

        $this->spotify->shouldReceive('addUserPlaylistTracks')
            ->once()
            ->with($this->user->spotify_id, 'playlist1', ['track1', 'track2']);

        $newPlaylist = $spotifyService->createPlaylist($this->user, [
            'title' => 'Your Top Songs 2018',
            'tracks' => ['track1', 'track2']
        ]);

        $this->assertEquals('playlist1', $newPlaylist->id);
    }
}
