<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Binhluan;
use Illuminate\Http\Request;

class BinhluanController extends Controller
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
            $kq = Binhluan::orderBy('id', 'DESC')->search()->paginate(10);
            $kq->appends(['key' => $search]);
        } else {
            $kq = Binhluan::orderBy('id', 'DESC')->paginate(10);
        }
        return view('pages.admin.binhluan.index', compact('kq'));
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
        $binhluan = Binhluan::find($id);

        $binhluan->status = $request->status;
        $binhluan->save();
        return redirect()->route('binh-luan.index')->with('message', 'thay đổi trạng thái thành công');
    }
}
