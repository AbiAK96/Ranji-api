<?php

namespace App\Http\Repositories\V1;

use App\Models\V1\ServiceCategory;
use App\Repositories\BaseRepository;

/**
 * @package App\Repositories
 * @version March 30, 2022, 7:56 am UTC
*/

class ServiceCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'category',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ServiceCategory::class;
    }
}
