<?php

namespace App\Services;

use App\Repositories\TestimonialRepository;

class TestimonialServices{

    protected $testimonialRepository;

    public function __construct(TestimonialRepository $testimonialRepository)
    {
        $this->testimonialRepository = $testimonialRepository;
    }

    public function getAllTestimonials($fields = [])
    {
        return $this->testimonialRepository->getAll($fields);
    }

    public function getTestimonialById($id)
    {
        return $this->testimonialRepository->getById($id);
    }

    public function getTestimonialByKeys($keys, $values, $fields = [])
    {
        return $this->testimonialRepository->getByKeys($keys, $values, $fields);
    }

    public function createTestimonial($data)
    {
        return $this->testimonialRepository->create($data);
    }

    public function updateTestimonial($id, $data)
    {
        return $this->testimonialRepository->update($id, $data);
    }

    public function deleteTestimonial($id)
    {
        return $this->testimonialRepository->delete($id);
    }

}
