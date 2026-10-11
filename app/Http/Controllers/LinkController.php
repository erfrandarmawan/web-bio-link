<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LinkController extends Controller
{
    public function index(): View
    {
        $links = Auth::user()->links()->orderBy('created_at', 'desc')->get();

        return view('links.index', compact('links'));
    }

    public function create(): View
    {
        return view('links.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'url' => ['required', 'string', 'url', 'max:500'],
        ]);

        Auth::user()->links()->create($validated);

        return redirect()->route('links.index')->with('success', 'Link created successfully.');
    }

    public function edit(Link $link): View
    {
        $this->authorizeLink($link);

        return view('links.form', compact('link'));
    }

    public function update(Request $request, Link $link): RedirectResponse
    {
        $this->authorizeLink($link);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'url' => ['required', 'string', 'url', 'max:500'],
        ]);

        $link->update($validated);

        return redirect()->route('links.index')->with('success', 'Link updated successfully.');
    }

    public function destroy(Link $link): RedirectResponse
    {
        $this->authorizeLink($link);

        $link->delete();

        return redirect()->route('links.index')->with('success', 'Link deleted successfully.');
    }

    public function trackClick(int $linkId): RedirectResponse
    {
        $link = Link::findOrFail($linkId);

        $link->analytics()->create([
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->away($link->url);
    }

    private function authorizeLink(Link $link): void
    {
        if ($link->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
