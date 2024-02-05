<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Auth;

use App\Pelayanan;

use App\User;

use App\Organisasi;
use App\Team;

use Datatables;

use DB;

use Image;

use File;

use Validator;

use Mailgun\Mailgun;

use \Carbon\Carbon;

use Illuminate\Support\Facades\Log;



class TeamController extends Controller
{
    public function __construct()

    {

        $this->middleware('auth');
    }

    public function index()

    {

        return view('admin.team.team_view_index');
    }

    public function teamData()

    {

        $query = Team::all();

        return Datatables::of($query)

            ->addColumn('action', function ($item) {



                $temp = "<span data-toggle='tooltip' title='Edit Posting'>

                                <a href=" . route('team.edit', $item->id_team) . " class='btn btn-xs btn-default'><i class='glyphicon glyphicon-edit'></i></a></span>";



                $temp .= "<span data-toggle='tooltip' title='Hapus Team'>

                                <a href='#delete' 

                                data-delete-url=" . route('team.destroy', $item->id_team) . " role='button' class='btn btn-xs btn-default delete'><i class='fas fa-trash-alt'></i></a></span>";

                return $temp;
            })

            ->editColumn('team', function ($item) {

                return "<a href='" . route('team.show', $item->id_team) . "'>" . $item->id_team . "</a>";
            })

            ->make(true);
    }

    public function create()

    {
        $allUser  = User::get();
        $koordinator_agen_user = User::where('role_user','=','Koordinator Agen')->get();

        return view('admin.team.create_team', compact('allUser','koordinator_agen_user'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [



            'team' => 'required',
            'team_leader' => 'required',
            'team_member.*' => 'required'

        ]);



        if ($validator->fails()) {

            return redirect()->back()

                ->withErrors($validator)

                ->withInput();
        }

        $team_name = $request->input('team');
        $team_leader= $request->input('team_leader');
        $team_member = $request->input('team_member');

        $team = Team::create(['name_team'=>$team_name]);

        DB::table('team_user')->insert(['user_id'=>$team_leader,'team_id'=>$team->id_team,'leader'=>1]);
        
        Log::info($team_leader);

        foreach($team_member as $member)
        {
            DB::table('team_user')->insert(['user_id'=>$member,'team_id'=>$team->id_team,'leader'=>0]);
        }

        return redirect()->route('team.index')->with('success', 'Penambahan Tim "' . $request->input('team') . '" berhasil ditambahkan!');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $allUser  = User::get();
        $team = Team::with('member')->find($id);
        if (!$team) return view('errors.404');
        $team_leader = DB::table('team_user')->selectRaw('users.id as userId,users.nama_depan as nama_depan ,users.nama_belakang as nama_belakang')
                            ->join('users','team_user.user_id','users.id')
                            ->where('team_user.team_id','=',$id)
                            ->where('team_user.leader','=',1)
                            ->first();

        return view('admin.team.edit_team', compact('team','allUser','team_leader'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'team' => 'required',
            'team_leader' => 'required',
            'team_member.*' => 'required'
        ]);



        if ($validator->fails()) {

            return redirect()->back()

                ->withErrors($validator)

                ->withInput();
        }
        $team = Team::find($request->team_id);

        
        $team_name = $request->input('team');
        $team_leader= $request->input('team_leader');
        $team_member = $request->input('team_member');
        $team->name_team = $team_name;
        $team->save();
        // $team = Team::create(['name_team'=>$team_name]);
        
        DB::table('team_user')->where('team_id',$request->team_id )->delete();

        DB::table('team_user')->insert(['user_id'=>$team_leader,'team_id'=>$team->id_team,'leader'=>1]);
        
        foreach($team_member as $member)
        {
            DB::table('team_user')->insert(['user_id'=>$member,'team_id'=>$team->id_team,'leader'=>0]);
        }

        return redirect()->route('team.index')->with('success', 'Update Tim "' . $request->input('team') . '" berhasil !');
    }

    public function destroy($id)
    {
        $team = Team::find($id);
        if (!$team) return view('errors.404');
        $team_name = $team->name_team;
        $team->delete();
        return redirect()->route('team.index')->with('success',
             'Data server "'.$team_name.'" telah dihapus!');
    }
}
