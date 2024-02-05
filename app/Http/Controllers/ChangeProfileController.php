<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;



use App\Campaign;

use App\Donation;

use App\Report;

use App\User;

use App\Role;

use App\Mail\GeneralMail;

use Auth;

use Datatables;

use Mail;

use Validator;

use Image;

use File;



class ChangeProfileController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $home = User::all();
        $role = Auth::user()->role_user;
        if (!$home || $role == 'User') return view('vendor.adminlte.errors.404');

        //echo "test";

        //$campaign = Campaign::find($campaign_id);



        //if (!$campaign) return view('errors.404');

        $user_auth = Auth::user();

        $id = $user_auth['id'];

        //dd($id);



        $user = User::find($id);

        $roles = Role::with('perms')->get();

        $temp = $user->roles->map(function($item) {

            return $item->id;

        });



        $role = $temp[0];

        if ($role=="1")

        {

            return view('admin.profile.admin');

        }

        else

        {

            return view('admin.profile.relawan');

        }

        

    }



    public function update(Request $request, $id)

    {

        //dd("abc");

        $user = User::find($id);

        $roles = Role::with('perms')->get();

        $temp = $user->roles->map(function($item) {

            return $item->id;

        });



        $role = $temp[0];



        $validator = Validator::make($request->all(), [

            'name' => 'required',

            'email' => 'required',

            'phone' => 'required'

        ]);



        if ($validator->fails()) {

            return redirect()->back()

                    ->withErrors($validator)

                    ->withInput();

        }



        



        if (!$user) return view('errors.404');



        $user->name = $request->input('name');

        $user->email = $request->input('email');

        $user->phone = $request->input('phone');

        $user->domicile = $request->input('domicile');

        $user->address = $request->input('address');



        if ($request->input('tempat'))

        {

            $user->place_of_birth = $request->input('tempat');



        }



         if ($request->input('tgl_lahir'))

        {

            $user->date_of_birth = $request->input('tgl_lahir');



        }



        if ($request->input('type_pengiklan'))

        {

            $user->advertiser_type = $request->input('type_pengiklan');



        }

         if ($request->input('ktp_siup'))

        {

            $user->ktp_siup = $request->input('ktp_siup');



        }

        



        if ($request->hasFile('pic')) {

             $photo = $request->file('pic');

            $extension = $photo->getClientOriginalExtension();

            $photo_real_path = $photo->getRealPath();

            $filename = str_random(5).date('Ymdhis').'.'.$extension;



            if (!File::exists(getcwd().'/photos/profile/')) {

                $result = File::makeDirectory(getcwd().'/photos/profile/', 0777, true);

                if ($result){

                    $destination_path = getcwd().'/photos/profile/';

                }

            } else {

                $destination_path = getcwd().'/photos/profile/';

            }



           //dd($destination_path);



            $img = Image::make($photo_real_path);

            $img->save($destination_path.$filename);



            $user->profpic_url = $filename;

            $user->is_silhouette = 0;

        }



        if ($request->hasFile('legalitas')) {

            $photo = $request->file('legalitas');

            $extension = $photo->getClientOriginalExtension();

            $photo_real_path = $photo->getRealPath();

            $filename = str_random(5).date('Ymdhis').'.'.$extension;



            if (!File::exists(getcwd().'/photos/profile/')) {

                $result = File::makeDirectory(getcwd().'/photos/profile/', 0777, true);

                if ($result){

                    $destination_path = getcwd().'/photos/profile/';

                }

            } else {

                $destination_path = getcwd().'/photos/profile/';

            }



           //dd($destination_path);



            $img = Image::make($photo_real_path);

            $img->save($destination_path.$filename);



            $user->identity_file = $filename;

        }





        if ($request->input('password') != null || $request->input('password') != '') $user->password = bcrypt($request->input('password'));

        $user->save();



        if ($role==2)

        {

            return redirect()->route('profile.show')->with('success', 'Profile berhasil diubah!');

        }

        else

        {

            return redirect()->route('campaign.index')->with('success', 'Profile berhasil diubah!');

        }



        

    }



    

}

