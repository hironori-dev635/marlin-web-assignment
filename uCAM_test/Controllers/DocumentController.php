<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Documents/IndexComp', [
            'documents' => Document::all()->toArray(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:20']);
        Document::create(['name' => $request->name]);

        return redirect()->route('documents.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        $request->validate(['name' => 'required|string|max:20']);
        $document->update(['name' => $request->name]);

        return redirect()->route('documents.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
           $document->delete();
           return redirect()->route('documents.index');
    }
}
