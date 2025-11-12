<?php

namespace App\Interfaces;

interface ReservationInterface
{
    public function getAll($fields = []);

    public function getById($id, $fields = []);

    public function getByKeys($key, $value, $fields = []);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
}
