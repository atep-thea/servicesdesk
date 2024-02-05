<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\PelayananController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// Route::group(['middleware' => ['auth', 'role:admin|relawan']], function () {
//     Route::post('donasi/{campaign_id}', [
//         'uses' => 'PublicDonationController@storeDonasi'
// ]);
    Route::get('/cari-org', 'SearchController@searchOrg');
    Route::get('cari-organisasi','ApiController@cariOrg');
    Route::resource('campaign','RelawanController');
    Route::resource('campaign.report', 'CampaignReportController');
    Route::get('blog-data', 'BlogController@blogData')->name('blog.data');
    Route::get('buzzer-data', 'BuzzerController@buzzerData')->name('buzzer.data');
    Route::get('buzzer-per-campaign/{campaign_id}', 'BuzzerController@indexPerCampaign')->name('buzzer.campaign');
    Route::get('buzzer-per-campaign-data/{campaign_id}', 'BuzzerController@buzzerCampaignData')->name('buzzer.campaign.data');
    Route::get('campaignData', 'RelawanController@campaignData')->name('campaign.data');
    Route::get('campaign/{start}/{end}', 'RelawanController@index');
    Route::get('campaign-report-data/{id}', 'CampaignReportController@campaignReportData')->name('campaign.report.data');
    Route::resource('change-profile','ChangeProfileController');
    Route::resource('view-profile','ViewProfileController');
    Route::get('view-profile-relawan/{id}','ViewProfileController@view_profile')->name('campaign.view.relawan');
    Route::resource('pencairan','PencairanController');
    Route::get('pencairanData', 'PencairanController@dataPencairan')->name('pencairan.data');

    Route::get('view_profile','ViewProfileController@index')->name('view_profile');
    Route::get('view_profile_user','ViewProfileController@view_user');
    // Route::get('edit_profil_user/{id}','ViewProfileController@view_user');

// });

     // FRONT END USER
Route::resource('user_portal','HomePortalController');
Route::get('closeTiketView','HomePortalController@closeTiketView')->name("closeTiketView");

Route::get('edit_akun/{id}','UserController@editAccount');
Route::post('update_akun','UserController@updateAkun');
Route::get('export-users','UserController@exportExcel');
Route::post('importUsers', 'UserController@importExcel');
Route::get('sla/{id}','PelayananController@getSla');
Route::post('update_sla','PelayananController@updateSla');
Route::get('downloadSla/{id}', 'PelayananController@downloadSla');
Route::get('downloadBA/{id}', 'PelayananController@downloadBA');
Route::get('downloadBAReply/{id}', 'SlabaController@downloadReplyBA');
Route::get('downloadSLAReply/{id}', 'SlabaController@downloadReplySLA');
Route::get('downloadInsiden/{id}', 'InsidenUserController@downloadfile');
Route::get('downloadBalasan/{id}', 'PelayananController@downloadBalasan');
Route::get('downloadTaskAttachment/{kd_tiket}/{id}','PelayananController@downloadTaskAttachment');


// Route::resource('request_done','RequestDoneController');
// Route::get('request_done_data', 'RequestDoneController@reqdoneData')->name('request_done.data');

Route::resource('request_progress','RequestProgressController');
// Route::get('request_progress_data', 'RequestProgressController@reqprgrsData')->name('request_progress.data');

/**
  * Halaman admin
  */
