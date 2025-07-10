<?php

namespace App\Http\Controllers;

use App\Models\Blockchain;

class BlockchainController extends Controller
{
    public function index()
    {
        $blocks = Blockchain::orderBy('id')->get();
        $valid = Blockchain::isValidChain($blocks);

        return view('admin.blockchain.index', compact('blocks', 'valid'));
    }
}

