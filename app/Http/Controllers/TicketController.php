<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Category;
use App\Models\File;
use App\Models\Priority;
use App\Models\Ticket;
use App\Services\UploadImage;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($categoryName = null)
    {
        return TicketResource::collection(
            Ticket::with(['priority', 'status', 'user'])
                    ->withFilters()
                    ->withCategory(Category::where('name', $categoryName)->first())
                    ->latest()
                    ->paginate(10)
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketRequest $request, Category $category)
    {
        $validated = $request->validated();
        
        $ticket = Ticket::create([
            'title' => $validated['title'],
            'descr' => $validated['descr'],
            'priority_id' => $validated['priority_id'],
            'user_id' => auth()->id(),
            'status_id' => 1,
            'category_id' => $category->id,
        ]);

        foreach ($validated['files'] as $key=>$file) {
            $filename = $file->store('files');
            File::create([
                'ticket_id' => $ticket->id,
                'filename' => $filename
            ]);
        }
        return response()->json($ticket, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        if($ticket->user_id != auth()->id())
        {
            abort(403);
        }

        $ticket->delete();
        return response()->json(null, 204);
    }
}
