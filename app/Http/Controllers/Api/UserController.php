<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/19/2019
 * Time: 9:55 PM
 */

namespace App\Http\Controllers\Api;


use Core\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends ApiController
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
                    throw  new Exception("Email is exists",2);
                }else
                {
                    //insert data to table
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
}