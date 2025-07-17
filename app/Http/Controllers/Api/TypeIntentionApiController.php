<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\TypeIntention;
use Illuminate\Http\Request;

class TypeIntentionApiController extends Controller
{
    //
    public function TypeIntentionParParoisse($paroisseId)
{
    $types = TypeIntention::where('paroisse_id', $paroisseId)->get();

    return response()->json([
        'status' => true,
        'types' => $types
    ]);
}
}
