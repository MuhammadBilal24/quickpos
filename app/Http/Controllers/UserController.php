<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Mail\ForgetPassword;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\facades\Hash;
use Illuminate\Support\facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\facades\Mail;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function loginpage()
    {
        return view('auth.login');
    }
    public function registerpage()
    {
        if(session()->has('loggedInUser'))
        {
            return redirect('/dashboard');
        }
        else
        {
            return view('auth.register');            
        }
    }
    
    // Register Handle Save user method
    public function saveUser(request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:50',
                'user_type' => 'required|max:50',
                'email' => 'required|email|max:100|unique:users',
                'password' => 'required|min:6|max:50',
                'cpassword' => 'required|min:6|same:password',
            ],
            [
                'cpassword.same' => 'Password did not matched!',
                'cpassword.required' => 'Comfirm Password is required!',
            ],
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag(),
            ]);
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->user_type = $request->user_type;
            $user->save();
            return response()->json([
                'status' => 200,
                'messages' => 'Registered Successfully!',
            ]);
        }
    }
    // User Checking Ftn
    public function checkUser(request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
            'password' => 'required|min:6|max:50',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag(),
            ]);
        } else {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    // here we put data in session named (loggedInUser)
                    $request->session()->put('loggedInUser', $user->id);
                    return response()->json([
                        'status' => 200,
                        'messages' => 'success',
                    ]);
                } else {
                    return response()->json([
                        'status' => 401,
                        'messages' => 'E-mail and Password is Invalid',
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 401,
                    'messages' => 'User is Not Found',
                ]);
            }
        }
    }
    // Logout Active User
    public function logoutUser()
    {
        if(session()->has('loggedInUser'))
        {
            session()->pull('loggedInUser');
            return redirect('/');
        }    
    }
    // User Profile
    public function profilepage()
    {
        $data = ['userInfo' => DB::table('users')->where('id', session('loggedInUser'))->first()];
        return view('profile',$data);
    }
    // User Profile Image Update
    public function profileImageUpdate(request $request)
    {
        $user_id = $request->user_id;
        $user = User::find($user_id);

        if($request->hasFile('picture'))
        {
            $file = $request->file('picture');
            $fileName = time() .'.'. $file->getClientOriginalExtension(); 
            $file->storeAs('public/imgs/'.$fileName);
            
            if( $user->picture)
            {
                Storage::delete('public/imgs/'.$user->picture);
            }   
        }
        User::where('id',$user_id)->update([
            'picture'=>$fileName
        ]);
        return response()->json([
            'status'=>200,
            'messages'=>"Profile Image Uploaded",
        ]);
    }

    // User Profile Details Update
    public function profileUpdate(request $request)
    {
        User::where('id',$request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'phone' => $request->phone,
            // 'user_type'=>$request->user_type,
        ]) ;
        return response()->json([
            'status'=>200,
            'messages'=>"Profile Updated"
        ]);
    }

    // Forget Password
    public function forgetpage()
    {
        if(session()->has('loggedInUser'))
        {
            return redirect ('/dashboard');
        }
        else
        {
            return view('auth.forget');
        }
    }
    public function forgetPassword(request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'=>'required|max:100|email',
        ]);
        if($validator -> fails())
        {
            return response()->json([
                'status'=>400,
                'messages'=>$validator->getMessageBag()
            ]);
        }
        else
        {
            $token = Str::uuid();
            $user = DB::table('users')->where('email',$request->email)->first();
            $details= [
                'body' =>route('reset',['email' => $request->email, 'token' => $token]),
            ];
            if($user)
            {
                User::where('email',$request->email)->update([
                    'token'=>$token,
                    'token_expire'=> Carbon::now()->addMinutes(10)->toDateTimeString()
                ]);
                Mail::to($request->email)->send(new ForgetPassword($details));
                return response()->json([
                    'status'=>200,
                    'messages'=>"Reset Password link has been sent to your E-mail"
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>401,
                    'messages'=>"This E-mail is Not Registered"
                ]);
            }
        }
    }

    // Reset Password Functions
    public function resetpage(request $request)
    {
        $email= $request->email;
        $token= $request->token;
        return view('auth.reset',['email'=>$email, 'token'=>$token]);
    }
    public function resetPassword(request $request)
    {
        $validator = Validator::make($request->all(),[
            'npass'=>'required|min:6|max:50',
            'cnpass'=>'required|min:6|max:50|same:npass',
        ],
        [
            'cnpass.same'=>'Password did not matched',
        ]);
    if($validator->fails())
    {
        return response()->json([
            'status'=> 400,
            'messages'=>$validator->getMessageBag()
        ]);
    }
    else
    {
        $user= DB::table('users')->where('email', $request->email)->whereNotnull('token')
        ->where('token',$request->token)->where('token_expire' , '>' , 
        Carbon::now())->exists();
        if($user)
        {
            User::where('email',$request->email)->update([
                'password'=>Hash::make($request->npass),
                'token'=>null,
                'token_expire'=>null,
            ]);
            return response()->json([
                'status'=> 200,
                'messages'=>'New Password Updated &nbsp;&nbsp;&nbsp<a href="/">Login Now</a>'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>401,
                'messages'=>"Reset Link Expired! Request for Reset Password Link"
            ]);
        }
    }
    }
}
