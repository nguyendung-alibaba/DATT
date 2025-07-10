<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham;

class SearchController extends Controller
{
    //

public function index(Request $request) {
    $query = $request->input('query');
    $results = SanPham::where('name', 'like', "%$query%")->get();
    return view('client.search', compact('results', 'query'));
}

}
