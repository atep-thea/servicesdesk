<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Auth;

use App\Campaign;

use App\ProgramZains;

use App\Server;

use App\PerangkatKeras;

use App\Pelayanan;

use App\User;

use App\Organisasi;

use App\JnspelayananModel;

use Datatables;

use DB;

use Image;

use File;

use Validator;

use Mailgun\Mailgun;

use \Carbon\Carbon;

use Illuminate\Support\Facades\Log;



class HomeController extends Controller

{

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()

    {

        $this->middleware('auth');
    }



    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {


        $home = User::all();

        $role = Auth::user()->role_user;
        
        if ($role == 'User') return redirect()->route('user_portal.index');
        if (!$home) return view('errors.404');

        $data['server'] = Server::where('id_infrastruktur', '=', 'INF-01')->count();

        $data['ap'] = Server::where('id_infrastruktur', '=', 'INF-02')->count();

        $data['vs'] = Server::where('id_infrastruktur', '=', 'INF-03')->count();

        $data['rak'] = Server::where('id_infrastruktur', '=', 'INF-04')->count();

        $data['dnet'] = Server::where('id_infrastruktur', '=', 'INF-05')->count();

        $data['strg'] = Server::where('id_infrastruktur', '=', 'INF-06')->count();

        $data['swtch'] = Server::where('id_infrastruktur', '=', 'INF-07')->count();

        $data['nas'] = Server::where('id_infrastruktur', '=', 'INF-08')->count();

        $data['router'] = Server::where('id_infrastruktur', '=', 'INF-09')->count();



        $data['pc'] = PerangkatKeras::where('jns_perangkat', '=', 'PK-001')->count();

        $data['lptp'] = PerangkatKeras::where('jns_perangkat', '=', 'PK-002')->count();

        $data['prntr'] = PerangkatKeras::where('jns_perangkat', '=', 'PK-003')->count();

        $data['tlp'] = PerangkatKeras::where('jns_perangkat', '=', 'PK-004')->count();

        $data['hp'] = PerangkatKeras::where('jns_perangkat', '=', 'PK-005')->count();

        $data['pherip'] = PerangkatKeras::where('jns_perangkat', '=', 'PK-006')->count();

        $data['ipphone'] = PerangkatKeras::where('jns_perangkat', '=', 'PK-007')->count();


        $query_pelayanan = Pelayanan::leftjoin('organisasi', 'organisasi.id_organisasi', '=', 'pelayanan.id_opd')
            ->leftjoin('users', 'users.id', '=', 'pelayanan.id_agen')
            ->leftJoin('flow_pelayanan', 'flow_pelayanan.id', '=', 'pelayanan.stage')
            ->select('pelayanan.id_', 'organisasi.nama_opd', 'pelayanan.kd_tiket', 'pelayanan.judul', 'pelayanan.id_pelapor', 'pelayanan.tgl_pelaporan', 'users.nama_depan as nama_agen', 'users.nama_belakang', 'pelayanan.status as status_tiket', 'pelayanan.id_agen')
            ->orderBy('id_', 'desc')
            ->limit(4);
        $current_logged_user = Auth::user();
        if (Auth::user()->role_user == 'Verifikator PD') {
            $query_pelayanan = $query_pelayanan->whereHas('pelapor', function ($query) use ($current_logged_user) {
                return $query->where('id_organisasi', '=', $current_logged_user->id_organisasi);
            })->orWhere('flow_pelayanan.stage', '=', 2)->where('pelayanan.status', '=', 'Diproses')->where('flow_pelayanan.user_koordinator_id', '=', Auth::user()->id);
        } else {
            if($current_logged_user->role_user == 'Koordinator Agen')
            {
                $query_pelayanan = $query_pelayanan
                ->orWhere('flow_pelayanan.stage', '=', 1)
                ->orWhere('flow_pelayanan.stage', '>', 2);
            }else if($current_logged_user->role_user == 'Agen')
            {
                $query_pelayanan = $query_pelayanan->whereHas('agent', function ($query) use ($current_logged_user) {
                    return $query->where('id', '=', $current_logged_user->id);
                });
            }
           
        }
        $data['current_logged_user'] = $current_logged_user;
        $query_final_pelayanan = $query_pelayanan->get();

        $data['tiket'] = $query_final_pelayanan;

        $data['jmlhUser'] = User::where('role_user', '!=', 1)->count();

        $date = \Carbon\Carbon::today()->subDays(7);

        $data['semingguTerakhir'] = Pelayanan::where('tgl_pelaporan', '>=', $date)->count();

        $plynn = Pelayanan::count();


        $selesai = Pelayanan::where('status', '=', 'Selesai')->count();

        $data['prsentaseSelesai'] = ($plynn > 0 ? ceil($selesai / $plynn * 100) : 0);

        $data['jmlOrg'] = Organisasi::count();



        $data['profil'] = DB::table('pelayanan')

            ->leftjoin('users', 'users.id', '=', 'pelayanan.id_agen')

            ->leftjoin('team', 'team.id_team', '=', 'users.id_team')

            ->select(
                'users.nama_depan',
                'users.nama_belakang',
                'team.name_team',
                'users.foto',
                DB::raw('COUNT(pelayanan.id_agen) as jml_tiket')
            )

            ->where('users.role_user', '!=', 1)

            ->groupBy('users.nama_depan', 'users.nama_belakang', 'team.name_team', 'users.foto')

            ->orderBy('jml_tiket')

            ->limit(7)

            ->distinct()

            ->get();
        // SELECT count(id_) FROM `pelayanan`

        // SELECT count(sub_jns_pelayanan) FROM `pelayanan` WHERE sub_jns_pelayanan = 1

        // $data['hosting'] = Pelayanan::where('sub_jns_pelayanan','=', 1)->count();
        // $data['subdomain'] = Pelayanan::where('sub_jns_pelayanan','=', 2)->count();
        // $data['colo'] = Pelayanan::where('sub_jns_pelayanan','=', 3)->count();
        // $data['jaringan'] = Pelayanan::where('sub_jns_pelayanan','=', 5)->count();
        // $data['apk'] = Pelayanan::where('sub_jns_pelayanan','=', 6)->count();

        // $data['prsenHosting'] = ($plynn > 0 ? ceil($data['hosting']/$plynn*100) : 0); 
        // $data['prsenDomain'] = ($plynn > 0 ? ceil($data['subdomain']/$plynn*100) : 0);
        // $data['prsenColor'] = ($plynn > 0 ? ceil($data['colo']/$plynn*100) : 0);
        // $data['prsenJaring'] = ($plynn > 0 ? ceil($data['jaringan']/$plynn*100) : 0);
        // $data['prsenApk'] =  ($plynn > 0 ? ceil($data['apk']/$plynn*100) : 0);

        $digram = Pelayanan::selectRaw('count(status) as count,status')->groupBy('status')->get();

        $data['pieDiagram'] = array();

        foreach ($digram as $result) {

            $data['pieDiagram'][$result->status] = (int)$result->count;
        }

        $month = date('m');

        $digmonth = Pelayanan::selectRaw('count(status) as count,status')
            ->whereMonth('tgl_pelaporan', '=', $month)->groupBy('status')
            ->get();

        $data['statMonth'] = array();

        foreach ($digmonth as $result) {

            $data['statMonth'][$result->status] = (int)$result->count;
        }

        $rating_pelayanan = Pelayanan::orderBy('count', 'desc')
        ->select(DB::raw('survey_rate,count(*) as count'))
        ->groupBy('survey_rate')
        ->get();

        $total_Pelayanan = Pelayanan::count();
        // Log::info($total_Pelayanan);

        $jns_pelayanan = JnspelayananModel::withCount(['pelayanan'])->get();
        // Log::info($jns_pelayanan);
        

        $data['statTotalPelayanan'] = array();

        foreach( $jns_pelayanan as $jnsPelayanan){
            if($total_Pelayanan!=0){
                $percentage = ($jnsPelayanan->pelayanan_count/$total_Pelayanan)*100;
                $data['statTotalPelayanan'][$jnsPelayanan->pelayanan] = (int)$jnsPelayanan->pelayanan_count;
            }else
            {
                $data['statTotalPelayanan'][$jnsPelayanan->pelayanan] =0;
            }
        }

        $data['data_jns_pelayanan']=$jns_pelayanan;
        

        $data['rating'] = $rating_pelayanan;
        return view('admin.home', $data);
    }



    public function pieChart()
    {



        $user = array();

        foreach ($social_users as $result) {

            $user[$result->source] = (int)$result->count;
        }



        return view('piechart', compact('user'));
    }
}
