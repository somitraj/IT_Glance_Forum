<?php

namespace IT_Glance_Forum\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use IT_Glance_Forum\Http\Controllers\Controller;
use IT_Glance_Forum\Models\MessageStatusTbl;
use IT_Glance_Forum\Models\MessageTbl;

class MessageController extends Controller
{
    public function GetMessage(Request $request){
        try{
            $uid=$request->get('id');
            $mdata = DB::table('users')
                ->join('message_tbl', 'message_tbl.sender_userid', '=', 'users.id')
               // ->join('message_tbl', 'message_tbl.receiver_userid', '=', 'users.id')
                ->join('message_status_tbl', 'message_status_tbl.message_id', '=', 'message_tbl.id')
                ->select('users.*', 'message_status_tbl.*','message_tbl.*')
                ->where('message_status_tbl.status_id', '=', 4)
                ->where('message_tbl.receiver_userid', '=', $uid)
                ->get()->toArray();

            return $mdata;
        }
         catch (\Exception $e) {
                    print_r($e->getMessage());
                    die();
                }

    }

    public function SendMessage(Request $request)
    {
        try {

            //print_r('hi');die();
            $uid = ($request->get('userId'));
            $destid = $request->get('destId');
            $msg = $request->get('msg');
            $msgtitle=$request->get('msgtitle');
            //print_r($msg);die();
            if(!$msg==''){
                $ms = new MessageTbl();
                $ms->sender_userid = $uid;
                $ms->receiver_userid = $destid;
                $ms->message = $msg;
                $ms->subject = $msgtitle;
                $ms->save();

                $m_stat=new MessageStatusTbl();
                $m_stat->message_id=$ms->id;
                $m_stat->status_id=4;
                $m_stat->save();
            }

        } catch (\Exception $e) {
            print_r($e->getMessage());
            die();
        }

    }
    public function ViewFullMessage(Request $request){
        try{
            $mid=$request->get('messageid');
                $mupdte = DB::table('message_status_tbl')
                    ->where('message_id', $mid)
                    ->update(['status_id' => 3
                    ]);

            $mdata = DB::table('users')
                ->join('message_tbl', 'message_tbl.sender_userid', '=', 'users.id')
                // ->join('message_tbl', 'message_tbl.receiver_userid', '=', 'users.id')
                ->join('message_status_tbl', 'message_status_tbl.message_id', '=', 'message_tbl.id')
                ->select('users.*', 'message_status_tbl.*','message_tbl.*')
                ->where('message_tbl.id', '=', $mid)
                ->get()->toArray();

            return $mdata;
            //return $mid;
        }
         catch (\Exception $e) {
                    print_r($e->getMessage());
                    die();
                }
    }
    public  function ViewSentMessage(Request $request){
        try{
            $uid=$request->get('uid');
            $sentdata = DB::table('users')
                ->join('message_tbl', 'message_tbl.receiver_userid', '=', 'users.id')
                // ->join('message_tbl', 'message_tbl.receiver_userid', '=', 'users.id')
                ->join('message_status_tbl', 'message_status_tbl.message_id', '=', 'message_tbl.id')
                ->select('users.*', 'message_status_tbl.*','message_tbl.*')
                ->where('message_status_tbl.status_id', '=', 4)
                ->where('message_tbl.sender_userid', '=', $uid)
                ->get()->toArray();

            return $sentdata;

        }
         catch (\Exception $e) {
                    print_r($e->getMessage());
                    die();
                }

    }

    public  function ViewSeenMessage(){
        try{
        }
        catch (\Exception $e) {
            print_r($e->getMessage());
            die();
        }

    }
}
