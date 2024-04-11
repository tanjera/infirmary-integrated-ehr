<?php

namespace App\Http\Controllers\Chart;

use App\Models\DiagnosticReport;
use App\Models\DiagnosticAttachment;
use App\Models\DiagnosticAddition;
use App\Models\Patient;

use App\Http\Controllers\Controller;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DiagnosticsController extends Controller
{
    public function index(Request $req) {
        $patient = Patient::find($req->id);
        $reports = DiagnosticReport::where('patient', $req->id)->get();

        $report_ids = $reports->pluck('id');
        $attachments = DiagnosticAttachment::whereIn('report', $report_ids)->get();

        return view('chart.diagnostics.index')->with("patient", $patient)->with("reports", $reports)
            ->with("attachments", $attachments);
    }
    public function view(Request $req) {
        $report = DiagnosticReport::find($req->id);
        $additions = DiagnosticAddition::where('report', $report->id)->get();
        $attachments = DiagnosticAttachment::where('report', $report->id)->get();
        $patient = Patient::find($report->patient);

        return view('chart.diagnostics.view')->with("patient", $patient)->with("report", $report)
            ->with("additions", $additions)->with("attachments", $attachments);
    }
    public function create(Request $req){
        if (!Auth::user()->canChart())
            abort(403);

        $patient = Patient::find($req->id);

        return view('chart.diagnostics.create')->with("patient", $patient);
    }
    public function add(Request $req){
        if (!Auth::user()->canChart())
            abort(403);

        $validated = $req->validate([
            'category' => 'required',
            'attachments.*' => 'max:49152',
        ]);

        $report = DiagnosticReport::create([
            'patient' => $req->id,
            'author' => Auth::user()->name,
            'category' => $req->category,
            'body' => $req->body,
        ]);

        if ($req->hasFile('attachments')) {
            foreach ($req->file('attachments') as $file) {
                $filename = Storage::disk('private')->put("diagnostic_attachments", $file);
                // File will be accessible via Route system at /storage/$filename
                // $filename includes the path (diagnostic_attachments/)

                $filepath = "$filename";
                $origname = $file->getClientOriginalName();
                $mimetype = $file->getClientMimeType();

                DiagnosticAttachment::create([
                    'report' => $report->id,
                    'name' => $origname,
                    'mimetype' => $mimetype,
                    'filepath' => $filepath,
                ]);
            }
        }

        $category = DiagnosticReport::$category_text[array_search($req->category, DiagnosticReport::$category_index)];

        return redirect("chart/diagnostics/$req->id")->with('message', "$category created successfully.");
    }
    public function append(Request $req){
        if (!Auth::user()->canChart())
            abort(403);

        $report = DiagnosticReport::find($req->id);
        $patient = Patient::find($report->patient);

        return view('chart.diagnostics.append')->with("patient", $patient)->with("report", $report);
    }
    public function affix(Request $req){
        if (!Auth::user()->canChart())
            abort(403);

        $report = DiagnosticReport::find($req->id);
        $patient = Patient::find($report->patient);

        DiagnosticAddition::create([
            'report' => $req->id,
            'author' => Auth::user()->name,
            'body' => $req->body,
        ]);

        return redirect("chart/diagnostics/view/$req->id")->with('message', "Addition saved successfully!");
    }
    public function delete(Request $req){
        $report = DiagnosticReport::find($req->id);
        $additions = DiagnosticAddition::where('report', $report->id)->get();
        $attachments = DiagnosticAttachment::where('report', $report->id)->get();

        $patient = $report->patient;
        $category = DiagnosticReport::$category_text[array_search($req->category, DiagnosticReport::$category_index)];

        $report->delete();

        foreach ($additions as $addition)
            $addition->delete();

        foreach ($attachments as $attachment) {
            $path = storage_path('app/private/' . $attachment->filepath);
            $file = File::delete($path);

            $attachment->delete();
        }

        return redirect("/chart/diagnostics/$patient")->with('message', "$category deleted successfully!");
    }
    public function view_attachment(Request $req)
    {
        if(is_null($req->filename))
            abort(404);

        $path = storage_path('app/private/diagnostic_attachments/' . $req->filename);

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

        $path = storage_path('app/private/diagnostic_attachments/' . $req->filename);

        return response()->download($path);
    }
}
