<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;

class UserRepository implements UserInterface
{
    public function getAll($fields = [])
    {
        return empty($fields)
            ? User::all()
            : User::select($fields)->get();
    }

    public function getById($id, $fields = [])
    {
        return empty($fields)
            ? User::find($id)
            : User::select($fields)->find($id);
    }

    public function getByKeys($keys, $values, $fields = [])
    {
        $query = User::query();

        if (is_array($keys) && is_array($values)) {
            foreach ($keys as $index => $key) {
                $query->where($key, $values[$index]);
            }
        } else {
            $query->where($keys, $values);
        }

        return empty($fields) ? $query->get() : $query->select($fields)->get();
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update($id, array $data)
    {
        $user = $this->getById($id);

        if ($user) {
            $user->update($data);
            return $user;
        }

        return false;
    }

    public function delete($id)
    {
        $user = $this->getById($id);

        if ($user) {
            return $user->delete();
        }

        return false;
    }
}
