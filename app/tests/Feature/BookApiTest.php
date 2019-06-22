<?php

namespace Tests\BookApi;

use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BookApiTest extends TestCase
{

    function setUp(): void
    {
        parent::setUp();

        // Seed database
        $this->artisan('lbc:load-demo-data --refresh');
    }

    /**
     * Test book count for simple query
     *
     * @return void
     */
    function test_books_query_count()
    {
        DB::enableQueryLog();
        $response = $this->json('GET', '/api/v1/books');
        DB::disableQueryLog();

        $this->assertEquals( 1, \count( DB::getQueryLog() ) );
    }

    /**
     * Test book count for include query
     *
     * @return void
     */
    function test_books_with_includes_query_count()
    {
        DB::enableQueryLog();
        $response = $this->json('GET', '/api/v1/books?include=publisher,authors,users,tags,categories');
        DB::disableQueryLog();

        $this->assertEquals( 6, \count( DB::getQueryLog() ) );
    }

    /**
     * Test raw fetch books
     *
     * @return void
     */
    function test_raw_books_with_includes_query_count()
    {
        DB::enableQueryLog();
        $books = Book::all();

        foreach ($books as $book) {
            $this->assertNotEmpty($book->publisher->name);
            $this::assertGreaterThanOrEqual(0, $book->authors->count());
            $this::assertGreaterThanOrEqual(0, $book->users->count());
            $this::assertGreaterThanOrEqual(0, $book->tags->count());
            $this::assertGreaterThanOrEqual(0, $book->categories->count());
        }
        DB::disableQueryLog();

        // Assert that the number of queries are below a certain point.
        $this->assertEquals( 1001, \count( DB::getQueryLog() ) );
    }

    /**
     * Test eager fetch books
     *
     * @return void
     */
    function test_eager_books_with_includes_query_count()
    {
        DB::enableQueryLog();
        $books = Book::all()->load(['publisher', 'authors', 'users', 'tags', 'categories']);

        foreach ($books as $book) {
            $this->assertNotEmpty($book->publisher->name);
            $this::assertGreaterThanOrEqual(0, $book->authors->count());
            $this::assertGreaterThanOrEqual(0, $book->users->count());
            $this::assertGreaterThanOrEqual(0, $book->tags->count());
            $this::assertGreaterThanOrEqual(0, $book->categories->count());
        }
        DB::disableQueryLog();

        // Assert that the number of queries are below a certain point.
        $this->assertEquals( 6, \count( DB::getQueryLog() ) );
    }

}
