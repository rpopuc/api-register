<?php

namespace App\Support;

use App\Models\Consumer;

class ConsumerTest
{
    /**
     * @var Newman
     */
    private $newman;

    public function __construct(Newman $newman)
    {
        $this->newman = $newman;
    }

    public function test(Consumer $consumer)
    {
        return [
            $consumer->id => $this->newman->run($consumer->provider->id, $consumer->id)
        ];
    }
}