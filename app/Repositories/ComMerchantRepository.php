<?php

namespace App\Repositories;

use App\Models\ComMerchant;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Repository\Eloquent\BaseRepository;
use Shamim\DewanMultilangSlug\Facades\MultilangSlug;

/**
 *
 * @package namespace App\Repositories;
 */
class ComMerchantRepository extends BaseRepository
{

    public function model()
    {
        return ComMerchant::class;
    }

    public function boot()
    {
        try {
            $this->pushCriteria(app(RequestCriteria::class));
        } catch (RepositoryException $e) {
            //
        }
    }

    public function store($user_id)
    {
        $data = [
            'user_id' => $user_id,
        ];
            // Create new category
            $category = $this->create($data);

        return $category;
    }
    
}
