<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Categories;
use App\Models\Plan;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        $plans = Plan::where('is_active', true)->orderBy('sort_order')->get();

        $planArr = [];
        foreach ($plans as $plan) {

            // Check link condition
            $finalLink = ($plan->link === '-' || empty($plan->link))
                ? 'free'
                : $plan->link;

            $planArr[$plan->name] = [
                'price_item_class' => $plan->is_highlighted ? 'highlighted-box box-bg-shape' : '',
                'price' => $plan->price,
                'value' => $plan->description,
                'feature' => $plan->features,
                'cta' => $plan->cta,
                'link' => $finalLink,
            ];
        }

        $blogs = Blog::where('status', 1)
            ->when($request->tag, function ($query) use ($request) {
                $query->whereHas('tags', function ($q) use ($request) {
                    $q->where('name', 'LIKE', '%' . $request->tag . '%');
                });
            })
            ->when($request->category, function ($q) use ($request) {
                $q->where('category_id', $request->category);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        $recentBlogs = Blog::select('id', 'title', 'slug', 'image', 'created_at')
            ->where('status', 1)
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->latest()
            ->get();


        $categories = Categories::where('parent_id', 0)
            ->where('status', 1)
            ->when($request->search, function ($q) use ($request) {
                $q->where('title', 'LIKE', '%' . $request->search . '%')
                    ->orWhereHas('children', function ($q2) use ($request) {
                        $q2->where('status', 1)
                            ->where('title', 'LIKE', '%' . $request->search . '%');
                    });
            })
            ->with(['children' => function ($q) use ($request) {
                $q->where('status', 1)
                    ->when($request->search, function ($q2) use ($request) {
                        $q2->where('title', 'LIKE', '%' . $request->search . '%');
                    });
            }])
            ->limit(5)
            ->with('children.children')
            ->latest()
            ->get();

        $popularTags = Tag::where('status', 1)->get();

        return view('frontend.index', compact('planArr', 'blogs', 'recentBlogs', 'categories', 'popularTags'));
    }
}
