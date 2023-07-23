<?php

namespace App\Http\Controllers\API\V1\Customer;

use App\Models\V1\ProvideService;
use App\Http\Repositories\V1\ProvideServiceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;

class ProvideServiceController extends AppBaseController
{
    /** @var ProvideServiceRepository */
    private $provideServiceRepository;

    public function __construct(ProvideServiceRepository $provideServiceRepo)
    {
        $this->provideServiceRepository = $provideServiceRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try 
        {
            $provideServices = $this->provideServiceRepository->paginate(10);
            return $this->sendResponse($provideServices, 'Provide services retrieved successfully',null);
        } catch (\Exception $e){
            return $this->sendResponse(null, null, 'Provide services retrieved failed. '. $e->getMessage());
        }
    }

    public function show($id)
    {
        $provideService = $this->provideServiceRepository->find($id);
        if (empty($provideService)) {
            return $this->sendResponse(null, null, 'Provide service not found.');
        }
        return $this->sendResponse($provideService, 'Provide service retrieved successfully',null);
    }
}
