<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;
use Illuminate\Support\Facades\Auth;

class ResponseController extends Controller
{
    public function is_require($data, $field)
	{

		$response = [
			'result'  => 'Failure1',
			'message' => $field." field is required",
		];

		if($data){
			return $data;
		}

		http_response_code(400);
		echo json_encode($response); exit;
    }

	public function responseOk($message, $data = null)
	{

		$response = [
			'result'  => 'Success',
			'message' => $message,
		];

		$data ? $response['data'] = $data : null;

		http_response_code(200);
		echo json_encode($response); exit;
	}

	public function responseWithError($message=null)
	{

	    http_response_code(400);
	   	$message = $message ? $message : "Something went wrong. Please try again later!";
	    echo json_encode(['result' => 'Failure', 'message' => $message]); exit;
	}

	public function responseWithErrorCode($message=null, $code)
	{

	    http_response_code($code);
	   	$message = $message ? $message : "Something went wrong. Please try again later!";
	    echo json_encode(['result' => 'Failure', 'message' => $message]); exit;
	}


	public function uploadImage($image, $destinationPath)
    {
        $imageName = date('mdYHis') . uniqid().'.'.$image->getClientOriginalExtension();
        $image->move($destinationPath, $imageName);

        return $imageName;
    }

    public function is_validationRule($data, $request){
    	//return $data['validation'];
    	$validator = Validator::make($request->all(),$data['validation'], $data['message']);

    	if($validator->fails()){
            return $this->responseWithError($validator->errors()->first());
        }
    }

    public function is_validationRuleArray($data, $request){
    	//return $data['validation'];
    	$validator = Validator::make($request,$data['validation'], $data['message']);

    	if($validator->fails()){
            return $this->responseWithError($validator->errors()->first());
        }
    }

    public function is_validationRuleWeb($data, $request){
    	//return $data['validation'];
    	$validator = Validator::make($request->all(),$data['validation'], $data['message']);

    	if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
    }

    public function is_validationRuleWebAjax($data, $request){
    	//return $data['validation'];
    	$validator = Validator::make($request->all(),$data['validation'], $data['message']);


    	$validator = $this->validate($request,$data['validation'], $data['message']);

        return response()->json($validator, 422);

    }
}
