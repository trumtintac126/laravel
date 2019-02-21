<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2/19/2019
 * Time: 11:20 AM
 */

namespace Core\Services;
use Core\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use JWTAuth;

class UserService implements ServiceInterface
{

    protected $repository;

    public function __construct(UserRepository $repository)
    {
        return $this->repository = $repository;
    }


    public function paginate()
    {
        return $this->repository->paginate();
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function store($data)
    {
        return $this->repository->store($data);
    }

    public function update($id, $data)
    {
        return $this->repository->update($id,$data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }

    public function findWhere($condition)
    {
        return $this->repository->findWhere($condition);
    }

    public function login($email,$password){

        $user = $this->repository->findWhere([
            "email"  => $email,
            "status" => 1
        ]);
        if (!empty($user) && Hash::check($password, $user->password))
        {
            $user->remember_token = JWTAuth::attempt([
                'email'         => $email,
                'first_name'    => $user->first_name,
                'last_name'     => $user->last_name,
                'password' => $password
            ]);
            return($user->save()) ? $user->remember_token : false;
        }
        return false;
    }
}