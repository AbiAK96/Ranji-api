<?php

namespace App\Http\Repositories\V1;

use App\Models\V1\Job;
use App\Repositories\BaseRepository;

/**
 * @package App\Repositories
 * @version March 30, 2022, 7:56 am UTC
*/

class JobRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'customer_id',
        'worker_id',
        'service_type_id',
        'title',
        'description',
        'status',
        'budget',
        'rating',
        'payment_type'
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
        return Job::class;
    }
}
