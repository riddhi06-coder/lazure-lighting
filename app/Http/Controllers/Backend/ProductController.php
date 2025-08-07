<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Applications;
use App\Models\Category;


class ProductController extends Controller
{

    public function index()
    {
        return view('backend.product.products.index');
    }

    public function create(Request $request)
    {
        $applications = Applications::whereNull('deleted_by')->get();
        $categories = Category::whereNull('deleted_by')->get(); // Fetch existing categories

        return view('backend.product.products.create', compact('applications', 'categories'));
    }

    public function getCategoriesByApplication($applicationId)
    {
        $categories = Category::where('application_id', $applicationId)
            ->whereNull('deleted_by')
            ->get();

        return response()->json($categories);
    }

}