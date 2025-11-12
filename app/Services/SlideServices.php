<?php

namespace App\Services;

use App\Repositories\SlideRepository;

class SlideServices{

    protected $slideRepository;

    public function __construct(SlideRepository $slideRepository)
    {
        $this->slideRepository = $slideRepository;
    }

    public function getAllSlides($fields = [])
    {
        return $this->slideRepository->getAll($fields);
    }

    public function getSlideById($id)
    {
        return $this->slideRepository->getById($id);
    }

    public function getSlideByKeys($keys, $values, $fields = [])
    {
        return $this->slideRepository->getByKeys($keys, $values, $fields);
    }

    public function createSlide($data)
    {
        return $this->slideRepository->create($data);
    }

    public function updateSlide($id, $data)
    {
        return $this->slideRepository->update($id, $data);
    }

    public function deleteSlide($id)
    {
        return $this->slideRepository->delete($id);
    }

}
