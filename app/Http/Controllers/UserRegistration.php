<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Support\Facades\File;
use Auth;
use Redirect;
use DataTables;

class UserRegistration extends Controller
{
    //
    public function index(Request $request){
        $doctor_list = User::where('role','Doctor')->get();

        return view("welcome",compact('doctor_list'));
    }

    public function signup(Request $request){
        $doctor_list = User::where('role','Doctor')->get();

        return view("signup",compact('doctor_list'));
    }

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email', 
            'password' => 'required',
        ]); 

        if ($validator->fails())
        { 
            return response()->json(['error'=>$validator->errors()->all(),'code' => 422]);

        } else {

            $userdata = array(
                'email' => $request->email,
                'password' => $request->password
            );

            if (Auth::attempt($userdata))
            {
                return response()->json(["status"=>true,"msg"=>"Login successfull",'code' => 200]);  
            }else{
                //
                return response()->json(["status"=>false,"msg"=>"Login details Invalid",'code' => 404]);  
                // return response()->json(["status"=>false,"msg"=>"Login successfully",'code' => 200]);  
            }

        }
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect('/');
    }


    public function add_update(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
            'email' => 'required|email|unique:users,email', 
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
           

        ]); 


        if ($validator->fails())
        { 
            return response()->json(['error'=>$validator->errors()->all(),'code' => 422]);

        } else {

                $user_reg = User::create([
                    'name' =>  $request->name,
                    'email' =>  $request->email,
                    'password' =>  bcrypt($request->password),
                    'role' => 'Patient'
                ]);
        }

        return response()->json(["status"=>true,"msg"=>"You have successfully registered",'code' => 200]);  
        
    }   


    public function without_login_appointment(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
            'email' => 'required|email', 
            'app_dr_name' => 'required',
            'app_date' => 'required',
            'app_time' => 'required',
        ]); 

        if ($validator->fails())
        { 
            return response()->json(['error'=>$validator->errors()->all(),'code' => 422]);

        } else {

                $check_user = User::where('email',$request->email)->first();

                if($check_user){

                    $check_appointment = Appointment::where('user_id',$check_user->id)->where('date',$request->app_date)->first();

                    if($check_appointment){

                        return response()->json(["status"=>false,"msg"=>"Your One Appointment Already Booked",'code' => 202]);  
    
                    }else{

                        $book_app = Appointment::create([
                            'user_id' =>  $check_user->id,
                            'doctor_id' =>  $request->app_dr_name,
                            'date' =>  $request->app_date,
                            'time' =>  $request->app_time,
                        ]);
    
                        return response()->json(["status"=>true,"msg"=>"Appointment Booked successfully",'code' => 200]); 

                    }

                }else{

                    $user_reg = User::create([
                        'name' =>  $request->name,
                        'email' =>  $request->email,
                        'password' =>  bcrypt($request->password),
                        'role' => 'Patient'
                    ]);


                    $book_app = Appointment::create([
                        'user_id' =>  $user_reg['id'],
                        'doctor_id' =>  $request->app_dr_name,
                        'date' =>  $request->app_date,
                        'time' =>  $request->app_time,
                    ]);



                    return response()->json(["status"=>true,"msg"=>"Appointment Booked successfully",'code' => 200]); 
                }
        }
    }



    public function all_user_data(Request $request){

        return view("user_data");
    }

    public function get_all_user_data(Request $request){
        $get_data = User::get();

        return Datatables::of($get_data)
         ->addIndexColumn()
        
         ->addColumn('action', function($row){
 
                 $btn = '<a href="javascript:void(0)" onclick="delete_user_rec('.$row->id.')" class="edit btn btn-primary btn-sm">Delete</a>';
 
                 return $btn;
         })
         ->rawColumns(['action'])
         ->make(true);
    }

    public function deleteUserRecord(Request $request,$id){
        $del_rec = User::where('id', $id)->delete();
 
        return response()->json(["status"=>true,"msg"=>'Record successfully Deleted.','code' => 200]);  
    }

}
