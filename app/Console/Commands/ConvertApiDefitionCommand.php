<?php

namespace App\Console\Commands;

use App\Support\OpenApiSpecification;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Filesystem\Filesystem;

class ConvertApiDefitionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:convert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $api = new OpenApiSpecification;
        $api->loadFromFile('qualquer um');

        dd($api->findRoute('put', '/user/{username}'));
    }
}
