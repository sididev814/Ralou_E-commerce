<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\CategorieProduit;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::all();
        return view('mespages.produits', compact('produits'));
    }

    public function detail($id)
    {
        $produit = Produit::findOrFail($id);
        return view('mespages.detail', compact('produit'));
    }

    public function adminIndex()
    {
        $produits = Produit::with('categorie')->orderBy('created_at', 'desc')->paginate(4);
        return view('admin.produits.index', compact('produits'));
    }

    public function create()
    {
        $categories = CategorieProduit::all();
        return view('admin.produits.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'categorie_produit_id' => 'required|exists:categorie_produits,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $produit = new Produit($request->only(['nom', 'prix', 'description', 'stock', 'categorie_produit_id']));

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename = $originalName . '_' . time() . '.' . $extension;

            $path = $file->storeAs('produits', $filename, 'public');
            $produit->image = $path;
        }

        $produit->save();

        return redirect()->route('admin.produits.index')->with('success', 'Produit ajouté avec succès.');
    }

    public function edit($id)
    {
        $produit = Produit::findOrFail($id);
        $categories = CategorieProduit::all();

        return view('admin.produits.edit', compact('produit', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);

        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'categorie_produit_id' => 'required|exists:categorie_produits,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $produit->fill($request->only(['nom', 'prix', 'description', 'stock', 'categorie_produit_id']));

        if ($request->hasFile('image')) {
            if ($produit->image) {
                Storage::disk('public')->delete($produit->image);
            }

            $file = $request->file('image');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename = $originalName . '_' . time() . '.' . $extension;

            $path = $file->storeAs('produits', $filename, 'public');
            $produit->image = $path;
        }

        $produit->save();

        return redirect()->route('admin.produits.index')->with('success', 'Produit mis à jour.');
    }

    public function destroy($id)
    {
        $produit = Produit::findOrFail($id);

        if ($produit->image) {
            Storage::disk('public')->delete($produit->image);
        }

        $produit->delete();

        return redirect()->route('admin.produits.index')->with('success', 'Produit supprimé.');
    }
}
