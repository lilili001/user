<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\Entities\UserAddress;
use Modules\User\Http\Requests\CreateUserAddressRequest;
use Modules\User\Http\Requests\UpdateUserAddressRequest;
use Modules\User\Repositories\UserAddressRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class UserAddressController extends AdminBaseController
{
    /**
     * @var UserAddressRepository
     */
    private $useraddress;

    public function __construct(UserAddressRepository $useraddress)
    {
        parent::__construct();

        $this->useraddress = $useraddress;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$useraddresses = $this->useraddress->all();

        return view('user::admin.useraddresses.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('user::admin.useraddresses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUserAddressRequest $request
     * @return Response
     */
    public function store(CreateUserAddressRequest $request)
    {
        $this->useraddress->create($request->all());

        return redirect()->route('admin.user.useraddress.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('user::useraddresses.title.useraddresses')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  UserAddress $useraddress
     * @return Response
     */
    public function edit(UserAddress $useraddress)
    {
        return view('user::admin.useraddresses.edit', compact('useraddress'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserAddress $useraddress
     * @param  UpdateUserAddressRequest $request
     * @return Response
     */
    public function update(UserAddress $useraddress, UpdateUserAddressRequest $request)
    {
        $this->useraddress->update($useraddress, $request->all());

        return redirect()->route('admin.user.useraddress.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('user::useraddresses.title.useraddresses')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  UserAddress $useraddress
     * @return Response
     */
    public function destroy(UserAddress $useraddress)
    {
        $this->useraddress->destroy($useraddress);

        return redirect()->route('admin.user.useraddress.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('user::useraddresses.title.useraddresses')]));
    }
}
