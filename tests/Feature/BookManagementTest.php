<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library(): void
    {
        $data = [
            'title' => 'Harry patter',
            'author' => 'salmon'
        ];

        $response = $this->post('/books', $data);

        $book = Book::first();

        $this->assertEquals($data['title'], $book->title);
        $this->assertEquals($data['author'], $book->author);
        $this->assertCount(1, Book::all());

        $response->assertRedirect($book->path());
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
        $this->post('/books', [
            'title' => 'Harry patter',
            'author' => 'salmon'
        ]);

        $data = [
            'title' => 'New Harry patter',
            'author' => 'New salmon'
        ];

        $book = Book::first();

        $response = $this->patch($book->path(), $data);

        $this->assertEquals($data['title'], Book::first()->title);
        $this->assertEquals($data['author'], Book::first()->author);

        $response->assertRedirect($book->refresh()->path());
    }

    /** @test */
    public function a_book_can_be_deleted() {

        $this->post('/books', [
            'title' => 'Harry patter',
            'author' => 'salmon'
        ]);

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }
}
