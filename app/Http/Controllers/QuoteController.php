<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Quote;
use Datatables;
use Validator;
use Auth;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) return view('vendor.adminlte.errors.404');
        return view('admin.quote.index');
    }

    public function quoteData()
    {
        $query = Quote::query();

        return Datatables::of($query)
                            ->editColumn('button_url', function($item) {
                                $temp = "<a href='$item->button_url' target='_blank'>$item->button_url</a>";
                                return $temp;
                            })
                            ->addColumn('action', function($item) {
                                $temp = "<span data-toggle='tooltip' title='Edit Pesan'>
                                <a href=".route('quotes.edit', $item->id)." class='btn btn-xs btn-primary'><i class='icon fa fa-pencil'></i></a></span>";

                                $temp .= "<span data-toggle='tooltip' title='Hapus Pesan'>
                                <a href='#delete' data-delete-url=".route('quotes.destroy', $item->id)." role='button' class='btn btn-xs btn-danger delete'><i class='icon fa fa-trash'></i></a></span>";
                                return $temp;
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
        return view('admin.quote.create');
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
            'quote' => 'required',
            'button_text' => 'required',
            'button_url' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        Quote::create([
            'quote' => $request->input('quote'),
            'button_text' => $request->input('button_text'),
            'button_url' => $request->input('button_url')
        ]);

        return redirect()->route('quotes.index')->with('success', 'Pesan hikmah berhasil disimpan.');
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
        $quote = Quote::find($id);

        if (!$quote) return view('errors.404');

        return view('admin.quote.edit', compact('quote'));
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
        $quote = Quote::find($id);

        if (!$quote) return view('errors.404');

        $validator = Validator::make($request->all(), [
            'quote' => 'required',
            'button_text' => 'required',
            'button_url' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $quote->quote = $request->input('quote');
        $quote->button_text = $request->input('button_text');
        $quote->button_url = $request->input('button_url');
        $quote->save();

        return redirect()->route('quotes.index')->with('success', 'Pesan berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quote = Quote::find($id);

        if (!$quote) return view('errors.404');

        $quote->delete();

        return redirect()->route('quotes.index')->with('success', 'Quote berhasil dihapus.');
    }
}
