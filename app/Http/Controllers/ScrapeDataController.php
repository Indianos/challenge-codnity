<?php

namespace App\Http\Controllers;

use App\Http\Resources\ScrapedDataResource;
use App\Models\ScrapedArticle;
use Illuminate\Http\Response;
use Inertia\Inertia;

class ScrapeDataController extends Controller
{
    public function index()
    {
        return Inertia::render('ScrapeList', [
            'articles' => ScrapedDataResource::collection(ScrapedArticle::withTrashed()->get()),
        ]);
    }

    public function delete(ScrapedArticle $article)
    {
        $article->delete();
        return response()->json(status: Response::HTTP_OK);
    }
}
