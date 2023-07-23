<?php

namespace App\Http\Controllers\API\V1\Admin;

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
            $jobs = Job::getJobDetailsForAdmin($request);
            if (count($jobs) == 0) {
             return $this->sendResponse(null, null, 'Job not found.');
            }
            return $this->sendResponse($jobs, 'Jobs retrieved successfully',null);
        } catch (\Exception $e){
            return $this->sendResponse(null, null, 'Jobs retrieved failed. '. $e->getMessage());
        }
    }

    public function show($id)
    {
        $job = Job::with('jobAddress','payment')->where('id',$id)->first();
 
        if (empty($job)) {
            return $this->sendResponse(null, null, 'Job not found.');
        }
        return $this->sendResponse($job, 'Job retrieved successfully',null);
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
       $request['status'] = 'Progress';
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
