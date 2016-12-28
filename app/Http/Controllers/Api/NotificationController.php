<?php

namespace IT_Glance_Forum\Http\Controllers\Api;

use Illuminate\Http\Request;
use IT_Glance_Forum\Http\Controllers\Controller;
use IT_Glance_Forum\Models\Users;

class NotificationController extends Controller
{
    public function GetUserNotice(){
        try{
           /* $user = DB::table('users')
                ->join('userinfo_tbl', 'userinfo_tbl.user_id', '=', 'users.id')
                ->select('users.*', 'userinfo_tbl.*')
                ->where('users.status_id', '=', 0)
                ->get();

            return $user;*/

            $user = Users::where('status_id', '=', 0)->get()->toArray();
            return $user;
        }
         catch (\Exception $e) {
                    print_r($e->getMessage());
                    die();
                }

    }
}