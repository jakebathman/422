<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class Test422Controller extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json([
            'message' => 'This is a test',
        ], 422);
    }
}
