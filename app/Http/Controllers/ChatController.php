<?php

namespace App\Http\Controllers;
use App\Models\Chat;
use App\Models\Member;
use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    //
    public function index($id){
        
        $groups = DB::table('members')->leftJoin('groups','groups.group_id','=','members.group_id')->where('members.user_id','=', session('user_id'))->get();
        $members = DB::table('members')
        ->leftJoin('users', 'users.user_id', '=', 'members.user_id')
        ->where('members.group_id', '=', $id)
        ->select('users.name', 'users.email')->get(); 
        $data = compact('groups','members');
     
        return view('frontend.main.group')->with($data);
    }

    public function store(Request $request){
        $chat = new Chat();
        $chat -> user_id = session('user_id');
        $chat->group_id = $request->input('group_id');
        $chat->message = $request->input('message');
        $chat -> save();
        return response()->json([]);
    }

    public function fetch($id){
        $chats = DB::table('chats')->leftJoin('users','users.user_id','=','chats.user_id')->where('group_id','=',$id)->get();
        return response()->json(['messages'=>$chats]);
    }


}
