<?php

namespace App\Http\Controllers;

use App\Models\CategorieProduit;

class CategorieProduitController extends Controller
{
    public function index()
    {
        $categories = CategorieProduit::all();
        return view('mespages.categories', compact('categories'));
    }
}
