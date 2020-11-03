<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Persons;

use Tests\TestCase;

class AgeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function testExample()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function testAge()
    {

        $response = $this->get('/api/getAgeById?id=20');

        $response->assertStatus(200);
    }
}
