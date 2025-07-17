<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Catechumene;
use Illuminate\Http\Request;

class CatechumeneApiController extends Controller
{
    public function index($paroisseId, Request $request)
    {
        $query = Catechumene::where('paroisse_id', $paroisseId);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%$search%");
        }

        $catechumenes = $query->limit(30)->get();

        return response()->json($catechumenes);
    }
}
