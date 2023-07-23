<?php

namespace App\Http\Controllers\API\V1\Admin;

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try 
        {
            $provideService = $this->provideServiceRepository->create($request->all());
            return $this->sendResponse($provideService, 'Provide service created successfully',null);
        } catch (\Exception $e){
            return $this->sendResponse(null, null, 'Provide service creation failed. '. $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $provideService = $this->provideServiceRepository->find($id);
        if (empty($provideService)) {
            return $this->sendResponse(null, null, 'Provide service not found.');
        }
        return $this->sendResponse($provideService, 'Provide service retrieved successfully',null);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $provideService = $this->provideServiceRepository->find($id);

        if (empty($provideService)) {
            return $this->sendResponse(null, null, 'Provide service not found.');
        }

        $provideService = $this->provideServiceRepository->update($request->all(), $id);
        return $this->sendResponse($provideService, 'Provide service updated successfully',null);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $provideService = $this->provideServiceRepository->find($id);

        if (empty($provideService)) {
            return $this->sendResponse(null, null, 'Provide service not found.');
        }

        $provideService = $this->provideServiceRepository->delete( $id);
        return $this->sendResponse(null, 'Provide service deleted successfully',null);
    }
}
