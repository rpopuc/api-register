<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Wpb\String_Blade_Compiler\Facades\StringBlade;

class MockController extends Controller
{
    public function index(Request $request, string $path)
    {
        $result = $this->process($path);

        return response()->json([
            'ok' => true,
            'path' => $path,
            'data' => $result,
        ]);
    }

    public function process(string $path)
    {
        if ($path == 'category/tree') {
            $template = '{
                "name": "@faker(name)",
                "email": "@faker(email)"
            }';

            $template = '{
                "name": "{{ \Facades\Faker\Generator::name() }}",
                "email": "{{ \Facades\Faker\Generator::email() }}"
            }';

            return json_decode((string) view(['template' => $template], []));
        }
    }

    private function processTemplate(string $template)
    {

    }
}
