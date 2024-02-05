<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Campaign;
use App\Donation;
use App\Report;
use App\User;
use App\Mail\GeneralMail;
use Auth;
use Datatables;
use Mail;
use Validator;

class CampaignReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);

        if (!$campaign) return view('errors.404');

        return view('admin.report.index', compact('campaign'));
    }

    public function campaignReportData(Request $request, $campaign_id)
    {
        $query = Report::where('campaign_id', $campaign_id)->with('user');

        return Datatables::of($query)
                            ->addColumn('action', function($item) {
                                $temp = "<span data-toggle='tooltip' title='Lihat Konten'>
                                    <a href='#showContent' role='button' class='btn btn-xs btn-primary report-body' data-body='".htmlentities($item->body)."'><i class='icon fa fa-eye'></i></a>
                                </span>";
                                if ($item->pdf_url) {
                                    $temp .= "<span data-toggle='tooltip' title='Lihat PDF'>
                                        <a href=".url('report-pdf/'.$item->id)." target='_blank' role='button' class='btn btn-xs btn-primary'><i class='icon fa fa-file-text'></i></a>
                                    </span>";
                                }
                                if ($item->status == 'Draft') {
                                    $temp .= "<span data-toggle='tooltip' title='Edit Laporan'>
                                        <a href=".route('campaign.report.edit', [$item->campaign_id, $item->id])." role='button' class='btn btn-xs btn-primary'><i class='icon fa fa-pencil'></i></a>
                                    </span>";
                                }
                                return $temp;
                            })
                            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);

        if (!$campaign) return view('errors.404');

        return view('admin.report.create', compact('campaign'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $campaign_id)
    {
        $validator = Validator::make($request->all(), [
            'body' => 'required',
            'pdf' => 'file',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $campaign = Campaign::find($campaign_id);
        if (!$campaign) return view('errors.404');

        $pdf_url = null;
        if ($request->has('pdf')) {
            if ($request->file('pdf')->isValid()) {
                $pdf_url = $request->file('pdf')->store('report-pdf');
            }
        }

        $report = Report::create([
            'user_id' => Auth::user()->id,
            'campaign_id' => $campaign_id,
            'body' => $request->input('body'),
            'pdf_url' => $pdf_url,
            'status' => $request->input('status')
        ]);

        $success_message = 'Draft laporan berhasil disimpan.';
        if ($request->input('status') == 'Published') {
            $success_message = 'Laporan berhasil dibuat dan dikirim ke para donatur.';

            $donator_ids = Donation::where('campaign_id', $campaign_id)->select('user_id')->distinct()->get();
            $donators = User::whereIn('id', $donator_ids)->get();
            Mail::to($donators)->send(new GeneralMail("Laporan Program $campaign->title", 'email.report', $report->body, [], $report->file));
        }

        return redirect()->route('campaign.report.index', $campaign_id)->with('success', $success_message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function showPDF($id)
    {
        $report = Report::find($id);
        if (!$report) return view('errors.404');

        $path = storage_path('app/'.$report->pdf_url);
        return response()->make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$path.'"'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($campaign_id, $id)
    {
        $report = Report::find($id);

        if (!$report) return view('errors.404');

        return view('admin.report.edit', compact('report'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $campaign_id, $id)
    {
        $report = Report::find($id);

        if (!$report) return view('errors.404');

        $validator = Validator::make($request->all(), [
            'body' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        if ($request->hasFile('pdf')) {
            $pdf_url = $request->file('pdf')->store('report-pdf');
            $report->pdf_url = $pdf_url;
        }

        $report->body = $request->input('body');
        $report->status = $request->input('status');
        $report->save();

        $success_message = 'Draft laporan berhasil disimpan.';
        if ($request->input('status') == 'Published') {
            $success_message = 'Laporan berhasil dibuat dan dikirim ke para donatur.';

            // Kirim email ke para donatur
        }

        return redirect()->route('campaign.report.index', $campaign_id)->with('success', $success_message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
