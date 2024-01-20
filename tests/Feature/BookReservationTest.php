<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library(): void
    {
        $this->withoutExceptionHandling();

        $data = [
            'title' => 'Harry patter',
            'author' => 'salmon'
        ];

        $response = $this->post('/books', $data);

        $response->assertOk();
        $response->assertSee($data['title']);
        $response->assertSee($data['author']);
        $book = Book::first();

        $this->assertEquals($data['title'], $book->title);
        $this->assertEquals($data['author'], $book->author);
        $this->assertCount(1, Book::all());
    }

    /** @test */
    public function a_title_required()
    {
        $data = [
            'title' => '',
            'author' => 'salmon'
        ];

        $response = $this->post('/books', $data);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_author_required()
    {
        $data = [
            'title' => 'Harry patter',
            'author' => ''
        ];

        $response = $this->post('/books', $data);

        $response->assertSessionHasErrors('author');
    }


    /** @test */
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'Harry patter',
            'author' => 'salmon'
        ]);

        $data = [
            'title' => 'New Harry patter',
            'author' => 'New salmon'
        ];

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, $data);

        $response->assertOk();
        $response->assertSee($data['title']);
        $response->assertSee($data['author']);
        $this->assertEquals($data['title'], Book::first()->title);
        $this->assertEquals($data['author'], Book::first()->author);

    }
}
