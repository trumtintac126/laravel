<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2/19/2019
 * Time: 10:43 AM
 */

namespace Core\Repositories;
use App\User;


class UserRepository implements RepositoryInterface
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function paginate()
    {
        return $this->model->all()->toArray();
    }

    public function find($id)
    {
        return $this->model->findOrFall($id);
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function update($id, $data)
    {
        $model = $this->find($id);
        return $model->update($data);
    }

    public function destroy($id)
    {
       $model = $this->model->find($id);
       return $model->destroy($id);
    }

    public function findWhere($condition)
    {
        $model = $this->model->where($condition);
        return $model->first();
    }

    public  function edit_profile_avatar($id,$data)
    {
        $model = $this->find($id);
        if(isset($data['avatar_img'])){
            $upload = public_path()."/uploads/";
            if(!is_dir($upload)) {
                mkdir($upload);
            }
            $ext = explode('.',$data['avatar_img']['name']);
            $ext = $ext[count($ext) - 1];
            $tmp = $data['avatar_img']['tmp_name'];
            $name = uniqid()."-".date("Y-m-d-H-i-s").'.'.$ext;
            if(@move_uploaded_file($tmp, $upload.$name)) {
                $data['avatar_img'] = "/uploads/".$name;
            }
        }
        $update = $model->update($data);
        return $update;
    }
}