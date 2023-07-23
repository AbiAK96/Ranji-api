<?php

namespace App\Http\Repositories\V1;

use App\Models\V1\User;
use App\Repositories\BaseRepository;

/**
 * Class CmsRepository
 * @package App\Repositories
 * @version March 30, 2022, 7:56 am UTC
*/

class CmsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'mobile',
        'profile_picture',
        'role',
        'address',
        'is_worker',
        'city',
        'postal_code',
        'email_verified_at',
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
        return User::class;
    }
}
