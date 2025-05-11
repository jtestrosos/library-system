<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function index()
    {
        $publishers = Publisher::paginate(5); // Matches the 5 items per page in the screenshot
        return view('publisher.index', compact('publishers'));
    }

    public function create()
    {
        return view('publisher.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Publisher::create($request->all());
        return redirect()->route('publishers.index')->with('success', 'Publisher added successfully');
    }

    public function edit($id)
    {
        $publisher = Publisher::findOrFail($id);
        return view('publisher.edit', compact('publisher'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $publisher = Publisher::findOrFail($id);
        $publisher->update($request->all());
        return redirect()->route('publishers.index')->with('success', 'Publisher updated successfully');
    }

    public function destroy($id)
    {
        $publisher = Publisher::findOrFail($id);
        $publisher->delete();
        return redirect()->route('publishers.index')->with('success', 'Publisher deleted successfully');
    }
}