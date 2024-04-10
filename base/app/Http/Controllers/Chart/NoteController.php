<?php

namespace App\Http\Controllers\Chart;

use App\Models\Note;
use App\Models\NoteAddition;
use App\Models\NoteAttachment;
use App\Models\Patient;

use App\Http\Controllers\Controller;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $req) {
        $patient = Patient::find($req->id);
        $notes = Note::where('patient', $req->id)->get();

        $note_ids = $notes->pluck('id');
        $attachments = NoteAttachment::whereIn('note', $note_ids)->get();

        return view('chart.notes.index')->with("patient", $patient)->with("notes", $notes)
            ->with("attachments", $attachments);
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

        if ($req->hasFile('attachments')) {
            foreach ($req->file('attachments') as $file) {
                $filename = Storage::disk('private')->put("note_attachments", $file);
                // File will be accessible via Route system at /storage/$filename
                // $filename includes the path (note_attachments/)

                $filepath = "$filename";
                $origname = $file->getClientOriginalName();

                NoteAttachment::create([
                    'note' => $note->id,
                    'name' => $origname,
                    'filepath' => $filepath,
                ]);
            }
        }

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
    public function view_attachment(Request $req)
    {
        if(is_null($req->filename))
            abort(404);

        $path = storage_path('app/private/note_attachments/' . $req->filename);

        try {
            $file = File::get($path);
            $type = File::mimeType($path);
            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
        } catch (FileNotFoundException $exception) {
            abort(404);
        }
    }
    public function get_attachment(Request $req)
    {
        if(is_null($req->filename))
            abort(404);

        $path = storage_path('app/private/note_attachments/' . $req->filename);

        return response()->download($path);
    }
}
