<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\Appointment;
use Illuminate\Support\Facades\File;
use Auth;
use Redirect;
use DataTables;

class AppointmentController extends Controller
{
    //
    public function index(Request $request){

      $doctor_list = User::where('role','Doctor')->get();

        return view("appointment",compact('doctor_list'));
    }

    public function add_update(Request $request){

        $validator = Validator::make($request->all(), [
            'app_dr_name' => 'required',
            'app_date' => 'required',
            'app_time' => 'required',
        ]); 

        if ($validator->fails())
        { 
            return response()->json(['error'=>$validator->errors()->all(),'code' => 422]);

        } else {

            if(isset($request->id)){

                $check_appointment = Appointment::where('user_id',Auth::user()->id)->where('date',$request->app_date)->where('id','!=',$request->id)->first();

                if($check_appointment){

                    return response()->json(["status"=>false,"msg"=>"One Appointment Already Booked",'code' => 202]);  

                }else{

                    Appointment::where('id', $request->id)
                    ->update([
                        'doctor_id' =>  $request->app_dr_name,
                        'date' =>  $request->app_date,
                        'time' =>  $request->app_time,
                    ]);

                    return response()->json(["status"=>true,"msg"=>"Appointment Updated successfully",'code' => 200]);  
                }

            }else{

                $check_appointment = Appointment::where('user_id',Auth::user()->id)->where('date',$request->app_date)->first();

                if($check_appointment){

                    return response()->json(["status"=>false,"msg"=>"One Appointment Already Booked",'code' => 202]);  

                }else{
            
                    $user_reg = Appointment::create([
                        'user_id' =>  Auth::user()->id,
                        'doctor_id' =>  $request->app_dr_name,
                        'date' =>  $request->app_date,
                        'time' =>  $request->app_time,
                    ]);

                    return response()->json(["status"=>true,"msg"=>"Appointment Booked successfully",'code' => 200]);  
                }
            }
        }

    }


    public function getAppointmentData(Request $request){

        if(Auth::user()->role == 'Patient')
        {
            $get_data = Appointment::with('getPatient')->with('getDoctor')->where('user_id',Auth::user()->id)->get();
        }else if(Auth::user()->role == 'Doctor'){
            $get_data = Appointment::with('getPatient')->with('getDoctor')->where('doctor_id',Auth::user()->id)->get();
        }else{
            $get_data = Appointment::with('getPatient')->with('getDoctor')->get();
        }

        return Datatables::of($get_data)
         ->addIndexColumn()
         ->addColumn('dr_name', function($row){
 
                $dr_name = (isset($row['getDoctor'][0]->name) ? $row['getDoctor'][0]->name : '' );

                return $dr_name;
        })
        ->addColumn('patient_name', function($row){
 
                $patient_name = (isset($row['getPatient'][0]->name) ? $row['getPatient'][0]->name : 'Guest Patient') ;

                return $patient_name;
        })

        ->addColumn('status', function($row){

            if(Auth::user()->role == 'Patient'){
                if($row->status == 1){
                    $status = 'Confirmed';
                }else{
                    $status = 'Pending';
                }
            }else{
                if($row->status == 1){
                    $status = '<a href="javascript:void(0)" onclick="change_status('.$row->id.',`0`)" class="edit btn btn-success btn-sm">Confirmed</a>';
                }else{
                    $status = '<a href="javascript:void(0)" onclick="change_status('.$row->id.',`1`)" class="edit btn btn-primary btn-sm">Pending</a>';
                }
            }

                return $status;
        })
       
         ->addColumn('action', function($row){
 
                 $btn = '<a href="javascript:void(0)" onclick="get_update_data('.$row->id.')" class="edit btn btn-primary btn-sm">Edit</a> <a href="javascript:void(0)" onclick="delete_rec('.$row->id.')" class="edit btn btn-primary btn-sm">Delete</a>';
 
                 return $btn;
         })
         ->rawColumns(['status','action'])
         ->make(true);
    }


    public function deleteRecord(Request $request,$id){
        $del_rec = Appointment::where('id', $id)->delete();
 
         return response()->json(["status"=>true,"msg"=>'Record successfully Deleted.','code' => 200]);  
     }

     public function getRecord(Request $request,$id){
        $get_rec = Appointment::where('id', $id)->first();

        return response()->json(["status"=>true,"data"=>$get_rec,'code' => 200]);  
    }

    public function changeStatus(Request $request,$id,$type){
        Appointment::where('id', $id)
        ->update([
            'status' =>  $type,
        ]);

        return response()->json(["status"=>true,"msg"=>'Status Change successfully.','code' => 200]);  
    }
}
