<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


use App\Models\Nganh;


class NganhController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input("key");
        if ($search != '') {
            $nganhs = Nganh::orderBy('id', "DESC")->search()->paginate(10);
            $nganhs->appends(['key' => $search]);
        } else {
            $nganhs = Nganh::orderBy('id', "DESC")->paginate(10);
        }
        // $nganhs = Nganh::orderBy('id', "DESC")->search()->paginate(1);
        return view('pages.admin.nganh.index', compact('nganhs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("pages.admin.nganh.form");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Nganh $nganh)
    {
        $message_401 = "Mã ngành hoặc tên ngành đã tồn tại. Vui lòng kiểm tra lại !!!";

        $data = $request->all();
        $data['tennganh'] = Str::lower($data['tennganh']);
        $nganh->create($data);

        if (Nganh::where('manganh', $nganh->manganh)->orWhere('tennganh', $nganh->tennganh)->exists()) {
            return redirect()->route('nganh.create',)->with('message', $message_401);
        } else {
            $nganh->save();
            return redirect()->route('nganh.index')->with('message', 'Thêm ngành thành công!!!');
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
        $nganh = Nganh::find($id);
        return view('pages.admin.nganh.form', compact('nganh'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nganh $nganh)
    {
        $data = $request->all();
        $data['tennganh'] = Str::lower($data['tennganh']);
        $nganh->update($data);
        return redirect()->route('nganh.index')->with('message', 'Cập nhật ngành học thành công!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nganh = Nganh::find($id);
        $nganh->delete();
        return redirect()->route("nganh.index")->with('message', 'Xóa ngành /' . $nganh->tennganh . '/ thành công');
    }
}
