<?php

namespace App\Interfaces;
interface NoticeManageInterface
{
    public function createNotice(array $data);

    public function getNotice(array $filters);

    public function getById($id);

    public function updateNotice(array $data);

    public function toggleStatus($id);

    public function deleteNotice($id);

    public function getSellerStoreNotices();
}