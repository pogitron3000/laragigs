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
            'listings' => Listings::latest()->filter(request(['tag', 'search']))->paginate(6)
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

        $formFields['user_id'] = auth()->id();

        Listings::create($formFields);
        return redirect('/')->with('message', 'The listing successfully created');
    }

    public function edit(Listings $listing) {

        if($listing->user_id !== auth()->id()) {
            abort(404, 'Unauthorized Action');
        }

        return view('listings.edit', ['listing' => $listing]);
    }

    public function update(Request $request, Listings $listing)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'tags' => 'required',
            'website' => 'required',
            'email' => 'required',
            'description' => 'required',
        ]);
        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);
        return redirect('/')->with('message', 'The listing successfully updated');
    }

    public function destroy(Listings $listing) {

        if($listing->user_id !== auth()->id()) {
            abort(404, 'Unauthorized Action');
        }

        $listing->delete();
        return redirect('/')->with('message', 'The listing successfully deleted');
    }

    public function manage() {
        return view('listings.manage', [
            'listings' => auth()->user()->listings()->get()
        ]);
    }
}
