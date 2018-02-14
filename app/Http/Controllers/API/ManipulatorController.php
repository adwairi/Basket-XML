<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\ExpandManiPulator; // use this model in case you need to add new file structure.
class ManipulatorController extends Controller
{
    public $successStatus = 200;

    public function getDetails()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

    public function handler(Request $request){

        $this->validator($request);
        $filters = $request->all();
        $manipulator = new ExpandManiPulator($filters);
        $output = $manipulator->getResult();
        return $output;
    }

    public function validator($request){
        $validator = Validator::make($request->all(), [
            'HotelName' => 'string',
            'IsReady' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
    }
}
