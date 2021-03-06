<?php

namespace IT_Glance_Forum\Http\Controllers\api;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use IT_Glance_Forum\Http\Controllers\Controller;
use IT_Glance_Forum\Models\AddressTbl;
use IT_Glance_Forum\Models\MessageTbl;
use IT_Glance_Forum\Models\UserinfoTbl;
use IT_Glance_Forum\Models\Users;
use IT_Glance_Forum\Models\UsersTbl;
use IT_Glance_Forum\Models\UsertypeTbl;


/**
 * Class UserController
 * @package IT_Glance_Forum\Http\Controllers\api
 */
class UserController extends Controller
{
    /**
     * @param Request $request
     * @throws \Exception
     */
    public function ApplicationSubmit(Request $request)
    {
        try {
            //return $request->all();
            $user = new Users();
            $user->setAttribute('email', $request->get('email'));
            $user->status_id = 0;
            $user->save();

            $address = new AddressTbl();
            $address->country_id = $request->country_id;
            $address->province_id = $request->province_id;
            $address->zone_id = $request->zone_id;
            $address->district_id = $request->district_id;
            $address->city_id = $request->city_id;


            $userinfo = new UserinfoTbl();
            $userinfo->setAttribute('user_id', $user->id);
            $userinfo->setAttribute('fname', $request->get('fname'));
            $userinfo->setAttribute('mname', $request->get('mname'));
            $userinfo->setAttribute('lname', $request->get('lname'));
            $userinfo->setAttribute('dob', $request->get('dob'));
            $userinfo->setAttribute('gender', $request->get('gender'));
            $userinfo->setAttribute('email', $user->email);
            $userinfo->phone_no = $request->phone_no;
            $userinfo->mobile_no = $request->mobile_no;
            $userinfo->setAttribute('college', $request->get('college'));
            $userinfo->course_type_id = $request->course_type_id;
            $userinfo->language_type_id = $request->language_type_id;
            $userinfo->setAttribute('whylanguage', $request->get('whylanguage'));
            $userinfo->address_id = $address->id;
            $userinfo->save();

        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @return array
     */
    public function GetUserTypeList()
    {
        try {
            $usertype = UsertypeTbl::all('id', 'user_type')->toArray();
            return $usertype;
        } catch (\Exception $e) {
            print_r($e->getMessage());
            die();
        }

    }

    /**
     * @param $id
     * @return mixed
     */
    public function GetUserDetails($id)
    {
        try {
            $userdetails = UserinfoTbl::where('user_id', '=', $id)
                ->first();
            return $userdetails;
        } catch (\Exception $e) {
            print_r($e->getMessage());
            die();
        }

    }

    /**
     * @return mixed
     */
    public function GetAllMemberList()
    {
        try {
            $useraccount = DB::table('userinfo_tbl')
                ->join('users', 'users.id', '=', 'userinfo_tbl.user_id')
                ->select('users.*', 'userinfo_tbl.*')
                ->where('status_id', '=', 1)
                ->get()->toArray();
            return $useraccount;
            /*$user = Users::where('status_id', '=', 1)->get()->toArray();
            return $user;*/
        } catch (\Exception $e) {
            print_r($e->getMessage());
            die();
        }
    }

    /**
     * @return mixed
     */
    public function GetInternList()
    {
        try {
            $interns = DB::table('userinfo_tbl')
                ->join('users', 'users.id', '=', 'userinfo_tbl.user_id')
                ->select('users.*', 'userinfo_tbl.*')
                ->where('status_id', '=', 1)
                ->where('user_type_id', '=', 4)
                ->get()->toArray();
            return $interns;
            /*$user = Users::where('status_id', '=', 1)->get()->toArray();
            return $user;*/
        } catch (\Exception $e) {
            print_r($e->getMessage());
            die();
        }
    }

    /**
     * @return mixed
     */
    public function GetSubmentorList()
    {
        try {
            $submentor = DB::table('userinfo_tbl')
                ->join('users', 'users.id', '=', 'userinfo_tbl.user_id')
                ->select('users.*', 'userinfo_tbl.*')
                ->where('status_id', '=', 1)
                ->where('user_type_id', '=', 3)
                ->get()->toArray();
            return $submentor;
            /*$user = Users::where('status_id', '=', 1)->get()->toArray();
            return $user;*/
        } catch (\Exception $e) {
            print_r($e->getMessage());
            die();
        }
    }

    /**
     * @return mixed
     */
    public function GetAdminList()
    {
        try {
            $admin = DB::table('userinfo_tbl')
                ->join('users', 'users.id', '=', 'userinfo_tbl.user_id')
                ->select('users.*', 'userinfo_tbl.*')
                ->where('status_id', '=', 1)
                ->where('user_type_id', '=', 1)
                ->get()->toArray();
            return $admin;
        } catch (\Exception $e) {
            print_r($e->getMessage());
            die();
        }
    }

    /**
     * @return mixed
     */
    public function GetMentorList()
    {
        try {
            $mentor = DB::table('userinfo_tbl')
                ->join('users', 'users.id', '=', 'userinfo_tbl.user_id')
                ->select('users.*', 'userinfo_tbl.*')
                ->where('status_id', '=', 1)
                ->where('user_type_id', '=', 2)
                ->get()->toArray();
            return $mentor;
        } catch (\Exception $e) {
            print_r($e->getMessage());
            die();
        }
    }

    /**
     * @param $id
     */
    public function UserApprove($id)
    {
        try {
            $user = Users::where('id', '=', $id)->first();
            $userinfo = UserinfoTbl::where('user_id', '=', $id)->first();
            if ($userinfo->fname && $userinfo->lname) {
                $uname = $userinfo->fname . $userinfo->lname . rand();
            } else {
                $uname = $userinfo->fname . $userinfo->lname;
            }
            if ($user->status_id == 0) {
                $user = DB::table('users')
                    ->where('id', $id)
                    ->update(['status_id' => 1, 'user_type_id' => 4,
                        'username' => $uname, 'password' => bcrypt($userinfo->fname)
                    ]);
            }

        } catch (\Exception $e) {
            print_r($e->getMessage());
            die();
        }

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function GetUserProfile(Request $request)
    {
        try {
            $uid = $request->get('id');
            $uinfo = DB::table('userinfo_tbl')
                ->join('users', 'users.id', '=', 'userinfo_tbl.user_id')
                ->join('usertype_tbl', 'usertype_tbl.id', '=', 'users.user_type_id')
                ->join('course_tbl', 'course_tbl.id', '=', 'userinfo_tbl.course_type_id')
                ->join('language_tbl', 'language_tbl.id', '=', 'userinfo_tbl.language_type_id')
                ->select('users.*', 'userinfo_tbl.*', 'course_tbl.*', 'language_tbl.*', 'usertype_tbl.*')
                ->where('user_id', '=', $uid)
                ->get()->toArray();
            return $uinfo;
        } catch (\Exception $e) {
            print_r($e->getMessage());
            die();
        }

    }

    public function CommitUserEdit(Request $request)
    {
        try {
            //return $request->all();
            $uid = $request->get('user_id');
            $f = $request->get('fname');
            $l = $request->get('lname');
            $un = $request->get('username');
            $dob = $request->get('dob');
            $ph = $request->get('phone_no');
            $mn = $request->get('mobile_no');
            $e = $request->get('email');
            $col = $request->get('college');

            $user = Users::where('id', '=', $uid)->first();
            $user->setAttribute('username', $un);
            $user->setAttribute('email', $e);

            $userinfo = UserinfoTbl::where('user_id', '=', $uid)->first();
            $userinfo->setAttribute('fname', $f);
            $userinfo->setAttribute('lname', $l);
            $userinfo->setAttribute('dob', $dob);
            $userinfo->setAttribute('phone_no', $ph);
            $userinfo->setAttribute('mobile_no', $mn);
            $userinfo->setAttribute('email', $e);
            $userinfo->setAttribute('college', $col);
            $userinfo->save();
        } catch (\Exception $e) {
            print_r($e->getMessage());
            die();
        }

    }


}

