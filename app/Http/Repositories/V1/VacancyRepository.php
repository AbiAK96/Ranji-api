<?php

namespace App\Http\Repositories\V1;

use App\Models\V1\Vacancy;
use App\Repositories\BaseRepository;

/**
 * @package App\Repositories
 * @version March 30, 2022, 7:56 am UTC
*/

class VacancyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'working_hours',
        'description'
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
        return Vacancy::class;
    }
}
