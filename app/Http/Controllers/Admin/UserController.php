<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Imports\UsersImport;


use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
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
            $kq = User::orderBy('id', "DESC")->search()->paginate(1);
            $kq->appends(['key' => $search]);
        } else {
            $kq = User::orderBy('id', "DESC")->paginate(10);
        }
        return view('pages.admin.user.index', compact('kq'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.user.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $data = $request->all();
        $data['ten_user'] = Str::lower($data['ten_user']);
        $data['password'] = Hash::make($data['password']);
        $user->create($data);
        return redirect()->route('user.index')->with('message', "Thêm mới người dùng thành công");
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
        $user = User::find($id);
        return view('pages.admin.user.form', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->all();
        // chuyển tên người dùng về dạng thường và mã hóa mật khẩu nếu có 
        if (isset($data['ten_user'])) {
            $data['ten_user'] = Str::lower($data['ten_user']);
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);
        return redirect()->route('user.index')->with('message', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        $user->delete($request->all());
        return redirect()->route('user.index')->with('message', 'Xóa người dùng thành công');
    }

    public function import(Request $request)
    {
        // dd($request->file('import'));
        Excel::import(new UsersImport, $request->file('import'));
        return redirect()->back()->with('success', 'Data Imported Successfully');
    }
}
