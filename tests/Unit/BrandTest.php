<?php

namespace Tests\Unit;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class BrandTest extends TestCase
{
    use DatabaseTransactions;

    protected User $user;
    protected Brand $brand;
    protected $headers;

    public function __construct()
    {
        $this->brand = new Brand();
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
            ->get('/api/brands/');
        
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_index_failure()
    {
        $response = $this->get('/api/brands/', $this->headers);
        
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
