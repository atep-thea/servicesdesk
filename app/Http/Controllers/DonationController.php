<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donation;
use Datatables;
use DB;
use \Carbon\Carbon;

use App\Entities\InquiryDonatur;
use App\Entities\Payment;
use App\Entities\Parameter;
use App\Entities\UserAddress;
use App\Entities\LogDonatur;
use App\Entities\Campaign;

use Illuminate\Support\Facades\Redirect;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($start_date = null, $end_date = null)
    {
        if (!$start_date) $start_date = Carbon::now()->startOfMonth()->toDateString();
        if (!$end_date) $end_date = Carbon::now()->endOfDay();

        $start = Carbon::parse($start_date)->startOfDay();
        $end = Carbon::parse($end_date)->endOfDay();
        // dd($end);
        $channel_data = Donation::where('status', 'success')->whereBetween('created_at', [$start, $end])->select(DB::raw("social_channel as name, count('social_channel') as y"))->groupBy('name')->get();
        $region_data = Donation::join('users', 'donations.user_id', '=', 'users.id')->where('status', 'success')->whereBetween('donations.created_at', [$start, $end])->select(DB::raw("users.domicile as name, count('users.domicile') as y"))->groupBy('users.domicile')->get();

        return view('admin.donation.index', compact('start_date', 'end_date', 'channel_data', 'region_data'));
    }

    public function indexPending($start_date = null, $end_date = null)
    {
        if (!$start_date) $start_date = Carbon::now()->startOfMonth()->toDateString();
        if (!$end_date) $end_date = date('Y-m-d');

        return view('admin.donation.indexPending', compact('start_date', 'end_date'));
    }

    public function donationData(Request $request, $start_date, $end_date)
    {
        $start = Carbon::parse($start_date)->startOfDay();
        $end = Carbon::parse($end_date)->endOfDay();
        $query = Donation::where('donations.status', 'success')->whereBetween('donations.created_at', [$start, $end])->with('donator')->with('campaign');

        return Datatables::of($query)
                            ->editColumn('amount', function($item) {
                                return "Rp ".number_format($item->amount, 2, ',', '.');
                            })
                            ->editColumn('created_at', function($item) {
                                return date('j F Y', strtotime($item->created_at));
                            })
                            ->make(true);
    }

    public function donationDataPending(Request $request, $start_date, $end_date)
    {
        $start = Carbon::parse($start_date)->startOfDay();
        $end = Carbon::parse($end_date)->endOfDay();
        $query = Donation::where('donations.status', 'pending')->whereBetween('donations.created_at', [$start, $end])->with('donator')->with('campaign');

        return Datatables::of($query)
                            ->editColumn('amount', function($item) {
                                return "Rp ".number_format($item->amount, 2, ',', '.');
                            })
                            ->editColumn('created_at', function($item) {
                                return date('j F Y', strtotime($item->created_at));
                            })
                            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function Zains($id) {
        //dd($id);
        $endpoint ='http://dpudt.corezakat.com/api/';
        $client = new \GuzzleHttp\Client();
        $value = "ABC";

        $datetime = date("Y-m-d H:i:s");
        $date = date("Y-m-d");

        $Query          = InquiryDonatur::where('id','=',$id);
        //dd($id);
        $name           = $Query->select("name")->first()->name;
        $kode_program_dt = $Query->select("program_id")->first()->program_id;
        $Query_campaign  = Campaign::where('id','=',$kode_program_dt);
        //dd($Query_campaign);
        $name_program   = $Query_campaign->select("title")->first()->title;
        //dd($name_program);
        $kode_program   = "450";
        $nominal        = $Query->select("amount")->first()->amount;
        $phone          = $Query->select("phone_number")->first()->phone_number;
        $email          = $Query->select("email")->first()->email;
        $user_id        = $Query->select("user_id")->first()->user_id;

        $Query_user     = UserAddress::where('id','=',$user_id);
        $alamat         = $Query_user->select("domicile")->first()->domicile;

        $hp_awal = substr($phone, 0, 1);
        if ($hp_awal == "0") $phone = "62".substr($phone, 1);

        //print_r($name_program);exit;


        $response = $client->request('GET', $endpoint, ['query' => [
            'sn'  => '4d8ae51854', 
            's'   => '2',
            'ct2' => '2',
            'ct2' => '2',
            'ct6' => '101.02.001.117',
            'ct5' => $kode_program,
            'ct8' => '1',
            'ct9' => $nominal,
            'ct10' => urlencode(trim($datetime)),
            'ct11' => '1',
            'ct13' => '15',
            'ct22' => $date,
            'ct23' => $name_program,
            'ct24' => '1032016001062',
            'cm2' => $name,
            'cm6' => $alamat,
            'cm15' => $phone,
            'cm17' => $email,
            'ctq8' =>'D1143700000001',
            'ctq9' =>'1437',
            'ctq17' =>'1',
            'ctq18' =>'y',
            'cm1' =>'',
        ]]);
        //return redirect::to('/donatur-zains')->with('success', true)->with('message','Donatur Berhasil Di Daftarkan');
        //return redirect()->route('blog.index')->with('success', 'Post berjudul "'.$name.'" berhasil diubah!');
        //return redirect::to('/donatur-zains')->with('success', true)->with('message','That was great!');
        //return redirect('/blog')->with(['success' => 'Pesan Berhasil']);
        //return redirect('/donatur-zains')->with(['error' => 'Donatur : '.$name.' Gagal Di Daftarkan']);

        $content = json_decode($response->getBody());

        $desc = json_encode($content);
        $status = 'gagal';

        if(!$content->msg)
        {

            if ($content->status=='success')
            {
                $status = 'sukses';
                
                //update donatur zains (success)
                $Donatur_Update                 = InquiryDonatur::where("id",$id)->first();
                $Donatur_Update->donatur_zains          = '1';
                $Donatur_Update->save();
            }
        }
        //insert log donatur
        $Donatur = new LogDonatur;
        $Donatur->user_id           = $user_id;
        $Donatur->description       = $desc;
        $Donatur->status            = $status;
        $Donatur->save();


        //return sukses dan gagal
        if ($status =="sukses")
        {
            return redirect('/donatur-zains')->with(['success' => 'Donatur : '.$name.' Berhasil Di Daftarkan']);
        }
        else
        {
            return redirect('/donatur-zains')->with(['error' => 'Donatur : '.$name.' Gagal Di Daftarkan : '.$content->msg]);
        }

        
    }
}
