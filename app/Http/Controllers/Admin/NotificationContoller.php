<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Notification;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationContoller extends Controller
{
    public function send_user($id)
    {
        $user = User::findorFail($id);
        return view('admin.notification.send_user',compact('user'));
    }
    public function send_user_post(Request $request ,$id)
    {
        $request->validate(['title'=>'required','body'=>'required']);
        try{
            Notification::send($request->title,$request->body,null,$id);
            return redirect()->back()->with(['status'=>'notification has been send successfully']);
        }
        catch (\Exception $e){
            return redirect()->back()->with(['error'=>$e->getMessage()]);
        }
    }
    public function send_users()
    {
        $users_count = User::select('fcm')->where('fcm','!=',null)->count();
        return view('admin.notification.send_users',compact('users_count'));
    }
    public function send_users_post(Request $request)
    {
        $request->validate(['title'=>'required','body'=>'required']);
        try{
            Notification::sendall($request->title,$request->body);
            return redirect()->back()->with(['status'=>'notification has been send successfully']);
        }
        catch (\Exception $e){
            return redirect()->back()->with(['error'=>$e->getMessage()]);
        }
    }
}
