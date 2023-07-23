<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Models\V1\ServiceCategory;
use App\Models\V1\Service;
use App\Http\Requests\V1\StoreServiceCategoryRequest;
use App\Http\Requests\V1\UpdateServiceCategoryRequest;
use App\Http\Repositories\V1\ServiceCategoryRepository;
use App\Http\Repositories\V1\ServiceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;

class ServiceCategoryController extends AppBaseController
{
    /** @var ServiceCategoryRepository */
    private $serviceCategoryRepository;

    public function __construct(ServiceCategoryRepository $serviceCategoryRepo,ServiceRepository $serviceRepo)
    {
        $this->serviceCategoryRepository = $serviceCategoryRepo;
        $this->serviceRepository = $serviceRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try 
        {
            $serviceCategories = $this->serviceCategoryRepository->all();
            return $this->sendResponse($serviceCategories, 'Service categories retrieved successfully',null);
        } catch (\Exception $e){
            return $this->sendResponse(null, null, 'Service categories retrieved failed. '. $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try 
        {
            $serviceCategory = $this->serviceCategoryRepository->create($request->all());
            return $this->sendResponse($serviceCategory, 'Service category created successfully',null);
        } catch (\Exception $e){
            return $this->sendResponse(null, null, 'Service category creation failed. '. $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $serviceCategory = $this->serviceCategoryRepository->find($id);
        if (empty($serviceCategory)) {
            return $this->sendResponse(null, null, 'Service category not found.');
        }
        $serviceCategory->services = Service::getServicesByCategoryId($serviceCategory->id);

        return $this->sendResponse($serviceCategory, 'Service category retrieved successfully',null);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $serviceCategory = $this->serviceCategoryRepository->find($id);

        if (empty($serviceCategory)) {
            return $this->sendResponse(null, null, 'Service category not found.');
        }

        $serviceCategory = $this->serviceCategoryRepository->update($request->all(), $id);
        return $this->sendResponse($serviceCategory, 'Service category updated successfully',null);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $serviceCategory = $this->serviceCategoryRepository->find($id);

        if (empty($serviceCategory)) {
            return $this->sendResponse(null, null, 'Service category not found.');
        }

        $serviceCategory = $this->serviceCategoryRepository->delete( $id);
        return $this->sendResponse(null, 'Service category deleted successfully',null);
    }
}
