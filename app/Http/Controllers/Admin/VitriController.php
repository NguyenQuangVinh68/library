<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vitri;

class VitriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('key');
        if ($search != "") {
            $kq = Vitri::orderBy("id", "DESC")->search()->paginate(10);
            $kq->appends(['key' => $search]);
        } else {
            $kq = Vitri::orderBy("id", "DESC")->paginate(10);
        }
        return view("pages.admin.vitri.index", compact('kq'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("pages.admin.vitri.form");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Vitri $vitri)
    {
        $data = $request->all();
        $vitri->tenvitri =  Str::lower($data['tenvitri']);

        if (Vitri::where('tenvitri', $vitri->tenvitri)->exists()) {
            return redirect()->route('vitri.create')->with('message', 'Vị trí đã tồn tại, vui lòng kiểm tra lại!!!');
        } else {
            $vitri->save();
            return redirect()->route("vitri.index")->with("message", "Thêm danh mục thành công");
        }
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
        $vitri = Vitri::find($id);
        return view('pages.admin.vitri.form', compact('vitri'));
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
        $data = $request->all();
        $vitri = Vitri::find($id);
        $vitri->tenvitri =  Str::lower($data['tenvitri']);
        $vitri->save();
        return redirect()->route("vitri.index")->with("message", "Cập nhật thành công");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vitri = Vitri::find($id);
        $vitri->delete();
        return redirect()->route("vitri.index")->with("message", "Xóa danh mục thành công");
    }
}
