<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\TypeMesse;
use Illuminate\Http\Request;

class TypeMesseApiController extends Controller
{
    //
    public function TypeMesseParParoisse($paroisseId)
{
    $types = TypeMesse::where('paroisse_id', $paroisseId)->get();

    return response()->json([
        'status' => true,
        'types' => $types
    ]);
}
}
