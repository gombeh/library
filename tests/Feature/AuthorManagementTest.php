<?php

namespace Tests\Feature;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_author_can_be_created(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/authors', [
            'name' => 'salmon',
            'dob' => '01/11/1994'
        ]);

        $response->assertStatus(200);

        $authors = Author::all();



        $this->assertCount(1, $authors);
        $this->assertInstanceOf(Carbon::class, $authors->first()->dob);
        $this->assertEquals("1994/11/01", $authors->first()->dob->format("Y/d/m"));

    }
}
