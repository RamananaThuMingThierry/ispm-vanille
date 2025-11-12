<?php

namespace App\Services;

use App\Repositories\TourImagesRepository;
use App\Repositories\TourRepository;

class TourImageServices{

    protected $tourImagesRepository;

    public function __construct(TourImagesRepository $tourImagesRepository)
    {
        $this->tourImagesRepository = $tourImagesRepository;
    }

    public function getAllTourImages($fields = [])
    {
        return $this->tourImagesRepository->getAll($fields);
    }

    public function getTourImageById($id)
    {
        return $this->tourImagesRepository->getById($id);
    }

    public function getTourImageByKeys($keys, $values, $fields = [])
    {
        return $this->tourImagesRepository->getByKeys($keys, $values, $fields);
    }

    public function createTourImage($data)
    {
        return $this->tourImagesRepository->create($data);
    }

    public function updateTourImage($id, $data)
    {
        return $this->tourImagesRepository->update($id, $data);
    }

    public function deleteTourImage($id)
    {
        return $this->tourImagesRepository->delete($id);
    }

}
