<?php

namespace App\Http\Controllers\API\V1\Customer;

use App\Models\V1\Job;
use App\Models\V1\JobAddress;
use App\Http\Repositories\V1\JobRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;

class JobController extends AppBaseController
{
    /** @var JobRepository */
   private $jobRepository;

   public function __construct(JobRepository $jobRepositoryRepo)
   {
       $this->jobRepository = $jobRepositoryRepo;
   }

   /**
    * Display a listing of the resource.
    */
   public function index(Request $request)
   {
       try {
           $jobs = Job::getJobDetailsForCustomer($request);
           if (count($jobs) == 0) {
            return $this->sendResponse(null, null, 'Job not found.');
           }
           return $this->sendResponse($jobs, 'Jobs retrieved successfully',null);
       } catch (\Exception $e){
           return $this->sendResponse(null, null, 'Jobs retrieved failed. '. $e->getMessage());
       }
   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(Request $request)
   {
       try {
           $job = $this->jobRepository->create($request->all());
           if ($request->address_type == 'new') {
                $job_address = JobAddress::createDetatils($job->id, auth()->user());
            } else if($request->address_type == 'existing') {
                $job_address = JobAddress::createDetatils($job->id, $request);
            }
           return $this->sendResponse($job, 'Job created successfully',null);
       } catch (\Exception $e){
           return $this->sendResponse(null, null, 'Job creation failed. '. $e->getMessage());
       }
   }

   /**
    * Display the specified resource.
    */
   public function show($id)
   {
       $job = $this->jobRepository->find($id);

       if (empty($job)) {
           return $this->sendResponse(null, null, 'Job not found.');
       }

       if ($job->customer_id == auth()->user()->id) {
        $job->jobAddress = JobAddress::getAddressByJobId($job->id);
        return $this->sendResponse($job, 'Job retrieved successfully',null);
       }

       return $this->sendResponse(null, null, 'Job not found.');
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, $id)
   {
       $job = $this->jobRepository->find($id);

       if (empty($job)) {
           return $this->sendResponse(null, null, 'Job not found.');
       }

       $job = $this->jobRepository->update($request->all(), $id);
       return $this->sendResponse($job, 'Job updated successfully',null);
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy($id)
   {
       $job = $this->jobRepository->find($id);

       if (empty($job)) {
           return $this->sendResponse(null, null, 'Job not found.');
       }

       $job = $this->jobRepository->delete( $id);
       return $this->sendResponse(null, 'Job deleted successfully',null);
   }
}
