<?php

namespace App\Services;

use App\Repositories\TourRepository;

class TourServices{

    protected $tourRepository;

    public function __construct(TourRepository $tourRepository)
    {
        $this->tourRepository = $tourRepository;
    }

    public function getAllTours($fields = [])
    {
        return $this->tourRepository->getAll($fields);
    }

    public function getTourById($id)
    {
        return $this->tourRepository->getById($id);
    }

    public function getTourByKeys($keys, $values, $fields = [])
    {
        return $this->tourRepository->getByKeys($keys, $values, $fields);
    }

    public function createTour($data)
    {
        return $this->tourRepository->create($data);
    }

    public function updateTour($id, $data)
    {
        return $this->tourRepository->update($id, $data);
    }

    public function deleteTour($id)
    {
        return $this->tourRepository->delete($id);
    }

}
