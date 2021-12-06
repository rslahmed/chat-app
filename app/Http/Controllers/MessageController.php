<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Events\NewChatMessage;
class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Messages/Index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required',
            'receiver_id' => 'required'
        ]);

        $newMessage = Message::create([
            'sender_id' => Auth::user()->id,
            'body' => $request->body,
            'receiver_id' => $request->receiver_id,
        ]);

        broadcast(new NewChatMessage($newMessage))->toOthers();
        return back();
    }

    public function show($id)
    {
        $contact = User::findOrFail($id);
        $messages = Message::with('receiver', 'sender')
            ->where('sender_id', Auth::user()->id)->where('receiver_id', $contact->id)
            ->orWhere('sender_id', $contact->id)->where('receiver_id', Auth::user()->id)->get();

        // Read messages
        $unreads = Message::where('read_at',null)->where('sender_id', $contact->id)->where('receiver_id', Auth::user()->id)->get();
        foreach ($unreads as $message){
            $message->update([
                'read_at' => Carbon::now()
            ]);
        }

        return Inertia::render('Messages/Show', [
            'messages' => $messages,
            'contact' => $contact
        ]);
    }

    public function destroy(Message $message)
    {
        //
    }
}
