<?php

namespace App\Repositories;

use App\Models\Reservation;
use App\Interfaces\ReservationInterface;


class ReservationRepository implements ReservationInterface
{
    public function getAll($fields = [])
    {
        $query = Reservation::with('tour');

        if (!empty($fields)) {
            $query->select($fields);
        }

        return $query->get();
    }

    public function getById($id, $fields = [])
    {
        return empty($fields)
            ? Reservation::find($id)
            : Reservation::select($fields)->find($id);
    }

    public function getByKeys($keys, $values, $fields = [])
    {
        $query = Reservation::query();

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
        return Reservation::create($data);
    }

    public function update($id, array $data)
    {
        $reservation = $this->getById($id);

        if ($reservation) {
            $reservation->update($data);
            return $reservation;
        }

        return false;
    }

    public function delete($id)
    {
        $reservation = $this->getById($id);

        if ($reservation) {
            return $reservation->delete();
        }

        return false;
    }
}
