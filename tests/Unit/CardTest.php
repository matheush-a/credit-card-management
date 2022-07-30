<?php

namespace Tests\Unit;

use App\Models\Card;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class CardTest extends TestCase
{
    use DatabaseTransactions;

    protected User $user;
    protected Card $card;
    protected $headers;

    public function __construct()
    {
        $this->card = new Card();
        $this->user = new User();
        $this->headers = [
            'X-Requested-With' => 'XMLHttpRequest',
            'Accept' => '*/*'
        ];
        
        parent::__construct();
    }

    public function test_index_successful()
    {
        $card = $this->card::factory()->make();
        $user = $this->user::factory()->create([
            'user_type_id' => 1
        ]);

        $response = $this->actingAs($user)
            ->get('/api/cards/');
        
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_show_successful()
    {
        $card = $this->card::factory()->create();
        $user = $this->user::factory()->create([
            'user_type_id' => 1
        ]);

        $response = $this->actingAs($user)
            ->get('/api/cards/'.$card->id);
        
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'name' => $card->name,
                'image' => $card->image,
                'limit' => $card->limit,
                'annual_fee' => $card->annual_fee,
            ]);
    }

    public function test_show_failure()
    {
        $card = $this->card::factory()->create();

        $response = $this->get('/api/cards/'.$card->id, $this->headers);
        
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_store_successful()
    {
        $card = $this->card::factory()->make();
        $user = $this->user::factory()->create([
            'user_type_id' => 1
        ]);

        $response = $this->actingAs($user)
            ->post('/api/cards/', $card->attributesToArray());
        
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_store_failure()
    {
        $cardInBase = $this->card::factory()->create();

        $card = $this->card::factory()->make([
            'name' => $cardInBase->name
        ]);

        $user = $this->user::factory()->create([
            'user_type_id' => 1
        ]);

        $response = $this->actingAs($user)
            ->post('/api/cards/', $card->attributesToArray());
        
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_update_successful()
    {
        $cardInBase = $this->card::factory()->create();

        $card = $this->card::factory()->make();

        $user = $this->user::factory()->create([
            'user_type_id' => 1
        ]);

        $response = $this->actingAs($user)
            ->put('/api/cards/'.$cardInBase->id, $card->attributesToArray());
        
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_update_failure()
    {
        $cardInBase = $this->card::factory()->create();

        $card = $this->card::factory()->make([
            'name' => $cardInBase->name
        ]);

        $user = $this->user::factory()->create([
            'user_type_id' => 1
        ]);

        $response = $this->actingAs($user)
            ->put('/api/cards/'.$cardInBase->id*1000, $card->attributesToArray(), $this->headers);
        
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    
    public function test_remove_successful()
    {
        $cardInBase = $this->card::factory()->create();

        $card = $this->card::factory()->make();

        $user = $this->user::factory()->create([
            'user_type_id' => 1
        ]);

        $response = $this->actingAs($user)
            ->post('/api/cards/remove/'.$cardInBase->id);
        
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_remove_failure()
    {
        $cardInBase = $this->card::factory()->create();

        $card = $this->card::factory()->make([
            'name' => $cardInBase->name
        ]);

        $user = $this->user::factory()->create([
            'user_type_id' => 1
        ]);

        $response = $this->actingAs($user)
            ->post('/api/cards/remove/'.$cardInBase->id*1000, $this->headers);
        
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }
}
