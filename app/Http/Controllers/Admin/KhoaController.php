<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Khoa;

class KhoaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kq = Khoa::orderBy('id', "DESC")->search()->paginate(5);
        return view('pages.admin.khoa.index', compact('kq'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.khoa.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Khoa $khoa)
    {
        $data = $request->all();
        $khoa->tenkhoa = Str::lower($data['tenkhoa']);
        if (Khoa::where('tenkhoa', $khoa->tenkhoa)->exists()) {
            return redirect()->route('khoa.create')->with('message', "Tên khoa đã tồn tại, vui lòng nhập tên khác");
        } else {
            $khoa->save();
            return redirect()->route('khoa.index')->with('message', "Tạo khoa mới thành công!!!");
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
        $khoa = Khoa::find($id);
        return view('pages.admin.khoa.form', compact('khoa'));
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
        $khoa = Khoa::find($id);
        $khoa->tenkhoa = Str::lower($data['tenkhoa']);
        $khoa->slug = Str::lower($data['slug']);
        $khoa->save();
        return redirect()->route('khoa.index')->with('message', 'Cập nhật khoa thành công!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $khoa = Khoa::find($id);
        $khoa->delete();
        return redirect()->route('khoa.index')->with('message', 'Xóa khoa thành công!!');
    }
}
