<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyUserCollection;
use App\Models\CompanyUser;
use Illuminate\Http\Request;

class CompanyUserController extends Controller
{
    public function index()
    {
        $company = CompanyUser::join('COMPANY', 'company_users.company_id', '=', 'COMPANY.company_id')
            ->where('admin_flag', 3)
            ->orderBy('active', 'asc')->get();
        return new CompanyUserCollection($company);
    }

    public function show($id)
    {
        $comp_name = companyUser::join('COMPANY', 'COMPANY.company_id', 'COMPANY_USERS.company_id')
            ->where('COMPANY.company_id', '=', $id)->get('COMPANY.company_name')[0];
        return $comp_name;
    }

    public function update(Request $request, CompanyUser $companyUser)
    {
        $companyUser = companyUser::where('company_id', '=', $request->company_id);
        $companyUser->update(['active' => $request->active_flag]);
    }
}
