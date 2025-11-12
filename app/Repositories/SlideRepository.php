<?php

namespace App\Repositories;

use App\Models\Slide;
use App\Interfaces\SlideInterface;


class SlideRepository implements SlideInterface
{
    public function getAll($fields = [])
    {
        return empty($fields)
            ? Slide::all()
            : Slide::select($fields)->get();
    }

    public function getById($id, $fields = [])
    {
        return empty($fields)
            ? Slide::find($id)
            : Slide::select($fields)->find($id);
    }

    public function getByKeys($keys, $values, $fields = [])
    {
        $query = Slide::query();

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
        return Slide::create($data);
    }

    public function update($id, array $data)
    {
        $slide = $this->getById($id);

        if ($slide) {
            $slide->update($data);
            return $slide;
        }

        return false;
    }

    public function delete($id)
    {
        $slide = $this->getById($id);

        if ($slide) {
            return $slide->delete();
        }

        return false;
    }
}
