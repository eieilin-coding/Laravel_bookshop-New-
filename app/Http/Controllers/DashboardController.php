<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //  public function index()
    // {
    //     // Bar Chart: Top 8 books by download count
    //     $topBooks = Book::select('title', 'download_count')
    //         ->orderByDesc('download_count')
    //         ->limit(8)
    //         ->get();

    //     // Pie Chart: Top 5 categories by total downloads
    //     $topCategories = Book::select('category_id', DB::raw('SUM(download_count) as total_downloads'))
    //         ->groupBy('category_id')
    //         ->orderByDesc('total_downloads')
    //         ->limit(5)
    //         ->with('category') // eager load
    //         ->get();

    //     return view('admin.dashboard', compact('topBooks', 'topCategories'));
    // }

    public function index()
    {
        // Get top 8 books by download count
        $topBooks = Book::orderBy('download_count', 'DESC')
                        ->limit(7)
                        ->get();
        
        // Get top 5 categories by total downloads
        $topCategories = Category::withSum('books', 'download_count')
                                ->orderBy('books_sum_download_count', 'DESC')
                                ->limit(5)
                                ->get();
        
        return view('admin/dashboard', compact('topBooks', 'topCategories'));
    }
}
