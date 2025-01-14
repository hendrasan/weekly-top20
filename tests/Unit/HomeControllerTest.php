<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\HomeController;
use App\Services\Spotify;
use App\Models\User;
use App\Models\Chart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetIndex()
    {
        $spotifyMock = $this->createMock(Spotify::class);
        $controller = new HomeController();
        $response = $controller->getIndex($spotifyMock);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('users');
    }

    public function testGetUserChart()
    {
        $user = factory(User::class)->create(['spotify_id' => 'testuser']);
        $chart = factory(Chart::class)->create(['user_id' => $user->id, 'period' => 1]);

        $controller = new HomeController();
        $response = $controller->getUserChart('testuser');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('user');
        $this->assertViewHas('chart');
    }

    public function testGetDashboard()
    {
        $user = factory(User::class)->create();
        Auth::login($user);

        $controller = new HomeController();
        $response = $controller->getDashboard();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('user');
        $this->assertViewHas('chart');
    }

    public function testGetRewind2018()
    {
        $user = factory(User::class)->create();
        Auth::login($user);

        $controller = new HomeController();
        $response = $controller->getRewind2018();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('user');
        $this->assertViewHas('chart');
    }

    public function testPostRewind2018()
    {
        $user = factory(User::class)->create();
        Auth::login($user);

        $spotifyMock = $this->createMock(Spotify::class);
        $spotifyMock->method('createPlaylist')->willReturn(['id' => 'new_playlist_id']);

        $controller = new HomeController();
        $response = $controller->postRewind2018($spotifyMock);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    public function testGetRewind()
    {
        $user = factory(User::class)->create();
        Auth::login($user);

        $controller = new HomeController();
        $response = $controller->getRewind(2018);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('user');
        $this->assertViewHas('chart');
    }

    public function testPostRewind()
    {
        $user = factory(User::class)->create();
        Auth::login($user);

        $spotifyMock = $this->createMock(Spotify::class);
        $spotifyMock->method('createPlaylist')->willReturn(['id' => 'new_playlist_id']);

        $controller = new HomeController();
        $response = $controller->postRewind($spotifyMock, 2018);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }
}
