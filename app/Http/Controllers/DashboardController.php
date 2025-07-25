<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count(); // Get total number of books
        $totalUsers = User::count();
        $totalCategories = Category::count();
        $totalDownload = Book::sum('download_count');
        
        // Get top 8 books by download count
        $topBooks = Book::orderBy('download_count', 'DESC')
            ->limit(7)
            ->get();

        // Get top 5 categories by total downloads
        $topCategories = Category::withSum('books', 'download_count')
            ->orderBy('books_sum_download_count', 'DESC')
            ->limit(5)
            ->get();

        return view('admin/dashboard', compact('topBooks', 'topCategories',
         'totalBooks', 'totalDownload', 'totalUsers', 'totalCategories'));
    }
}
