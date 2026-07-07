<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Categories;
use App\Models\ForexUpdate;
use App\Models\Plan;
use App\Models\Tag;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                'discount_price' => $plan->discount_price,
                'type' => $plan->type,
                'value' => $plan->description,
                'feature' => $plan->features,
                'remove' => $plan->remove,
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
            ->paginate(getConfigurationField('SEE_MORE_BLOGS'));

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

        $signals = ForexUpdate::where('status', 1)
            ->orderBy('signal_date', 'DESC')
            ->latest()
            ->limit(15)
            ->get();

        return view('frontend.index', compact('planArr', 'blogs', 'recentBlogs', 'signals', 'categories', 'popularTags'));
    }

    /**
     *
     */
    public function setSqlStatement()
    {
        $sqlArr = [
            "ALTER TABLE `plans` ADD `type` VARCHAR(25) NULL DEFAULT NULL AFTER `price`;",
            "ALTER TABLE `blogs` ADD `meta_title` VARCHAR(100) NOT NULL AFTER `short_description`, ADD `meta_description` TEXT NOT NULL AFTER `meta_title`, ADD `h1_tag` VARCHAR(100) NOT NULL AFTER `meta_description`;",
            "ALTER TABLE `pricing_plan_checkout` ADD `payment_type` VARCHAR(50) NOT NULL AFTER `payment_option`;",
            "ALTER TABLE `plans` ADD `excludes` JSON NULL DEFAULT NULL AFTER `features`;",
        ];

        foreach ($sqlArr as $sql) {
            try {
                DB::statement($sql);
                echo "Executed: $sql<br>";
            } catch (Exception $e) {
                echo "Skipped (error): $sql<br>";
            }
        }
    }

    /**
     *
     */
    public function getSelectedChannelSignals(){

    return true;

        $getLastSignal = ForexUpdate::orderBy('post_id', 'desc')->select('post_id')->first();

        try {
            $signals = scrapeTelegramSignals('Wealthoraofficial', $getLastSignal->post_id ?? null ); // today + yesterday
            return response()->json([
                'status' => true,
                'message' => 'Signals fetched successfully.',
                'data' => $signals,
                'total_signals' => count($signals)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data' => [],
                'total_signals' => 0
            ]);
        }
    }
}
