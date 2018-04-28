<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\Entities\UserRegion;
use Modules\User\Http\Requests\CreateUserRegionRequest;
use Modules\User\Http\Requests\UpdateUserRegionRequest;
use Modules\User\Repositories\UserRegionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class UserRegionController extends AdminBaseController
{
    /**
     * @var UserRegionRepository
     */
    private $userregion;

    public function __construct(UserRegionRepository $userregion)
    {
        parent::__construct();

        $this->userregion = $userregion;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$userregions = $this->userregion->all();

        return view('user::admin.userregions.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('user::admin.userregions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUserRegionRequest $request
     * @return Response
     */
    public function store(CreateUserRegionRequest $request)
    {
        $this->userregion->create($request->all());

        return redirect()->route('admin.user.userregion.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('user::userregions.title.userregions')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  UserRegion $userregion
     * @return Response
     */
    public function edit(UserRegion $userregion)
    {
        return view('user::admin.userregions.edit', compact('userregion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserRegion $userregion
     * @param  UpdateUserRegionRequest $request
     * @return Response
     */
    public function update(UserRegion $userregion, UpdateUserRegionRequest $request)
    {
        $this->userregion->update($userregion, $request->all());

        return redirect()->route('admin.user.userregion.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('user::userregions.title.userregions')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  UserRegion $userregion
     * @return Response
     */
    public function destroy(UserRegion $userregion)
    {
        $this->userregion->destroy($userregion);

        return redirect()->route('admin.user.userregion.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('user::userregions.title.userregions')]));
    }
}
