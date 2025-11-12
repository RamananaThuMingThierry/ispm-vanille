<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserServices{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers($fields = [])
    {
        return $this->userRepository->getAll($fields);
    }

    public function getUserById($id)
    {
        return $this->userRepository->getById($id);
    }

    public function getUserByKeys($keys, $values, $fields = [])
    {
        return $this->userRepository->getByKeys($keys, $values, $fields);
    }

    public function createUser($data)
    {
        return $this->userRepository->create($data);
    }

    public function updateUser($id, $data)
    {
        return $this->userRepository->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->userRepository->delete($id);
    }

}
