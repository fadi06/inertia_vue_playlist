<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Listing;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\NotSuspended;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Gate;

class ListingController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware([
                'auth', 'verified', NotSuspended::class
            ])->except(['index', 'show']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listings = Listing::query()
            ->whereHas('user', fn ($q) => $q->where('role', '!=', 'suspended'))
            ->with('user')
            ->approved()
            ->filters(request(['search', 'user_id', 'tag']))
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return Inertia::render("Home", [
            "listings"=> $listings,
            'searchTerm' => request('search'),
            'status' => session('status'),
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
    public function store(StoreListingRequest $request)
    {
        Gate::authorize('create', Listing::class);
        $fileds = $request->validated();
        if ($request->hasFile('image')) {
            $fileds['image'] = Storage::disk('public')->put('images/listings', $request->file('image'));
        }

        $fileds['tags'] = implode(',', array_unique(array_filter(array_map('trim', (explode(',', $fileds['tags']))))));

        $request->user()->listings()->create($fileds);

        return redirect()->route('home')->with('status','Listing created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        Gate::authorize('view', $listing);

        return Inertia::render('Listing/Show', [
            'listing' => $listing->load('user'),
            'canModify' => Auth::check() ? Auth::user()->can('modify', $listing) : false
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        Gate::authorize('modify', $listing);

        return Inertia::render('Listing/Edit', [
            'listing' => $listing->load('user')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateListingRequest $request, Listing $listing)
    {
        Gate::authorize('view', $listing);

        $fileds = $request->validated();
        if ($request->hasFile('image')) {
            if ($listing->image) {
                Storage::disk('public')->delete($listing->image);
            }
            $fileds['image'] = Storage::disk('public')->put('images/listings', $request->file('image'));
        } else {
            $fileds['image'] = $listing->image;
        }

        $fileds['tags'] = implode(',', array_unique(array_filter(array_map('trim', (explode(',', $fileds['tags']))))));

        $listing->update($fileds);

        return redirect()->route('home')->with('status','Listing updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        Gate::authorize('view', $listing);

        if($listing->image) {
            Storage::disk('public')->delete($listing->image);
        }
        $listing->delete();

        return redirect()->route('home')->with('status','Listing deleted successfully');
    }
}
