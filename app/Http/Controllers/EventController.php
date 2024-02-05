<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

use Auth;
use Datatables;
use Image;
use File;
use Validator;
use Storage;


class EventController extends Controller
{

        
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $blogs = Blog::all();
        return view('admin.event.index');
    }

    public function eventData()
    {
        $query = Event::query();

        return Datatables::of($query)
                            ->addColumn('action', function($item) {
                                $temp = "<span data-toggle='tooltip' title='Gambar Feature'>
                                <a href='#modal' role='button' data-image-url=".asset('/public/photos/event/'.$item->feature_image_url)." class='btn btn-xs btn-primary image'><i class='icon fa fa-image'></i></a></span>";

                                $temp .= "<span data-toggle='tooltip' title='Edit Posting'>
                                <a href=".route('admin-event.edit', $item->id)." class='btn btn-xs btn-primary'><i class='icon fa fa-pencil'></i></a></span>";

                                $temp .= "<span data-toggle='tooltip' title='Hapus Posting'>
                                <a href='#delete' data-delete-url=".route('admin-event.destroy', $item->id)." role='button' class='btn btn-xs btn-danger delete'><i class='icon fa fa-trash'></i></a></span>";
                                return $temp;
                            })
                            ->make(true);
    }


    public function create()
    {
        return view('admin.event.create');
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
            'title' => 'required',
            'slug' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'posting' => 'required',
            'publish' => 'required',
            'lokasi_event' => 'required',
            'tgl_event' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        // Upload feature photo
        $filename = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $extension = $photo->getClientOriginalExtension();
            $photo_real_path = $photo->getRealPath();
            $filename = str_random(5).date('Ymdhis').'.'.$extension;

            if (!File::exists(getcwd().'/public/photos/event/')) {
                $result = File::makeDirectory(getcwd().'/public/photos/event/', 0777, true);

                if ($result){
                    $destination_path = getcwd().'/public/photos/event/';
                }
            } else {
                $destination_path = getcwd().'/public/photos/event/';
            }

            $img = Image::make($photo_real_path);
            $img->save($destination_path.$filename);
        }
        // end of upload feature photo
        $tglevent = $request->input('tgl_event');
        $tgl_event = date('Y-m-d H:i:s', strtotime($tglevent));
        //var_dump($tgl_event);exit();
        Event::create([
            'creator_id' => Auth::user()->id,
            'status' => $request->input('publish') == 'true' ? "Published" : "Draft",
            'title' => $request->input('title'),
            'lokasi_event' => $request->input('lokasi_event'),
            'tgl_event' => $tgl_event,
            'slug' => $request->input('slug'),
            'post' => $request->input('posting'),
            'feature_image_url' => $filename == null ? '' : $filename,
        ]);

        return redirect()->route('admin-event.index')->with('success', 'Post berjudul "'.$request->input('title').'" berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $blog = Blog::find($id);

        // if (!$blog) return view('errors.404');

        // return view('admin-event.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::find($id);

        if (!$event) return view('errors.404');

        return view('admin.event.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        if (!$event) return view('errors.404');

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'posting' => 'required',
            'publish' => 'required',
            'lokasi_event' => 'required',
            'tgl_event' => 'required'
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

            if (!File::exists(getcwd().'/public/photos/event/')) {
                $result = File::makeDirectory(getcwd().'/public/photos/event/', 0777, true);

                if ($result){
                    $destination_path = getcwd().'/public/photos/event/';
                }
            } else {
                $destination_path = getcwd().'/public/photos/event/';
            }

            $img = Image::make($photo_real_path);
            $img->save($destination_path.$filename);

            $event->feature_image_url = $filename;
        }

        // end of upload feature photo
        $dataEvent = $request->input('tgl_event');
        $timezone = "Asia/Jakarta";
        date_default_timezone_set($timezone);
        $time = date('H:i:s');
        $tglevent = $dataEvent.' '.$time;

        $event->title = $request->input('title');
        $event->post = $request->input('posting');
        $event->tgl_event = $tglevent;
        $event->lokasi_event = $request->input('lokasi_event');
        $event->status = $request->input('publish') == 'true' ? "Published" : "Draft";
        $event->save();

        return redirect()->route('admin-event.index')->with('success', 'Post berjudul "'.$request->input('title').'" berhasil diubah!');
    }
    /**

     * Remove the specified resource from storage.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = event::find($id);

        if (!$event) return view('errors.404');

        $event_name = $event->title;

        $featured_image = public_path().'/public/photos/event/'.$event->feature_image_url;
        Storage::delete($featured_image);

        $event->delete();

        return redirect()->route('admin-event.index')->with('success', 'Post berjudul "'.$event_name.'" berhasil dihapus!');

    }
}