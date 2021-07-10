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

        $definition = $fs->get(base_path('/docs/contract-register.yaml'));

        $response = $this->post('/api/v1/providers', [
            'name' => 'example',
            'description' => 'An example',
            'definition' => $definition,
            'owner' => 'rpopuc',
            'tags' => 'example'
        ]);

        $response->assertStatus(200);

        $providerId = $response->json()['id'];


        $definition = $fs->get(base_path('/docs/consumer.json'));

        $response = $this->post("/api/v1/providers/$providerId/consumers", [
            'name' => 'consumer',
            'description' => 'An example of consumer',
            'definition' => $definition,
            'owner' => 'rpopuc',
            'tags' => 'example',
            'provider_id' => $providerId,
        ]);

        $response->assertStatus(201);

        $response->getContent();
    }
}
