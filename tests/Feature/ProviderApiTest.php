<?php

namespace Tests\Feature;

use Illuminate\Filesystem\Filesystem;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProviderApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $fs = new Filesystem();

        $definition = $fs->get(base_path('/api/providers/register/contract-register.yaml'));

        $response = $this->post('/api/v1/providers', [
            'id' => 'example_provider',
            'name' => 'example',
            'description' => 'An example',
            'definition' => $definition,
            'owner' => 'rpopuc',
            'tags' => 'example'
        ]);

        $response->assertStatus(200);



        $definition = $fs->get(base_path('/api/providers/register/consumers/consumer.json'));

        $response = $this->post("/api/v1/providers/example_provider/consumers", [
            'id' => 'example_consumer',
            'name' => 'consumer',
            'description' => 'An example of consumer',
            'definition' => $definition,
            'owner' => 'rpopuc',
            'tags' => 'example',
            'provider_id' => 'example_provider',
        ]);


        $response->assertStatus(201);

        // dump("newman run --env-var 'url=http://localhost:4010' http://app/api/v1/providers/example_provider/consumers/example_consumer.json");
    }
}
