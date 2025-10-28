<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BerichtStatusController extends Controller
{
    public function toggle(Request $request, ForumPost $post)
    {
        Gate::authorize('update', $post);        // eigenaar of admin

        $post->locked = ! $post->locked;
        $post->save();

        if ($request->wantsJson()) {
            return response()->json([
                'locked' => $post->locked,
                'message' => $post->locked ? 'Post gesloten' : 'Post heropend',
            ]);
        }

        return back()->with('success', $post->locked ? 'Post gesloten' : 'Post heropend');
    }
}
