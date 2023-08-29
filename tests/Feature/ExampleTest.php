<?php

namespace Tests\Feature;
use Illuminate\Support\Facades\DB;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    // public function test_the_application_returns_a_successful_response(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function test_GetArticlesByCategory(){
        $articles = DB::table('articles')
        ->select('articles.id')
        ->where('articles.id', 3)
        ->get();

        $this->assertEquals(3, $articles[0]->id);
    }

    public function test_httpResponse()
{
    $response = $this->get('http://127.0.0.1:8000/api/test');

    $response->assertStatus(200);
}
}
