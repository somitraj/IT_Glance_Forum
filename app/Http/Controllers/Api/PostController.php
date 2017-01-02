<?php

namespace IT_Glance_Forum\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use IT_Glance_Forum\Http\Controllers\Controller;
use IT_Glance_Forum\Models\PostTbl;

class PostController extends Controller
{
    public function ForumPost(Request $request){
        try{
            $uid=$request->get('uid');
            //return $uid;
            $title= $request->get('posttitle');
            $body= $request->get('postbody');
            $cid= $request->get('category_id');


            $pos=new PostTbl();
            $pos->setAttribute('post_title', $title);
            $pos->setAttribute('post_body', $body);
            $pos->category_id = $cid;
            $pos->status_id = 4;
            $pos->setAttribute('user_id', $uid);
            $pos->save();

        }
         catch (\Exception $e) {
                    print_r($e->getMessage());
                    die();
                }

    }
    public function GetPostDetails($id)
    {
        try {
            $postdetails = PostTbl::where('id', '=', $id)
                ->first();
            return $postdetails;
        } catch (\Exception $e) {
            print_r($e->getMessage());
            die();
        }

    }
    public function PostApprove($id)
    {
        try {
            //return $id;
                $post = DB::table('post_tbl')
                    ->where('id', $id)
                    ->update(['status_id' => 3
                    ]);


        } catch (\Exception $e) {
            print_r($e->getMessage());
            die();
        }

    }
}