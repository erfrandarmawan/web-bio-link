<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class UserLinkController extends Controller
{
    public function show(string $username): View
    {
        $user = User::where('username', strtolower($username))->firstOrFail();

        /** @var Collection<int, Link> $links */
        $links = $user->links()->whereNull('deleted_at');

        return view('user-link', [
            'user' => $user,
            'links' => $links->get(),
        ]);
    }
}