//Route::group(['middleware' => 'isAdmin'], function () {
    Route::resource('buzzer','BuzzerController');
    Route::resource('admin-blog','BlogController');
    // Route::resource('campaign','CampaignController');
    // Route::resource('campaign.report', 'CampaignReportController');
    Route::resource('donations', 'DonationController');
    // Route::resource('socmeds', 'SocmedController');
    Route::resource('user','UserController');
    Route::get('user-data', 'UserController@userData')->name('user.data');
    Route::resource('admin-event','EventController');
    Route::get('event-data', 'EventController@eventData')->name('event.data');
    Route::resource('admin-testimoni','TestimoniController');
    Route::get('testimoni-data', 'TestimoniController@testimoniData')->name('testimoni.data');

    // REFERENSI CRUD
    Route::resource('ref-infrastruktur','RefInfraController');
    Route::get('ref-infrastruktur-data', 'RefInfraController@reffInfraData')->name('ref-infrastruktur.data');

    Route::resource('jabatan','JabatanController');
    Route::get('jabatan-data', 'JabatanController@jabatanData')->name('jabatan.data');

    Route::resource('golongan','GolonganController');
    Route::get('golongan-data', 'GolonganController@golonganData')->name('golongan.data');

    Route::resource('checklist','ChecklistController');
    Route::get('checlist-layanan-data', 'ChecklistController@checklistData')->name('checklist-layanan.data');

    Route::resource('jns_pelayanan','JnspelayananController');
    Route::get('jns_pelayanan-data', 'JnspelayananController@jns_pelayananData')->name('jns_pelayanan.data');

    Route::resource('jns_perangkat','JnsperangkatController');
    Route::get('jns_perangkat-data', 'JnsperangkatController@jns_perangkatData')->name('jns_perangkat.data');

    Route::resource('sjns_pelayanan','SjnspelayananController');
    Route::get('sjns_pelayanan-data', 'SjnspelayananController@sjns_pelayananData')->name('sjns_pelayanan.data');

    Route::resource('status','StatusController');
    Route::get('status-data', 'StatusController@statusData')->name('status.data');

    Route::resource('tp','TpController');
    Route::get('tp-data', 'TpController@tpData')->name('tp.data');

    Route::resource('urgensi','UrgensiController');
    Route::get('urgensi-data', 'UrgensiController@urgensiData')->name('urgensi.data');

    Route::resource('team','TeamController');
    Route::get('team-data', 'TeamController@teamData')->name('team.data');
    Route::post('update', 'TeamController@update')->name('team.update');

    // FRONT END USER
    Route::resource('user_portal','HomePortalController');

    Route::resource('request_done','RequestDoneController');
    Route::get('request_done_data', 'RequestDoneController@reqdoneData')->name('request_done.data');

    Route::resource('request_progress','RequestProgressController');
    Route::get('request_progress_data/{status?}', 'RequestProgressController@reqprgrsData')->name('request_progress.data');

    Route::resource('new_tiket','NewTiketController');
    Route::get('new_tiket_data', 'NewTiketController@newTiketData')->name('new_tiket.data');
    Route::get('form_page', 'NewTiketController@formPage')->name('new_tiket.formPage');
    Route::post('chatSupport','RequestProgressController@chatSupport');
    Route::post('rating','RequestProgressController@submitRating');
    Route::resource('close','CloseTiketController');
    Route::get('close_tiket_data', 'CloseTiketController@closeData')->name('close_tiket.data');
    Route::post('close_tiket','RequestDoneController@close_tiket');
    Route::post('reopen_tiket','CloseTiketController@reOpen');


    Route::resource('slaba','SlabaController');
    Route::get('slaba_data', 'SlabaController@slabaData')->name('slaba_data.data');

    // INFRASTRUKTUR
    Route::resource('server','ServerController');
    Route::get('server-data', 'ServerController@serverData')->name('server.data');
    Route::resource('accesspoint','AccessPointController');
    Route::get('accp-data', 'AccessPointController@accpData')->name('accp.data');
    Route::resource('vserver','VirtualServerController');
    Route::get('vserver-data', 'VirtualServerController@vserverData')->name('vserver.data');
    Route::resource('rak','RakController');
    Route::get('rak-data', 'RakController@rakData')->name('rak.data');
    Route::resource('jaringan','JaringanController');
    Route::get('jaringan-data', 'JaringanController@jaringanData')->name('jaringan.data');
    Route::resource('penyimpanan','PenyimpananController');
    Route::get('penyimpanan-data', 'PenyimpananController@penyimpananData')->name('penyimpanan.data');
    Route::resource('switch','SwitchController');
    Route::get('switch-data', 'SwitchController@switchData')->name('switch.data');
    Route::resource('nas','NasController');
    Route::get('nas-data', 'NasController@nasData')->name('nas.data');
    Route::resource('router','RouterController');
    Route::get('router-data', 'RouterController@routerData')->name('router.data');
    Route::resource('organisasi','OrganisasiController');
    Route::get('organisasi-data', 'OrganisasiController@orgData')->name('organisasi.data');
    Route::resource('perangkat-keras','PerangkatKerasController');
    Route::get('perangkat-keras-data', 'PerangkatKerasController@perangkatKerasData')->name('perangkat-keras.data');

    // Pelayanan
    Route::resource('pelayanan','PelayananController');
    Route::get('helpdeskPelayanan/{status}','PelayananController@helpdeskPelayanan')->name('pelayanan.helpdesk');
    Route::get('validatorPDPelayanan/{status}','PelayananController@validatorPDPelayanan')->name('pelayanan.validatorpd');
    Route::get('koordinatorAgenPelayanan/{status}','PelayananController@koordinatorAgenPelayananPage')->name('pelayanan.koordinatorAgen');
    Route::get('agenPelayanan/{status}','PelayananController@agenPelayananPage')->name('pelayanan.agen');
    Route::get('pelayananData/{status?}', 'PelayananController@pelayananData')->name('pelayanan.data');
    Route::get("pelayananDataHistoryClosed","PelayananController@pelayananDataHistoryClosed")->name('pelayananDataHistoryClosed');
    Route::get('pelayananAgentTaskAttachmentData/{pelayanan_id}', 'PelayananController@pelayananAgentTaskAttachmentData')->name('pelayananAttachmentTask.data');
    Route::get('pelayananAgentTaskData/{pelayanan_id}', 'PelayananController@pelayananAgentTaskData')->name('pelayananAgentTaskData.data');
    Route::get('pelayananDataEselon3/{status?}','PelayananController@pelayananDataEselon3')->name('pelayananDataEselon3');
    Route::get('pelayananDataUnverifiedPage/{status_task?}','PelayananController@pelayananDataUnverifiedPage')->name('pelayananDataUnverifiedPage');
    Route::get('pelayananDataUnverified/','PelayananController@pelayananDataUnverified')->name('pelayananDataUnverified');
    Route::get('superAdminPelayananPage/{status}','PelayananController@superAdminPelayananPage')->name('superAdminPelayananPage');
    Route::get('export-pelayanan','PelayananController@exportExcel');
    Route::resource('new-request','PermintaanBaruController');
    Route::get('newRequestData', 'PermintaanBaruController@newrequestData')->name('new-request.data');
    Route::resource('disposisi','DisposisiController');
    Route::get('disposisiData', 'DisposisiController@disposisiData')->name('disposisi.data');
    Route::post('chatUser','PelayananController@chatUser');
    Route::get('historyTiket','PelayananController@historyTiket')->name('historyTiket');
    Route::get('eselon3PelayananPage/{status}','PelayananController@eselon3PelayananPage')->name('eselon3PelayananPage');
    Route::post('importOrganisasi', 'OrganisasiController@importExcel');
    Route::get('export-org','OrganisasiController@exportExcel');
    Route::get('pelayanan/getSubjns/{id}', 'PelayananController@getSubjns');
    Route::get('pelayanan/getAgen/{id}', 'PelayananController@getAgen');
    Route::get('new-request/getSubjns/{id}', 'PermintaanBaruController@getSubjns');
    Route::get('new-request/getAgen/{id}', 'PermintaanBaruController@getAgen');
    Route::get('disposisi/getSubjns/{id}', 'DisposisiController@getSubjns');
    Route::get('disposisi/getAgen/{id}', 'DisposisiController@getAgen');
    Route::get('downloadLampiran/{id}', 'PelayananController@downloadfile');
    Route::post('reposisi','PelayananController@reposisi');
    Route::post('diposisiTeam','PelayananController@disposisi');
    Route::post("tutupTiket","PelayananController@tutupTiket");
    Route::post("nextStep","PelayananController@nextStep");
    Route::post("laporanProgresAgen","PelayananController@laporanProgressAgen");
    Route::post("perbaikiProgresAgen","PelayananController@perbaikiProgresAgen");
    Route::post("laporanSelesaiProgressAgen","PelayananController@laporanSelesaiProgressAgen");
    Route::post("balasBAUser","PelayananController@balasBAUser");
    Route::post("finalTutupTiket","PelayananController@finalTutupTiket");
    Route::post("validasiPD","PelayananController@validasiPD");
    
