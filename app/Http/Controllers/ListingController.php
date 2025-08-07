<?php

namespace App\Http\Controllers;

use App\Http\Middleware\NotSuspended;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ListingController extends Controller implements HasMiddleware
{

    /**
     * @inheritDoc
     */
    public static function middleware(): array
    {
        return [
            new Middleware(
                [
                    'auth',
                    'verified',
                    NotSuspended::class,
                ],
                except: [
                    'index',
                    'show',
                ],
            ),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $listings = Listing::query()
            ->withActiveUser()
            ->where('approved', true)
            ->filter(request(['search', 'user_id', 'tag']))
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return Inertia::render('Home', [
            'listings' => $listings,
            'searchTerm' => request('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Listing::class);

        return Inertia::render('Listing/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Listing::class);

        $fields = $request->validate([
            'title' => [
                'required',
                'max:255',
            ],
            'desc' => [
                'required',
            ],
            'tags' => [
                'nullable',
                'string',
            ],
            'email' => [
                'nullable',
                'email',
            ],
            'link' => [
                'nullable',
                'url',
            ],
            'image' => [
                'nullable',
                'file',
                'max:3072',
                'mimes:jpeg, jpg, png, webp',
            ],
        ]);

        if ($fields['tags']) {
            $fields['tags'] = collect($fields['tags'])
                ->flatMap(fn($tag) => explode(',', $tag))
                ->map(fn($tag) => trim($tag))
                ->filter()
                ->unique()
                ->implode(',');
        }

        if ($request->hasFile('image')) {
            $fields['image'] = Storage::disk('public')->put('images/listing', $request->image);
        }

        $request->user()->listings()->create($fields);

        return redirect()->route('dashboard')->with('status', 'Listing created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        Gate::authorize('view', $listing);

        return Inertia::render('Listing/Show', [
            'listing' => $listing,
            'user' => $listing->user->only(['name', 'id']),
            'canModify' => Auth::user()?->can('modify', $listing) ?? false,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        Gate::authorize('modify', $listing);

        return Inertia::render('Listing/Edit', [
            'listing' => $listing,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        Gate::authorize('modify', $listing);

        $fields = $request->validate([
            'title' => [
                'required',
                'max:255',
            ],
            'desc' => [
                'required',
            ],
            'tags' => [
                'nullable',
                'string',
            ],
            'email' => [
                'nullable',
                'email',
            ],
            'link' => [
                'nullable',
                'url',
            ],
            'image' => [
                'nullable',
                'file',
                'max:3072',
                'mimes:jpeg,jpg,png,webp',
            ],
        ]);

        if ($fields['tags']) {
            $fields['tags'] = collect($fields['tags'])
                ->flatMap(fn($tag) => explode(',', $tag))
                ->map(fn($tag) => trim($tag))
                ->filter()
                ->unique()
                ->implode(',');
        }

        if ($request->hasFile('image')) {
            if ($listing->image) {
                Storage::disk('public')->delete($listing->image);
            }

            $fields['image'] = Storage::disk('public')->put('images/listing', $request->image);
        } else {
            $fields['image'] = $listing->image;
        }

        $listing->update([...$fields, 'approved' => false]);

        return redirect()->route('dashboard')->with('status', 'Listing updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        Gate::authorize('modify', $listing);

        if ($listing->image) {
            Storage::disk('public')->delete($listing->image);
        }

        $listing->delete();
        return redirect()->route('dashboard')->with('status', 'Listing deleted successfully!');
    }
}
