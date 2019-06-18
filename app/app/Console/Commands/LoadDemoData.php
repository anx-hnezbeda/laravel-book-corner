<?php

namespace App\Console\Commands;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookUser;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

/**
 * Class LoadDemoData
 * @package App\Console\Commands
 */
class LoadDemoData extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'lbc:load-demo-data 
							{--refresh : Whether the database should refreshed or not}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Laravel Book Corner: Load random generated demo data';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$refresh = (bool) $this->option( 'refresh' );

		if ( $refresh ) {
			$this->info( 'Refreshing database...' );
			Artisan::call( 'migrate:refresh' );
			$this->info( 'Database refreshed.' );
		}

		$this->info( 'Seeding: Tags' );
		factory( Tag::class, 50 )->create();

		$this->info( 'Seeding: Categories' );
		factory( Category::class, 15 )->create();

		$this->info( 'Seeding: Publishers' );
		factory( Publisher::class, 20 )->create();

		$this->info( 'Seeding: Authors' );
		factory( Author::class, 80 )->create();

		$this->info( 'Seeding: Books' );
		factory( Book::class, 200 )->create()->each( function ( $a ) {
			$a->authors()->attach( Author::all()->random( rand( 1, 5 ) ) );
			$a->categories()->attach( Category::all()->random( rand( 1, 3 ) ) );
			$a->tags()->attach( Tag::all()->random( rand( 0, 10 ) ) );
		} );

		$this->info( 'Seeding: Users' );
		factory( User::class, 50 )->create();

		$this->info( 'Seeding: BookUsers' );
		$users = User::inRandomOrder()->limit( 10 )->get();
		foreach ( $users as $user ) {
			$books = Book::inRandomOrder()->limit( 10 )->get();

			foreach ( $books as $book ) {
				$bookUser          = new BookUser();
				$bookUser->book_id = $book->id;
				$bookUser->user_id = $user->id;
				$bookUser->save();
			}
		}

		$this->info( 'Done.' );
	}
}
