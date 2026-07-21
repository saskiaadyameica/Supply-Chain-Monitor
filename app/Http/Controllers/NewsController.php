<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\PositiveWord;
use App\Models\NegativeWord;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword ?? 'Indonesia';
        $category = $request->category ?? 'Logistics';

        $query = "$category $keyword";

        $response = Http::withoutVerifying()->get(
            'https://gnews.io/api/v4/search',
            [
                'q' => $query,
                'lang' => 'en',
                'max' => 25,
                'sortby' => 'publishedAt',
                'apikey' => env('GNEWS_API_KEY'),
            ]
        );

        $articles = [];

        if ($response->successful()) {
            $articles = $response->json()['articles'] ?? [];
        }

        // Ambil kamus kata
        $positiveWords = PositiveWord::pluck('word')->toArray();
        $negativeWords = NegativeWord::pluck('word')->toArray();

        $totalPositive = 0;
        $totalNeutral = 0;
        $totalNegative = 0;

        foreach ($articles as &$article) {

            $positiveScore = 0;
            $negativeScore = 0;

            $text = strtolower(
                ($article['title'] ?? '') . ' ' .
                ($article['description'] ?? '')
            );

            $words = preg_split('/[^a-zA-Z]+/', $text);

            foreach ($words as $word) {

                if (in_array($word, $positiveWords)) {
                    $positiveScore++;
                }

                if (in_array($word, $negativeWords)) {
                    $negativeScore++;
                }
            }

            if ($positiveScore > $negativeScore) {

                $article['sentiment'] = 'Positive';
                $totalPositive++;

            } elseif ($negativeScore > $positiveScore) {

                $article['sentiment'] = 'Negative';
                $totalNegative++;

            } else {

                $article['sentiment'] = 'Neutral';
                $totalNeutral++;
            }

            $article['positive_score'] = $positiveScore;
            $article['negative_score'] = $negativeScore;
        }

        unset($article);

        $totalArticles = count($articles);

        $positivePercent = $totalArticles
            ? round(($totalPositive / $totalArticles) * 100)
            : 0;

        $neutralPercent = $totalArticles
            ? round(($totalNeutral / $totalArticles) * 100)
            : 0;

        $negativePercent = $totalArticles
            ? round(($totalNegative / $totalArticles) * 100)
            : 0;

        return view('news.index', compact(
            'articles',
            'keyword',
            'category',
            'positivePercent',
            'neutralPercent',
            'negativePercent'
        ));
    }
}