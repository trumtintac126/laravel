<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/19/2019
 * Time: 9:55 PM
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;

use \App\Http\Requests\RegisterRequest;
use Core\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use JWTAuth;

class UserController extends Controller
{
    protected $user_service;

    public function __construct(UserService $service)
    {
        $this->user_service = $service;
    }

    /**
     * Display a listing of the resource
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try
        {
            $data_user = $this->user_service->paginate();
            $code = 200;
            $message = "Success";
            $data = array(
                'total' => count($data_user),
                'list' => $data_user
            );

        }catch (\Exception $e)
        {
            $code = 403;
            $message = "Access Denied Exception";
            $data = null;
        }
        return response()->json([
           "result_code"    =>$code,
           "result_message" =>$message,
           "data"           =>$data
        ], $code);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try
        {
            DB::transaction(function () use ($request){
                //validate email if exists
                $email = $this->user_service->findWhere(["email" => $request->email]);
                if($email){
                    throw  new \Exception("Email is exists",2);
                }else
                {

//                    $validator = Validator::make($request->all(), [
//                        'email' => 'required|email',
//                        'password' => 'required|min:6',
//                        'first_name' => 'required|max:50',
//                        'last_name' => 'required|max:50',
//
//                    ]);
//
//                    if ($validator->fails()) {
//                        //throw  new \Exception("Error",2);
//                        return response()->json(["error" => $validator->errors()], 402);
//                    }

                    //insert data to table

                    $data_user = $request->all();

                    $data_user = [
                        "email"             => $request->email,
                        "password"          => bcrypt($request->password),
                        "first_name"        => $request->first_name,
                        "last_name"         => $request->last_name,
                        "status"            => true,
                        "role"              => 1,
                        "remember_token"    => null
                    ];

                    $user = $this->user_service->store($data_user);
                }
            });

            $code = 200;
            $message = "Success";
            $data = "Insert success!";

        }
        catch (\Exception $e)
        {
            if ($e->getCode() === 2) {
                $message = $e->getMessage();
            } else {
                $message = "Something error";
            }
            $code = 400;
            $data = null;
        }

        return response()->json([
            "result_code"       => $code,
            "result_message"    => $message,
            "data"              => $data
        ],$code);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try
        {
            $login = $this->user_service->login($request->email, $request->password);
            if ($login) {
                $code = 200;
                $message = "Login success";
                $data = $login;
            } else {
                $code = 422;
                $message = "Invalid username/password supplied";
                $data = null;
            }
        } catch(\Exception $e) {
            $code = 500;
            $message = "INTERNAL SERVER ERROR";
            $data = $e->getMessage();
        }

        return response()->json([
            "result_code"       => $code,
            "result_message"    => $message,
            "data"              => $data
        ], $code);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try
        {
            $authorization = $request->header('Authorization');

            JWTAuth::setToken($authorization);

            $user = JWTAuth::invalidate();

            $code = 200;
            $message = "Success";
            $data = "Logout success!";
        }
        catch(\Exception $e) {
            $code = 400;
            $message = "Something error!!!!!";
            $data = null;
        }
        return response()->json([
            "result_code"       => $code,
            "result_message"    => $message,
            "data"              => $data
        ], $code);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try
        {
            // get user by id
            $user = $this->user_service->find($id);

            if (!$user) {
                throw new \Exception("Not found user", 2);
            }

            $code = 200;
            $message = "Success";
            $data = $user;
        }
        catch(\Exception $e) {
            $code = 400;
            $message = "Something error!!!!!";
            $data = null;
        }
        return response()->json([
            "result_code"       => $code,
            "result_message"    => $message,
            "data"              => $data
        ], $code);
    }
}