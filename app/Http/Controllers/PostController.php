<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Blogs;
use App\Models\PostView;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home(): View
    {
        // Latest post
        $blog = Blogs::query()
            ->orderBy('created_at', 'desc')
            ->limit(1)
            ->first();

        

        // If authorized - Show recommended posts based on user upvotes
        return view('home', compact(
            'blog'
        ));
    }


    /**
     * Display the specified resource.
     */
    public function show(Blogs $blog, Request $request)
    {
        if ($blog->created_at > Carbon::now()) {
            throw new NotFoundHttpException();
        }

        $next = Blogs::query()
            ->whereDate('created_at', '<=', Carbon::now())
            ->orderBy('created_at', 'desc')
            ->limit(1)
            ->first();

        $prev = Blogs::query()
            ->whereDate('created_at', '<=', Carbon::now())
            ->orderBy('created_at', 'asc')
            ->limit(1)
            ->first();

     

        return view('post.view', compact('blog', 'prev', 'next'));
    }



    public function search(Request $request)
    {
        $q = $request->get('q');

        $posts = Blogs::query()
            ->where('active', '=', true)
            ->whereDate('published_at', '<=', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%$q%")
                    ->orWhere('body', 'like', "%$q%");
            })
            ->paginate(10);

        return view('post.search', compact('posts'));
    }
}