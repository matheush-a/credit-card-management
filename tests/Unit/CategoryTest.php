<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;

    protected User $user;
    protected Category $category;
    protected $headers;

    public function __construct()
    {
        $this->category = new Category();
        $this->user = new User();
        $this->headers = [
            'X-Requested-With' => 'XMLHttpRequest',
            'Accept' => '*/*'
        ];
        
        parent::__construct();
    }

    public function test_index_successful()
    {
        $user = $this->user::factory()->create([
            'user_type_id' => 1
        ]);

        $response = $this->actingAs($user)
            ->get('/api/categories/');
        
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_index_failure()
    {
        $response = $this->get('/api/categories/', $this->headers);
        
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
