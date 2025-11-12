<?php

namespace App\Repositories;

use App\Models\Tour;
use App\Interfaces\TourInterface;


class TourRepository implements TourInterface
{
    public function getAll($fields = [])
    {
        $query = Tour::with('images');

        if (!empty($fields)) {
            $query->select($fields);
        }

        return $query->get();
    }


    public function getById($id, $fields = [])
    {
        return empty($fields)
            ? Tour::find($id)
            : Tour::select($fields)->find($id);
    }

    public function getByKeys($keys, $values, $fields = [])
    {
        $query = Tour::query();

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
        return Tour::create($data);
    }

    public function update($id, array $data)
    {
        $tour = $this->getById($id);

        if ($tour) {
            $tour->update($data);
            return $tour;
        }

        return false;
    }

    public function delete($id)
    {
        $tour = $this->getById($id);

        if ($tour) {
            return $tour->delete();
        }

        return false;
    }
}
