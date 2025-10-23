<?php

namespace App\Rechten;

use App\Models\ForumPost;
use App\Models\User;

class ForumPostRechten
{
    public function update(User $user, ForumPost $post): bool
    {
        return $user->id === $post->user_id || $user->role === 'admin';
    }

    public function delete(User $user, ForumPost $post): bool
    {
        return $user->id === $post->user_id || $user->role === 'admin';
    }
}
