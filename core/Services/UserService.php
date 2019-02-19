<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2/19/2019
 * Time: 11:20 AM
 */

namespace Core\Services;
use Core\Repositories\UserReposiroty;

class UserService implements ServiceInterface
{

    protected $repository;

    public function _contruct(UserReposiroty $reposiroty){

        return $this->repository = $reposiroty;
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

    public function login($email,$password){


    }
}