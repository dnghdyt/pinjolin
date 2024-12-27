<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $active = null;
        if (request('category')) {
            $active = request('category');
        }

        return view('pages.artikel', [
            'active' => $active,
            'latests' => Article::where('status', 'published')->latest()->take(8)->get(),
            'articles' => Article::where('status', 'published')->latest()->filter(request(['search', 'category']))->paginate(12)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('artikel.create', [
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Temukan artikel berdasarkan ID
        $article = Article::with('category')->with('user')->findOrFail($id);

        // Kirim data ke view untuk ditampilkan
        return view('artikel.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
