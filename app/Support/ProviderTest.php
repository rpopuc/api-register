<?php

namespace App\Support;

use App\Models\Consumer;
use App\Models\Provider;
use App\Support\ConsumerTest;

class ProviderTest
{
    /**
     * @var ConsumerTest
     */
    private $consumerTest;

    public function __construct(ConsumerTest $consumerTest)
    {
        $this->consumerTest = $consumerTest;
    }

    public function test(Provider $provider)
    {
        foreach ($provider->consumers as $consumer) {
            $summaries = array_merge(
                $summaries ?? [],
                $this->consumerTest->test($provider, $consumer)
            );
        }

        return $summaries ?? [];
    }
}