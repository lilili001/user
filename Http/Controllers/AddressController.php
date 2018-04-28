<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Modules\Core\Http\Controllers\BasePublicController;

use Illuminate\Http\Request;
use Modules\User\Entities\Address;
use Modules\User\Http\Requests\AddressRequest;
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
        $data = Address::all()->toArray();
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
            $notices = DB::update(DB::raw("UPDATE customer_address SET is_default = 0"));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddressRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->checkIfDefault(request('is_default'));
            $data = $request->all();
            Address::create(array_merge($data,['user_id'=>user()->id]));
            DB::commit();

            // all good
            if ($request->ajax()) {
                return AjaxResponse::success('');
            } else {
                return redirect()->back();
            }

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
}

/**
 * Display the specified resource.
 *
 * @param  int $id
 * @return \Illuminate\Http\Response
 */
public
function show($id)
{
    //
}

/**
 * Show the form for editing the specified resource.
 *
 * @param  int $id
 * @return \Illuminate\Http\Response
 */
public
function edit($id)
{

    return Address::where('address_id', $id)->get()->toArray();
}

/**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request $request
 * @param  int $id
 * @return \Illuminate\Http\Response
 */
public
function update(AddressRequest $request, $id)
{
    DB::beginTransaction();
    try {
        $this->checkIfDefault(request('is_default'));
         Address::where([
            'address_id' => $id,
            'user_id' => user()->id
        ])->update($request->all);
        DB::commit();
        // all good
        return AjaxResponse::success();
    } catch (\Exception $e) {
        DB::rollback();
        throw $e;
    }
}

/**
 * Remove the specified resource from storage.
 *
 * @param  int $id
 * @return \Illuminate\Http\Response
 */
public
function destroy($id)
{
    $bool = Address::where('address_id', $id)->delete();
    return $bool ? AjaxResponse::success() : AjaxResponse::fail();
}
}
