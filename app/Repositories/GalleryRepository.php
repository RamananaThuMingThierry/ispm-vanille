<?php

namespace App\Repositories;

use App\Interfaces\GalleryInterface;
use App\Models\Gallery;

class GalleryRepository implements GalleryInterface
{
    public function getAll($fields = [])
    {
        return empty($fields)
            ? Gallery::all()
            : Gallery::select($fields)->get();
    }

    public function getById($id, $fields = [])
    {
        return empty($fields)
            ? Gallery::find($id)
            : Gallery::select($fields)->find($id);
    }

    public function getByKeys($keys, $values, $fields = [])
    {
        $query = Gallery::query();

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
        return Gallery::create($data);
    }

    public function update($id, array $data)
    {
        $gallery = $this->getById($id);

        if ($gallery) {
            $gallery->update($data);
            return $gallery;
        }

        return false;
    }

    public function delete($id)
    {
        $gallery = $this->getById($id);

        if ($gallery) {
            return $gallery->delete();
        }

        return false;
    }
}
