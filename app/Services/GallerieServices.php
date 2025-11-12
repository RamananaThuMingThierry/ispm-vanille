<?php

namespace App\Services;

use App\Repositories\GalleryRepository;

class GallerieServices{

    protected $galleryRepository;

    public function __construct(GalleryRepository $galleryRepository)
    {
        $this->galleryRepository = $galleryRepository;
    }

    public function getAllGalleries($fields = [])
    {
        return $this->galleryRepository->getAll($fields);
    }

    public function getGalleryById($id)
    {
        return $this->galleryRepository->getById($id);
    }

    public function getGalleryByKeys($keys, $values, $fields = [])
    {
        return $this->galleryRepository->getByKeys($keys, $values, $fields);
    }

    public function createGallery($data)
    {
        return $this->galleryRepository->create($data);
    }

    public function updateGallery($id, $data)
    {
        return $this->galleryRepository->update($id, $data);
    }

    public function deleteGallery($id)
    {
        return $this->galleryRepository->delete($id);
    }

}
