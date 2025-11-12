<?php

namespace App\Services;

use App\Repositories\ReservationRepository;

class ReservationServices{

    protected $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    public function getAllReservations($fields = [])
    {
        return $this->reservationRepository->getAll($fields);
    }

    public function getReservationById($id)
    {
        return $this->reservationRepository->getById($id);
    }

    public function getReservationByKeys($keys, $values, $fields = [])
    {
        return $this->reservationRepository->getByKeys($keys, $values, $fields);
    }

    public function createReservation($data)
    {
        return $this->reservationRepository->create($data);
    }

    public function updateReservation($id, $data)
    {
        return $this->reservationRepository->update($id, $data);
    }

    public function deleteReservation($id)
    {
        return $this->reservationRepository->delete($id);
    }

}
