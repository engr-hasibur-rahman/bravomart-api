<?php

namespace App\Repositories;

use App\Interfaces\NoticeManageInterface;
use App\Models\ComStoreNotice;

class NoticeManageRepository implements NoticeManageInterface
{
    public function createNotice(array $data)
    {
        try {
            ComStoreNotice::create($data);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function getNotice(array $data)
    {

    }public function updateNotice(array $data)
    {

    }public function deleteNotice(array $data)
    {

    }
}