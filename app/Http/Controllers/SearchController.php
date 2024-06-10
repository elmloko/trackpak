<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Package;
use Response;

class SearchController extends Controller
{
    public function show(Request $request)
    {
        $data = trim($request->valor);
        $result = Package::where('CODIGO','like','%'.$data.'%')
        ->orwhere('DESTINATARIO','like','%'.$data.'%')
        ->limit(5)
        ->get();
        return response()->json([
            "estado"=>1,
            "result" => $result
        ]);
    }
}