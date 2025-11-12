<?php

namespace App\Repositories;

use App\Models\Testimonial;
use App\Interfaces\TestimonialInterface;


class TestimonialRepository implements TestimonialInterface
{
    public function getAll($fields = [])
    {
        return empty($fields)
            ? Testimonial::all()
            : Testimonial::select($fields)->get();
    }

    public function getById($id, $fields = [])
    {
        return empty($fields)
            ? Testimonial::find($id)
            : Testimonial::select($fields)->find($id);
    }

    public function getByKeys($keys, $values, $fields = [])
    {
        $query = Testimonial::query();

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
        return Testimonial::create($data);
    }

    public function update($id, array $data)
    {
        $testimonial = $this->getById($id);

        if ($testimonial) {
            $testimonial->update($data);
            return $testimonial;
        }

        return false;
    }

    public function delete($id)
    {
        $testimonial = $this->getById($id);

        if ($testimonial) {
            return $testimonial->delete();
        }

        return false;
    }
}
