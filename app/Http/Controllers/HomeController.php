<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Guzzel\GuzzelRequest;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $accessToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ijk2Y2Y0NzFkN2E1NDY1YTNmODRhNWYxYjI2ZmQ4YWRhMzEwN2U5OWVlZTRiODZlMmQ5ZWExZjFjMGE5NmMwZTMxODUzNmNkMGY0ODg2MDhkIn0.eyJhdWQiOiIxIiwianRpIjoiOTZjZjQ3MWQ3YTU0NjVhM2Y4NGE1ZjFiMjZmZDhhZGEzMTA3ZTk5ZWVlNGI4NmUyZDllYTFmMWMwYTk2YzBlMzE4NTM2Y2QwZjQ4ODYwOGQiLCJpYXQiOjE1MTg1NjE2ODYsIm5iZiI6MTUxODU2MTY4NiwiZXhwIjoxNTUwMDk3Njg2LCJzdWIiOiI3Iiwic2NvcGVzIjpbXX0.rf0ZnA0af5Gg7Io_7-gj8AzIkoGiFH0VGhFQgaoHSPnsPa_7SeaBntRqkaap0QZMAZ4KWCTVAUx-1hiHKcfl9NruVmgXgbFyuXXZBu5Oh_F1FGf0GC4ntt3jq7jlHrV8zU5dzk3PEDtf-YHXoAjiqV8ONtpVDXfVRqBXu8pi_11zM0DqTlpKds6Ay9hmsUCyU3sYJcyvFTEQnnkaW9TUFH6jF4g2nimeTJia0EjY1K_eyLF2OXKngfs8Cpo_yN4mFcedPHT7l1r6PyvK0Rtk_svc8A4USgDyMCNpPS1HBRm8B5jxWPyKSNhXMCniri4PmEP9RHQPXzpaHor3Koh4R0O4pb-OSAk0Tn4MFVgbQOJNPQzW8H9gx1xOGqQQ3RjTVz9HskAYVIcTfK3lZm0r6ZpmytHilQoRupHgVb3998qp1AF-XXTyKd4Y8w1VbD_vZRdFwrl3fHgSvBPiGDLthctMz1xeN9Cgjf_KTJYkZ1v1KwfPAy7EsBJrozCmw8alp9GpRsU4QnHQIEK6ewemyhtkFgk2rZ8cpkYx8Dm5YMiwQZoqax9GBmdHD6RiIqHF0dw7n8UPWu9mTVmAgQ8xldW1QPhhTB9pQX19dS44mqwl30X59NEFleTW18EZTrmEYqLoFxYmJkqiL7iY7xC_bi7LBZM8qGZLrohfeT8a9hU';

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function APILogin(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $email = $request->input('email'); //'admin@basket.com'; // it should be $request->input('email');
        $password = $request->input('password'); //'123456'; // it should be $request->input('password');

        $guzzel = new GuzzelRequest();
        $token = $guzzel->APILogin($email, $password);
        $this->accessToken = $token;
        return response()->json(['token'=>$token]);
    }

    public function APIRegister(Request $request){
        $guzzel = new GuzzelRequest();
        $token = $guzzel->APIRegister($request);
        return response()->json(['token'=>$token]);
    }

    public function manipulator(Request $request){

        $filters = $request->all();

        $guzzel = new GuzzelRequest();
        return $guzzel->manipulator($this->accessToken, $filters);
    }


}
