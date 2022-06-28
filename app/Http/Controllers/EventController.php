<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function store(CreateEventRequest $request)
    {

        $event = Event::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'location' => $request->location,
            'type' => $request->type,
            'price' => ($request->price) ?? 0,
            'status' => ($request->status) ?? 'active',
            'description' => $request->description,
            'slots' => $request->slots,
            'date' => Carbon::parse($request->date),
        ]);

        return JSON(CODE_CREATED, 'Event created successfully', new EventResource($event));
    }
}
