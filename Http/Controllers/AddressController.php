<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Modules\Core\Http\Controllers\BasePublicController;

use Illuminate\Http\Request;
use Modules\User\Entities\UserAddress;
use Modules\User\Http\Requests\CreateUserAddressRequest;
use Modules\User\Http\Requests\LoginRequest;
use AjaxResponse;

class AddressController extends BasePublicController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = UserAddress::where('user_id',user()->id)->get()->toArray();
        return view('usercenter.address', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function checkIfDefault($isDefault)
    {
        if ($isDefault) {
            $notices = DB::update(DB::raw("UPDATE user__useraddresses SET is_default = 0"));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserAddressRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->checkIfDefault(request('is_default'));
            $data = $request->all();
            UserAddress::create(array_merge($data, ['user_id' => user()->id]));
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        // all good
        if ($request->ajax()) {
            return AjaxResponse::success('',UserAddress::all()->toArray() );
        } else {
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return UserAddress::where('id', $id)->get()->toArray();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateUserAddressRequest $request, $id)
    {
        $data = $request->all();
        unset($data['_method']);
        unset($data['_token']);

        DB::beginTransaction();
        try {
            $this->checkIfDefault($data['is_default']);
            UserAddress::where([
                'id' => $id,
                'user_id' => user()->id
            ])->update($data);
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        // all good
        if ($request->ajax()) {
            return AjaxResponse::success();
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bool = UserAddress::where('id', $id)->delete();
        return $bool ? AjaxResponse::success() : AjaxResponse::fail();
    }

    public function setDefault( $id )
    {
        DB::update(DB::raw("UPDATE user__useraddresses SET is_default = 0"));
        $bool = UserAddress::where('id', $id)->update([
            'is_default' => 1
        ]);
        return $bool ? AjaxResponse::success() : AjaxResponse::fail();
    }
}
