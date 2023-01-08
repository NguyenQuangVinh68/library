<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Danhmuc;

class DanhmucController extends Controller
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
            $kq = Danhmuc::orderBy("id", "DESC")->search()->paginate(10);
            $kq->appends(['key' => $search]);
        } else {
            $kq = Danhmuc::orderBy("id", "DESC")->paginate(10);
        }
        return view("pages.admin.danhmuc.index", compact('kq'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("pages.admin.danhmuc.form");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Danhmuc $danhmuc)
    {
        $data = $request->all();
        $data['tendm'] = Str::lower($data['tendm']);
        $danhmuc->create($data);
        return redirect()->route("danh-muc.index")->with("message", "Thêm danh mục thành công");
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
        $danhmuc = Danhmuc::find($id);
        return view('pages.admin.danhmuc.form', compact('danhmuc'));
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
        $danhmuc = Danhmuc::find($id);

        $danhmuc->tendm =  Str::lower($data['tendm']);
        $danhmuc->slug = $data['slug'];
        $danhmuc->save();
        return redirect()->route("danh-muc.index")->with("message", "Cập nhật thành công");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $danhmuc = Danhmuc::find($id);
        $danhmuc->delete();
        return redirect()->route("danh-muc.index")->with("message", "Xóa danh mục thành công");
    }
}
