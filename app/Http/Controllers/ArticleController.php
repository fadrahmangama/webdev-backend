<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ArticleController extends Controller
{
    public function getAllArticle()
    {
        try {
            $article = Article::orderBy('id', 'asc')->get();
            return response()->json([
                'status' => true,
                'message' => 'All article found',
                'data' => $article,
            ],200);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'failed to get All Article',
                'error' => $e->getMessage(),
            ],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'project_title' => 'required',
        'category' => 'required',
        'description' => 'required',
        'image' => 'required|image',
    ]);

    try {
        // Membuat instance Article baru
        $article = new Article();
        $article->project_title = $request->project_title;
        $article->category = $request->category;
        $article->description = $request->description;

        // Menyimpan gambar dan mendapatkan path
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('images', 'public');
            $article->image = asset('storage/' . $image_path);
        }

        // Menyimpan Article ke database
        $article->save();

        // Mengembalikan respon sukses dengan URL gambar
        return response()->json([
            'status' => true,
            'message' => 'Article successfully created',
            'data' => $article,
            //     'image_url' => asset('storage/' . $image_path),
            // ],
        ], 200);
    } catch (\Throwable $e) {
        // Mengembalikan respon gagal
        return response()->json([
            'status' => false,
            'message' => 'Failed to create Article',
            'error' => $e->getMessage(),
        ], 500);
    }
}

    public function updateArticle(Request $request, $id)
    {
        try {
            // Membuat instance Article baru
            $article = Article::find($id);
            $article->project_title = $request->project_title;
            $article->category = $request->category;
            $article->description = $request->description;
    
            // Menyimpan gambar dan mendapatkan path
            if ($request->hasFile('image')) {
                $image_path = $request->file('image')->store('images', 'public');
                $article->image = asset('storage/' . $image_path);
            }
    
            // Menyimpan Article ke database
            $article->save();
    
            // Mengembalikan respon sukses dengan URL gambar
            return response()->json([
                'status' => true,
                'message' => 'Article successfully created',
                'data' => $article,
                //     'image_url' => asset('storage/' . $image_path),
                // ],
            ], 200);
        } catch (\Throwable $e) {
            // Mengembalikan respon gagal
            return response()->json([
                'status' => false,
                'message' => 'Failed to create Article',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public static function deleteArticle(string $id)
    {
        try {
            $article = Article::findorFail($id);
            $article->delete();
            return response()->json([
                'status' => true,
                'message' => 'article deleted'
            ], 200);
        } catch (\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => 'delete article failed',
                'error' => $th->getMessage()], 500);
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
        $article->delete();
    }
}
