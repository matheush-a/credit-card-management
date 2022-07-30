<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    protected User $user;
    protected $password = '12345678';
    protected $headers;

    public function __construct()
    {
        $this->user = new User();
        $this->headers = [
            'X-Requested-With' => 'XMLHttpRequest',
            'Accept' => '*/*'
        ];
        
        parent::__construct();
    }

    public function test_login_successful()
    {
        $user = $this->user::factory()->create([
            'password' => $this->password,
            'user_type_id' => 1
        ]);

        $response = $this->post('/api/users/', [
            'email' => $user->email,
            'password' => $this->password
        ]);
        
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_login_failure()
    {
        $user = $this->user::factory()->create([
            'password' => $this->password,
            'user_type_id' => 1
        ]);

        $response = $this->post('/api/users/', [
            'email' => $user->email,
            'password' => 'wrongPassword'
        ], $this->headers);
        
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_user_store_successful()
    {
        $user = $this->user::factory()->make([
            'password' => $this->password,
            'user_type_id' => 1
        ]);
        
        $response = $this->post('/api/users/store', [
            'email' => $user->email,
            'name' => $user->name,
            'password' => $this->password,
            'user_type_id' => 1
        ]);
      
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_user_store_failure()
    {
        $user = $this->user::factory()->make([
            'password' => $this->password,
            'user_type_id' => 1
        ]);
        
        $response = $this->post('/api/users/store', [
            'email' => $user->email,
            'name' => $user->name,
            'password' => $this->password,
            'user_type_id' => 6
        ], $this->headers);
      
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
