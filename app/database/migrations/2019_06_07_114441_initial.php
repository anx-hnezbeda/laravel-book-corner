<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Initial extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'categories', function ( Blueprint $table ) {
			$table->bigIncrements( 'id' );
			$table->string( 'name' );

			$table->softDeletes();
			$table->timestamps();
		} );

		Schema::table( 'categories', function ( Blueprint $table ) {

			$table->bigInteger( 'parent_id' )->nullable()->index();

			$table->foreign( 'parent_id' )
			      ->references( 'id' )->on( 'categories' )
			      ->onDelete( 'set null' );
		} );

		Schema::create( 'tags', function ( Blueprint $table ) {
			$table->bigIncrements( 'id' );
			$table->string( 'name' );

			$table->softDeletes();
			$table->timestamps();
		} );

		Schema::create( 'publishers', function ( Blueprint $table ) {
			$table->bigIncrements( 'id' );
			$table->string( 'name' );
			$table->string( 'short_name' );

			$table->softDeletes();
			$table->timestamps();
		} );

		Schema::create( 'authors', function ( Blueprint $table ) {
			$table->bigIncrements( 'id' );
			$table->string( 'name' );
			$table->text( 'biography' )->nullable();

			$table->softDeletes();
			$table->timestamps();
		} );

		Schema::create( 'books', function ( Blueprint $table ) {
			$table->bigIncrements( 'id' );
			$table->string( 'name' );
			$table->integer( 'pages' )->default( 0 );
			$table->string( 'ean' )->nullable();
			$table->string( 'isbn_10' )->nullable();
			$table->string( 'isbn_13' )->nullable();
			$table->date( 'release_date' )->nullable();
			$table->enum( 'type', [ 'HARDCOVER', 'SOFTCOVER', 'EBOOK' ] )->default( 'HARDCOVER' );
			$table->boolean( 'nsfw' )->default( false );

			$table->bigInteger( 'publisher_id' )->index();

			$table->softDeletes();
			$table->timestamps();

			$table->foreign( 'publisher_id' )
			      ->references( 'id' )->on( 'publishers' )
			      ->onDelete( 'cascade' );
		} );

		Schema::create( 'book_user', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

			$table->bigInteger( 'book_id' );
			$table->bigInteger( 'user_id' );

            $table->unique(array('book_id', 'user_id'));

			$table->softDeletes();
			$table->timestamps();

			$table->foreign( 'book_id' )
			      ->references( 'id' )->on( 'books' )
			      ->onDelete( 'cascade' );

			$table->foreign( 'user_id' )
			      ->references( 'id' )->on( 'users' )
			      ->onDelete( 'cascade' );
		} );

		Schema::create( 'author_book', function ( Blueprint $table ) {
			$table->bigInteger( 'author_id' );
			$table->bigInteger( 'book_id' );

            $table->unique(array('author_id', 'book_id'));

			$table->foreign( 'author_id' )
			      ->references( 'id' )->on( 'authors' )
			      ->onDelete( 'cascade' );

			$table->foreign( 'book_id' )
			      ->references( 'id' )->on( 'books' )
			      ->onDelete( 'cascade' );
		} );

		Schema::create( 'book_category', function ( Blueprint $table ) {
			$table->bigInteger( 'book_id' );
			$table->bigInteger( 'category_id' );

            $table->unique(array('book_id', 'category_id'));

			$table->foreign( 'book_id' )
			      ->references( 'id' )->on( 'books' )
			      ->onDelete( 'cascade' );

			$table->foreign( 'category_id' )
			      ->references( 'id' )->on( 'categories' )
			      ->onDelete( 'cascade' );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'book_category' );
		Schema::dropIfExists( 'author_book' );
		Schema::dropIfExists( 'book_user' );
		Schema::dropIfExists( 'books' );
		Schema::dropIfExists( 'authors' );
		Schema::dropIfExists( 'publishers' );
		Schema::dropIfExists( 'tags' );
		Schema::dropIfExists( 'categories' );
	}
}
