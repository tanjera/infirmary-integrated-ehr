<?php

namespace App\Http\Controllers\Chart;

use App\Models\Note;
use App\Models\NoteAddition;
use App\Models\NoteAttachment;
use App\Models\Patient;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $req) {
        $patient = Patient::find($req->id);
        $notes = Note::where('patient', $req->id)->get();

        return view('chart.notes.index')->with("patient", $patient)->with("notes", $notes);
    }
    public function view(Request $req) {
        $note = Note::find($req->id);
        $additions = NoteAddition::where('note', $note->id)->get();
        $attachments = NoteAttachment::where('note', $note->id)->get();
        $patient = Patient::find($note->patient);

        return view('chart.notes.view')->with("patient", $patient)->with("note", $note)
            ->with("additions", $additions)->with("attachments", $attachments);
    }
    public function create(Request $req){
        if (!Auth::user()->canChart())
            abort(403);

        $patient = Patient::find($req->id);

        return view('chart.notes.create')->with("patient", $patient);
    }
    public function add(Request $req){
        if (!Auth::user()->canChart())
            abort(403);

        $validated = $req->validate([
            'category' => 'required',
            'body' => 'required',
        ]);

        $note = Note::create([
            'patient' => $req->id,
            'author' => Auth::user()->name,
            'category' => $req->category,
            'body' => $req->body,
        ]);

        $category = Note::$category_text[array_search($req->category, Note::$category_index)];

        return redirect("chart/notes/$req->id")->with('message', "$category created successfully.");
    }
    public function append(Request $req){
        if (!Auth::user()->canChart())
            abort(403);

        $note = Note::find($req->id);
        $patient = Patient::find($note->patient);

        return view('chart.notes.append')->with("patient", $patient)->with("note", $note);
    }
    public function affix(Request $req){
        if (!Auth::user()->canChart())
            abort(403);

        $note = Note::find($req->id);
        $patient = Patient::find($note->patient);

        $validated = $req->validate([
            'body' => 'required',
        ]);

        NoteAddition::create([
            'note' => $req->id,
            'author' => Auth::user()->name,
            'body' => $req->body,
        ]);

        return redirect("chart/notes/view/$req->id")->with('message', "Addition saved successfully!");
    }
    public function delete(Request $req){
        $note = Note::find($req->id);
        $additions = NoteAddition::where('note', $note->id)->get();
        $attachments = NoteAttachment::where('note', $note->id)->get();

        $patient = $note->patient;
        $category = Note::$category_text[array_search($req->category, Note::$category_index)];

        $note->delete();

        foreach ($additions as $addition)
            $addition->delete();

        foreach ($attachments as $attachment)
            $attachment->delete();

        return redirect("/chart/notes/$patient")->with('message', "$category deleted successfully!");
    }
}
