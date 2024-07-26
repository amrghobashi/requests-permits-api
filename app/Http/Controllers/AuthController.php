<?php

namespace App\Http\Controllers;

use App\Models\CompanyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{

    public function login(Request $request)
    {
        $user = CompanyUser::where('user_name', $request['email'])->where('user_pass', $request['password'])->where('active', 1)->first();
        if (!$user) {
            return response()->json([
                'message' => 'INVALID_CREDENTIALS'
            ], 401);
        }

        $user = CompanyUser::where('user_name', $request['email'])->firstOrFail();

        $token = $user->createToken('authToken')->plainTextToken;
        $routes = DB::select("select routes.route_id, route_name from routes, user_type_routes
          where user_type_routes.route_id = routes.route_id and user_type_routes.user_type_id = ?", [$user->admin_flag]);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'company_id' => $user->company_id,
            'admin_flag' => +$user->admin_flag,
            'expiry_time' => 60, // expiry time sent in minutes
            'routes' => $routes
        ]);
    }

    public function get_routes(Request $request)
    {
        $admin_flag = auth('sanctum')->user()->admin_flag;
        return $routes = DB::select("select routes.route_id, routes.route_name, user_type_routes.USER_TYPE_ID from routes, user_type_routes
          where user_type_routes.route_id = routes.route_id
          and user_type_routes.user_type_id = ?", [$admin_flag]);
    }

    public function logout(Request $request)
    {
        Session::flush();
        return $request->user()->currentAccessToken()->delete();
    }

    public function change_password(Request $request)
    {
        $company_id = auth()->user()->company_id;
        $old_password = $request->oldPassword;
        $new_password = $request->newPassword;
        $confirm_new_password = $request->confirmNewPassword;
        if ($new_password != $confirm_new_password) {
            return response()->json([
                'message' => 'WRONG_NEW_PASSWORD'
            ], 401);
        } else {
            $original_password = CompanyUser::where('company_id', $company_id)->select('user_pass')->get();
            if ($original_password[0]['user_pass'] != $old_password) {
                return response()->json([
                    'message' => 'WRONG_PASSWORD'
                ], 401);
            } else {
                $companyUser = companyUser::where('company_id', '=', $company_id);
                $companyUser->update(['user_pass' => $new_password]);
            }
        }
    }
}
