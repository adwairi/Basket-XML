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

    private $accessToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjAxZTc5NGJkNGIxNjliNTc3ZDk5ZjE0ZDljZmRiODBhOTRjMzA0NjE5OTFmZWVmMTJjOTJiYzk2NTBmOTExZDI2MTkxYmY5MGM3MmI2MGQwIn0.eyJhdWQiOiIxIiwianRpIjoiMDFlNzk0YmQ0YjE2OWI1NzdkOTlmMTRkOWNmZGI4MGE5NGMzMDQ2MTk5MWZlZWYxMmM5MmJjOTY1MGY5MTFkMjYxOTFiZjkwYzcyYjYwZDAiLCJpYXQiOjE1MTg0ODQzNDksIm5iZiI6MTUxODQ4NDM0OSwiZXhwIjoxNTUwMDIwMzQ5LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.pyHr7dEJMzj_PG68gDdpoqD8KkHaxGu6cqIOxPglNOpJNkcWQkkq6OMapEmyb29S2CM6zo7QuR9Jq_0VJF-Pzf4ak0McgzLkLoJYICuCu6Iwqv5S1kAzj2fxDo0TJEWYQZM1pgxPNDOlpqba7vqcXQk02ID-QrI-FAldCZpSVuh91jFn_X39emECp959vFRmVmY9yfReGPbIBAQEOxRQdJkjrFS2HNm2ycHTzQ_J16i8kELtBdZw5JkTCjw-7mjyCT7OyNIcezm4QgWXX65nyh_3hHlYhGbm_i1j7pPFUtH0iN0ugIERYb-8NCmjpiykS8A408w2wd3wwUGTikR8DtpxfCMNI-UnECCJVrQqlRfZBlTQ-U8P78oqyP5RLbG5wKQvft4Hmgyg4q4ctpDN2ObDO_Sli51_yTVpaKXFAXbAmTACCDrIArZ2Xb79IdFhBzo1rKr627Jj1KcURPXtzxECNda4w66DykmJNOggJKuuP3XyECeGFTGO9zHQkHXBE4YrXyi7I3IuSXV3569VyDWz2peMKmVLPlb0QRSeXPE8-bnF9x4Wy5DHpjEIdY0BfYa_U5_rPPeZ3KEsJkIZASawrLAHNlkG2UMHnHbjDeUPu5YjxUWDWA0y5oB9Somsqfn5uZCIqlvgYPDqML1lgF6A5d68Dxn3Ff3SEpUNUiI';

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

    public function getToken(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $email = 'admin@basket.com'; // it should be $request->input('email');
        $password = '123456'; // it should be $request->input('password');

        $guzzel = new GuzzelRequest();
        $token = $guzzel->getToken($email, $password);
        return $token;
    }

    public function manipulator(Request $request){

        $filters = $request->all();

        $guzzel = new GuzzelRequest();
        return $guzzel->manipulator($this->accessToken, $filters);
    }


}
