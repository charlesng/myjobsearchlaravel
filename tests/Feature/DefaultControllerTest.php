<?php

namespace Tests\Feature;

use Tests\TestCase;

class DefaultControllerTest extends TestCase
{
    public function testGetHomeReq(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testGetHelloWorldReq(): void
    {
        $response = $this->get('foo');
        $response->assertStatus(200)
            ->assertSeeText("Hello World");
    }

    public function testGetWelcomeReq(): void
    {
        $response = $this->get('/welcome');
        $response->assertStatus(200);
    }
}
