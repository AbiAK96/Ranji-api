<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Models\V1\Service;
use App\Http\Requests\V1\StoreServiceRequest;
use App\Http\Requests\V1\UpdateServiceRequest;
use App\Http\Repositories\V1\ServiceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;

class ServiceController extends AppBaseController
{
   /** @var ServiceRepository */
   private $serviceRepository;

   public function __construct(ServiceRepository $serviceRepositoryRepo)
   {
       $this->serviceRepository = $serviceRepositoryRepo;
   }

   /**
    * Display a listing of the resource.
    */
   public function index()
   {
       try {
           $service = $this->serviceRepository->paginate(10);
           return $this->sendResponse($service, 'Services retrieved successfully',null);
       } catch (\Exception $e){
           return $this->sendResponse(null, null, 'Services retrieved failed. '. $e->getMessage());
       }
   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(Request $request)
   {
       try {
           $service = $this->serviceRepository->create($request->all());
           return $this->sendResponse($service, 'Service created successfully',null);
       } catch (\Exception $e){
           return $this->sendResponse(null, null, 'Service creation failed. '. $e->getMessage());
       }
   }

   /**
    * Display the specified resource.
    */
   public function show($id)
   {
       $service = $this->serviceRepository->find($id);

       if (empty($service)) {
           return $this->sendResponse(null, null, 'Service not found.');
       }
       return $this->sendResponse($service, 'Service retrieved successfully',null);
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, $id)
   {
       $service = $this->serviceRepository->find($id);

       if (empty($service)) {
           return $this->sendResponse(null, null, 'Service not found.');
       }

       $service = $this->serviceRepository->update($request->all(), $id);
       return $this->sendResponse($service, 'Service updated successfully',null);
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy($id)
   {
       $service = $this->serviceRepository->find($id);

       if (empty($service)) {
           return $this->sendResponse(null, null, 'Service not found.');
       }

       $service = $this->serviceRepository->delete( $id);
       return $this->sendResponse(null, 'Service deleted successfully',null);
   }
}
