<?php

namespace Modules\User\Http\Controllers;

use AjaxResponse;
use Modules\Core\Http\Controllers\BasePublicController;

use Illuminate\Http\Request;
use Modules\User\Entities\Region;


class RegionController extends BasePublicController
{
    //获取所有的国家
    public function getAllCountries()
    {
        $countries = Region::where('level',2)->get();
        return AjaxResponse::success('',$countries);
    }
    //根据国家获取州县列表
    public function getAllProvinces($countryId)
    {
        $provinces = Region::where([
            'level' => 3,
            'pid' => $countryId
        ])->get();
        return AjaxResponse::success('',$provinces);
    }

    //根据州县获取城市列表
    public function getAllCities($provinceId)
    {
        $cities = Region::where([
            'level' => 4,
            'pid' => $provinceId
        ])->get();
        return AjaxResponse::success('',$cities);
    }
}
