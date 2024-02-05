<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Campaign;
use App\User;
use Datatables;
use DB;
use Image;
use File;
use Validator;
use Mailgun\Mailgun;
use \Carbon\Carbon;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth');
    }

    public function index($start_date = null, $end_date = null)
    {
        $user = Auth::user()->id;
        if (!$start_date) $start_date = Carbon::now()->startOfMonth()->toDateString();
        if (!$end_date) $end_date = date('Y-m-d');
        if (!$user) return view('vendor.adminlte.errors.404');
        
        $campaigns = Campaign::where('end_date', '>=', $end_date)->where('creator_id', '=',$user)->get();


        if ($campaigns->count() == 0) {
            $collected = 0;
            $target = 0;
            $percentage = 0;
        } else {
            $campaigns->transform(function($item) {
                $item['collected'] = $item->donations->sum(function($item) {
                    if ($item->status == 'success') return $item->amount;
                    return 0;
                });
                return $item;
            });
            $collected = $campaigns->sum('collected');
            $target = $campaigns->sum('target');
            $percentage = ($collected/$target)*100;
        }

        $bar_data = $campaigns->map(function($item) {
            $temp = [
                'name' => $item->title,
                'y' => round(($item->collected/$item->target)*100, 2)
            ];
            return $temp;
        });

        return view('admin.campaign.index', compact('start_date', 'end_date', 'collected', 'percentage', 'bar_data'));
    }

    public function campaignData(Request $request)
    {
        $user = Auth::user()->id;
        //dd(Auth::user()->id);
        if(Auth::user()->hasRole('admin'))
        {
            $query = Campaign::query();
            return Datatables::of($query)
                            ->editColumn('featured', function($item) {
                                $class = $item->featured ? 'icon fa fa-check text-success' : 'icon fa fa-times text-danger';
                                $temp = "<i class='".$class."'></i>";
                                return $temp;
                            })
                            ->editColumn('banner_featured', function($item) {
                                $class = $item->banner_featured ? 'icon fa fa-check text-success' : 'icon fa fa-times text-danger';
                                $temp = "<i class='".$class."'></i>";
                                return $temp;
                            })
                            ->editColumn('target', function($item) {
                                return "Rp ".number_format($item->target, 2, ',', '.');
                            })
                            ->addColumn('periods', function($item) {
                                return date('j F Y', strtotime($item->start_date))." - ".date('j F Y', strtotime($item->end_date));
                            })
                            ->addColumn('collected', function($item) {
                                $collected = $item->donations->sum(function($item) {
                                    if ($item->status == 'success') return $item->amount;
                                     return 0;
                                });
                                return "Rp ".number_format($collected, 2, ',', '.');
                            })
                            ->addColumn('action', function($item) {
                                $temp = "<span data-toggle='tooltip' title='Laporan Campaign'>
                                <a href=".route('campaign.report.index', $item->id)." role='button' class='btn btn-xs btn-primary'><i class='icon fa fa-file-text'></i></a></span>";

                                $temp .= "<span data-toggle='tooltip' title='Lihat Profil Relawan'>
                                <a href=".route('campaign.view.relawan', encrypt($item->creator_id))." role='button' class='btn btn-xs btn-primary'><i class='icon fa fa-user'></i></a></span>";

                                $temp .= "<span data-toggle='tooltip' title='Stat Buzzer'>
                                <a href=".route('buzzer.campaign', $item->id)." role='button' class='btn btn-xs btn-primary'><i class='icon fa fa-users'></i></a></span>";

                                $temp .= "<span data-toggle='tooltip' title='Foto Feature'>
                                <a href='#modal' role='button' data-image-url=".asset('photos/campaign/'.$item->feature_image_url)." class='btn btn-xs btn-primary image'><i class='icon fa fa-image'></i></a></span>";

                                $temp .= "<span data-toggle='tooltip' title='Edit Campaign'>
                                    <a href=".route('campaign.edit', $item->id)." role='button' class='btn btn-xs btn-primary'><i class='icon fa fa-pencil'></i></a></span>";

                                if($item->status == 'Published') {
                                    $temp .= "<span data-toggle='tooltip' title='Unpublish'>
                                    <a href=".route('campaign.unpublish', $item->id)." role='button' class='btn btn-xs btn-danger'><i class='icon fa fa-ban'></i></a></span>";
                                } else {
                                    $temp .= "<span data-toggle='tooltip' title='Publish'>
                                        <a href=".route('campaign.publish', $item->id)." role='button' class='btn btn-xs btn-primary'><i class='icon fa fa-bullhorn'></i></a></span>";
                                }
                                $temp .= "<span data-toggle='tooltip' title='Hapus Campaign'>
                                <a href='#delete' role='button' data-delete-url=".route('campaign.destroy', $item->id)." class='btn btn-xs btn-danger delete'><i class='icon fa fa-trash'></i></a></span>";

                                return $temp;
                            })
                            ->make(true);
        }
        else
        {
            $query = Campaign::query()
            ->where('creator_id', '=',$user);
            return Datatables::of($query)
                            ->editColumn('featured', function($item) {
                                $class = $item->featured ? 'icon fa fa-check text-success' : 'icon fa fa-times text-danger';
                                $temp = "<i class='".$class."'></i>";
                                return $temp;
                            })
                            ->editColumn('banner_featured', function($item) {
                                $class = $item->banner_featured ? 'icon fa fa-check text-success' : 'icon fa fa-times text-danger';
                                $temp = "<i class='".$class."'></i>";
                                return $temp;
                            })
                            ->editColumn('target', function($item) {
                                return "Rp ".number_format($item->target, 2, ',', '.');
                            })
                            ->addColumn('periods', function($item) {
                                return date('j F Y', strtotime($item->start_date))." - ".date('j F Y', strtotime($item->end_date));
                            })
                            ->addColumn('collected', function($item) {
                                $collected = $item->donations->sum(function($item) {
                                    if ($item->status == 'success') return $item->amount;
                                     return 0;
                                });
                                return "Rp ".number_format($collected, 2, ',', '.');
                            })
                            ->addColumn('action', function($item) {
                                $temp = "<span data-toggle='tooltip' title='Edit Campaign'>
                                    <a href=".route('campaign.edit', encrypt($item->id))." role='button' class='btn btn-xs btn-primary'><i class='icon fa fa-pencil'></i></a></span>";



                                return $temp;
                            })
                            ->make(true);
        }
        

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        if(Auth::user()->hasRole('admin'))
        {
        return view('admin.campaign.create');
        }
        else
        {
            if (!$user['domicile'])
            {
                return redirect()->back()->with('failed', 'Silahkan Lengkapi data Kota');
            }

            if (!$user['address'])
            {
                return redirect()->back()->with('failed', 'Silahkan Lengkapi data Alamat');
            }

            if (!$user['place_of_birth'])
            {
                return redirect()->back()->with('failed', 'Silahkan Lengkapi data Tempat Lahir');
            }

            if (!$user['date_of_birth'])
            {
                return redirect()->back()->with('failed', 'Silahkan Lengkapi data Tanggal Lahir');
            }

            if (!$user['ktp_siup'])
            {
                return redirect()->back()->with('failed', 'Silahkan Lengkapi data No KTP/Legalitas Yayasan');
            }

            if (!$user['advertiser_type'])
            {
                return redirect()->back()->with('failed', 'Silahkan Lengkapi data Perorangan/Yayasan');
            }

            if (!$user['identity_file'])
            {
                return redirect()->back()->with('failed', 'Silahkan Lengkapi data Upload KTP/Legalitas Yayasan');
            }

            return view('admin.campaign.create_relawan');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'receiver' => 'required',
            //'pengiklan' => 'required',
            //'type_pengiklan' => 'required',
            //'verifikasi' => 'required',
            'city' => 'required',
            'target' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'categories' => 'required',
            'homepage' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'posting' => 'required',
            //'publish' => 'required',
            'photo_banner' => 'required_if:banner,yes',
            'banner_description' => 'required_if:banner,yes',
            'slug' => 'required|unique:campaigns,slug'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        // Upload feature photo
        $photo = $request->file('photo');
        $extension = $photo->getClientOriginalExtension();
        $photo_real_path = $photo->getRealPath();
        $filename = str_random(5).date('Ymdhis').'.'.$extension;

        if (!File::exists(getcwd().'/photos/campaign/')) {
            $result = File::makeDirectory(getcwd().'/photos/campaign/', 0777, true);
            if ($result){
                $destination_path = getcwd().'/photos/campaign/';
            }
        } else {
            $destination_path = getcwd().'/photos/campaign/';
        }

        $img = Image::make($photo_real_path);
        $img->save($destination_path.$filename);
        // end of upload feature photo

        // Upload banner photo
        $filename_banner = null;
        if ($request->hasFile('photo_banner')) {
            $photo_banner = $request->file('photo_banner');
            $extension_banner = $photo_banner->getClientOriginalExtension();
            $photo_banner_real_path = $photo_banner->getRealPath();
            $filename_banner = str_random(5).date('Ymdhis').'.'.$extension_banner;

            if (!File::exists(getcwd().'/photos/campaign/')) {
                $result_banner = File::makeDirectory(getcwd().'/photos/campaign/', 0777, true);
                if ($result_banner){
                    $destination_path_banner = getcwd().'/photos/campaign/';
                }
            } else {
                $destination_path_banner = getcwd().'/photos/campaign/';
            }

            $img_banner = Image::make($photo_banner_real_path);
            $img_banner->save($destination_path_banner.$filename_banner);
        }
        // End of Upload banner photo
        //dd($request->input('verifikasi'));

        $id = Auth::user()->id;
        $user = User::find($id);
        if(Auth::user()->hasRole('admin'))
        {

            $target_amount = (int)str_replace('.','',$request->input('target'));
            $campaign = Campaign::create([
                'creator_id' => Auth::user()->id,
                'featured' => $request->input('homepage') == 'true' ? true : false,
                'banner_featured' => $request->input('banner') == 'yes' ? true : false,
                'banner_description' => $request->input('banner_description'),
                'status' => $request->input('publish') == 'true' ? "Published" : "Draft",
                'title' => $request->input('name'),
                'post' => $request->input('posting'),
                'feature_image_url' => $filename,
                'banner_feature_image_url' => $filename_banner,
                'region' => $request->input('city'),
                'receiver_number' => $request->input('receiver'),
                'categories' => $request->input('categories'),
                'target' => $target_amount,
                'verifikasi' => $request->input('verifikasi'),
                'advertiser' => $request->input('pengiklan'),
                'advertiser_type' => $request->input('advertiser_type'),
                'start_date' => date('Y-m-d', strtotime($request->input('start_date'))),
                'end_date' => date('Y-m-d', strtotime($request->input('end_date'))),
                'slug' => $request->input('slug')
            ]);

        }
        else
        {
            $target_amount = (int)str_replace('.','',$request->input('target'));
            $campaign = Campaign::create([
                'creator_id' => Auth::user()->id,
                'featured' => $request->input('homepage') == 'true' ? true : false,
                'banner_featured' => $request->input('banner') == 'yes' ? true : false,
                'banner_description' => $request->input('banner_description'),
                'status' => "Draft",
                'title' => $request->input('name'),
                'post' => $request->input('posting'),
                'feature_image_url' => $filename,
                'banner_feature_image_url' => $filename_banner,
                'region' => $request->input('city'),
                'receiver_number' => $request->input('receiver'),
                'categories' => $request->input('categories'),
                'target' => $target_amount,
                'verifikasi' => 0,
                'advertiser' => $user['name'],
                'advertiser_type' => $user['advertiser_type'],
                'start_date' => date('Y-m-d', strtotime($request->input('start_date'))),
                'end_date' => date('Y-m-d', strtotime($request->input('end_date'))),
                'slug' => $request->input('slug')
            ]);

        }

        // Save new category kalo ada
        $categories = DB::table('categories')->select('name')->get()->toArray();
        foreach ($campaign->categories as $value) {
            if(!in_array($value, $categories)) {
                DB::table('categories')->insert([
                    'name' => $value
                ]);
            }
        }
        // End of Save new category kalo ada

        if ($campaign->status == 'Published') {
            $mgClient = new Mailgun(env('MAILGUN_API_KEY', 'key-4393b2c50a4549c2580c61ffdec79def'));
            $domain = env('MAILGUN_DOMAIN_NAME', 'sandbox43acb735be794efa8869ff84bc26e0dc.mailgun.org');

            $buzzers = User::where('is_buzzer', true)->get()->keyBy('email');
            if ($buzzers->count() != 0) {
                $recipientVariables = $buzzers->map(function($item) use ($campaign) {
                    $item['link'] = route('campaign.show', $campaign->slug)."?bz=$item->buzzer_code&of=true";
                    return $item;
                });
                $receivers = implode(",", $recipientVariables->keys()->toArray());

                # Make the call to the client.
                $result = $mgClient->sendMessage($domain, array(
                    'from'    => 'Peduli Negeri <contact@pedulinegeri.com>',
                    'to'      => $receivers,
                    'subject' => "Program Baru Peduli Negeri: $campaign->title",
                    'html'    => view('email.mailgunBuzzer', ['title' => $campaign->title])->render(),
                    'recipient-variables' => $recipientVariables->toJson()
                ));
            }
        }

        return redirect()->route('campaign.index')->with('success', 'Campaign '.$request->input('name').' berhasil disimpan!');
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
        var_dump('edit campaign');exit();
        $id=decrypt($id);
        $campaign = Campaign::find($id);

        if (!$campaign) return view('errors.404');

        $id = Auth::user()->id;
        $user = User::find($id);
        if(Auth::user()->hasRole('admin'))
        {

            return view('admin.campaign.edit', compact('campaign'));

        }
        else
        {
            return view('admin.campaign.edit_relawan', compact('campaign'));
        }

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
        $campaign = Campaign::find($id);

        if (!$campaign) return view('errors.404');

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            //'receiver' => 'required',
            //'pengiklan' => 'required',
            //'type_pengiklan' => 'required',
            //'verifikasi' => 'required',
            'city' => 'required',
            'target' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'categories' => 'required',
            'homepage' => 'required',
            'posting' => 'required',
            //'publish' => 'required',
            'banner_description' => 'required_if:banner,yes',
            'slug' => 'required|unique:campaigns,slug,'.$id
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        // Upload feature photo
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $extension = $photo->getClientOriginalExtension();
            $photo_real_path = $photo->getRealPath();
            $filename = str_random(5).date('Ymdhis').'.'.$extension;

            if (!File::exists(getcwd().'/photos/campaign/')) {
                $result = File::makeDirectory(getcwd().'/photos/campaign/', 0777, true);
                if ($result){
                    $destination_path = getcwd().'/photos/campaign/';
                }
            } else {
                $destination_path = getcwd().'/photos/campaign/';
            }

           //dd($destination_path);

            $img = Image::make($photo_real_path);
            $img->save($destination_path.$filename);

            $campaign->feature_image_url = $filename;
        }
        // end of upload feature photo

        // Upload banner photo
        $filename_banner = null;
        if ($request->hasFile('photo_banner')) {
            $photo_banner = $request->file('photo_banner');
            $extension_banner = $photo_banner->getClientOriginalExtension();
            $photo_banner_real_path = $photo_banner->getRealPath();
            $filename_banner = str_random(5).date('Ymdhis').'.'.$extension_banner;

            if (!File::exists(getcwd().'/photos/campaign/')) {
                $result_banner = File::makeDirectory(getcwd().'/photos/campaign/', 0777, true);
                if ($result_banner){
                    $destination_path_banner = getcwd().'/photos/campaign/';
                }
            } else {
                $destination_path_banner = getcwd().'/photos/campaign/';
            }

            $img_banner = Image::make($photo_banner_real_path);
            $img_banner->save($destination_path_banner.$filename_banner);

            $campaign->banner_feature_image_url = $filename_banner;
            $campaign->banner_description = $request->input('banner_description');
        }
        // End of Upload banner photo

        $id = Auth::user()->id;
        $user = User::find($id);
        if(Auth::user()->hasRole('admin'))
        {
            $target_amount = (int)str_replace('.','',$request->input('target'));
            $campaign->featured = $request->input('homepage') == 'true' ? true : false;
            $campaign->banner_featured = $request->input('banner') == 'yes' ? true : false;
            $campaign->status = $request->input('publish') == 'true' ? "Published" : "Draft";
            $campaign->title = $request->input('name');
            $campaign->post = $request->input('posting');
            $campaign->region = $request->input('city');
            $campaign->receiver_number = $request->input('receiver');
            $campaign->categories = $request->input('categories');
            $campaign->target = $target_amount;
            $campaign->verifikasi = $request->input('verifikasi');
            $campaign->advertiser = $request->input('pengiklan');
            $campaign->advertiser_type = $request->input('type_pengiklan');
            $campaign->start_date = date('Y-m-d', strtotime($request->input('start_date')));
            $campaign->end_date = date('Y-m-d', strtotime($request->input('end_date')));
            $campaign->slug = $request->input('slug');
            $campaign->save();
        }
        else
        {
            $target_amount = (int)str_replace('.','',$request->input('target'));
            $campaign->featured = $request->input('homepage') == 'true' ? true : false;
            $campaign->banner_featured = $request->input('banner') == 'yes' ? true : false;
            //$campaign->status = $request->input('publish') == 'true' ? "Published" : "Draft";
            $campaign->title = $request->input('name');
            $campaign->post = $request->input('posting');
            $campaign->region = $request->input('city');
            $campaign->receiver_number = $request->input('receiver');
            $campaign->categories = $request->input('categories');
            $campaign->target = $target_amount;
           // $campaign->verifikasi = $request->input('verifikasi');
            //$campaign->advertiser = $request->input('pengiklan');
            //$campaign->advertiser_type = $request->input('type_pengiklan');
            $campaign->start_date = date('Y-m-d', strtotime($request->input('start_date')));
            $campaign->end_date = date('Y-m-d', strtotime($request->input('end_date')));
            $campaign->slug = $request->input('slug');
            $campaign->save();
        }

        // Save new category kalo ada
        $categories = DB::table('categories')->select('name')->get()->toArray();
        foreach ($campaign->categories as $value) {
            if(!in_array($value, $categories)) {
                DB::table('categories')->insert([
                    'name' => $value
                ]);
            }
        }
        // End of Save new category kalo ada

        return redirect()->route('campaign.index')->with('success', 'Campaign '.$request->input('name').' berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $campaign = Campaign::find($id);

        if (!$campaign) return view('errors.404');

        $campaign_name = $campaign->name;
        $campaign->delete();

        return redirect()->route('campaign.index')->with('success', 'Campaign '.$campaign_name.' berhasil dihapus!');
    }

    public function publish($id)
    {
        $campaign = Campaign::find($id);

        if (!$campaign) return view('errors.404');
        $campaign_name = $campaign->name;
        $campaign->status = "Published";
        $campaign->verifikasi = 1;
        $campaign->save();

        return redirect()->back()->with('success', 'Campaign '.$campaign_name.' berhasil di-publish!');
    }

    public function unpublish($id)
    {
        $campaign = Campaign::find($id);

        if (!$campaign) return view('errors.404');
        $campaign_name = $campaign->name;
        $campaign->status = "Draft";
        $campaign->verifikasi = 0;
        $campaign->save();

        return redirect()->back()->with('success', 'Campaign '.$campaign_name.' berhasil di-unpublish!');
    }
}
