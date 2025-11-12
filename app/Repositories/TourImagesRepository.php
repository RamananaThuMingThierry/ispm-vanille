<?php

namespace App\Repositories;

use App\Interfaces\tourImageInterface;
use App\Interfaces\TourImagesInterface;
use App\Models\TourImages;

class TourImagesRepository implements TourImagesInterface
{
    public function getAll($fields = [])
    {
        return empty($fields)
            ? TourImages::all()
            : TourImages::select($fields)->get();
    }

    public function getById($id, $fields = [])
    {
        return empty($fields)
            ? TourImages::find($id)
            : TourImages::select($fields)->find($id);
    }

    public function getByKeys($keys, $values, $fields = [])
    {
        $query = TourImages::query();

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
        return TourImages::create($data);
    }

    public function update($id, array $data)
    {
        $tourImage = $this->getById($id);

        if ($tourImage) {
            $tourImage->update($data);
            return $tourImage;
        }

        return false;
    }

    public function delete($id)
    {
        $tourImage = $this->getById($id);

        if ($tourImage) {
            return $tourImage->delete();
        }

        return false;
    }
}