//});

Route::get('/', function () {
    if(Auth::check()) {
        return redirect('/home');
    } else {
        return view('vendor/adminlte/auth/login');
    }
});

Route::get('profile', 'UserController@showProfile')->name('profile.show');
Route::get('edit_profile', 'UserController@editProfile')->name('editprofile.show');
Route::resource('ubah-profile','ChangeProfileController');


Route::resource('user_portal','HomePortalController');

Route::get('pelayanan/getSsjns/{id}', 'PelayananController@getSsjns');
Route::get('pelayanan/getAgen/{id}', 'PelayananController@getAgen');
Route::get('new_tiket/getAgen/{id}', 'NewTiketController@getAgen');
Route::get('proses_tiket/{id}', 'PelayananController@prosesTiket');
Route::get('next_stage/{id}/{current_stage}', 'PelayananController@nextStage');
Route::get('close_tiket_pelayanan/{id}', 'PelayananController@closeTiket');

Route::get('dispo_proses/{id}', 'DisposisiController@prosesTiket');
Route::get('new_proses/{id}','PermintaanBaruController@prosesTiket');
Route::get('sla-dispo/{id}','DisposisiController@getSla');
Route::post('sla_update_dispo','DisposisiController@updateSla');
Route::get('sla-new/{id}','PermintaanBaruController@getSla');

Route::post('update_slanew','PermintaanBaruController@updateSla');
Route::get('downloadSlaNew/{id}', 'PermintaanBaruController@downloadSla');
Route::resource('register_user', 'RegisterUserController');

Route::get('editUser/{id}', 'PermintaanBaruController@downloadSla');
Route::post('update_user','ViewProfileController@updateUser');

Route::resource('report_insiden','ReportInsidenController');
Route::get('insidenData', 'ReportInsidenController@insidenData')->name('insiden.data');

Route::resource('insiden_user','InsidenUserController');
Route::get('insidenUserData', 'InsidenUserController@insidenData')->name('reportuser.data');
Route::post('update_insiden','InsidenUserController@ubah_insiden');

Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/home', 'HomeController@index')->name('home');
