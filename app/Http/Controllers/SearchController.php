<?php

namespace AppHttpControllers;
use IlluminateHttpRequest;
use Response;
use DB;
class SearchController extends Controller
{
    public function show(Request $request)
    {
        $data = trim($request->valor);
        $result = DB::table('packages')
        ->where('CODIGO','like','%'.$data.'%')
        ->orwhere('DESTINATARIO','like','%'.$data.'%')
        ->limit(5)
        ->get();
        return response()->json([
            "estado"=>1,
            "result" => $result
        ]);
    }
}