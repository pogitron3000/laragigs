<?php

namespace App\Http\Controllers;

use App\Models\Listings;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingsController extends Controller
{
    public function index()
    {
        return view('listings.index', [
            'listings' => Listings::latest()->filter(request(['tag', 'search']))->get()
        ]);
    }

    public function show(Listings $listing)
    {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    public function create()
    {
        return view('listings.create');
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'tags' => 'required',
            'website' => 'required',
            'email' => 'required',
            'description' => 'required',
        ]);
        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('public', 'logos');
        }

        Listings::create($formFields);
        return redirect('/')->with('message', 'The listing successfully created');
    }
}
