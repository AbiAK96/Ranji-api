<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Models\V1\Vacancy;
use App\Http\Repositories\V1\VacancyRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\V1\JobApplication;

class VacancyController extends AppBaseController
{
    /** @var VacancyRepository */
   private $vacancyRepository;

   public function __construct(VacancyRepository $vacancyRepositoryRepo)
   {
       $this->vacancyRepository = $vacancyRepositoryRepo;
   }

   /**
    * Display a listing of the resource.
    */
   public function index()
   {
       try {
           $vacancy = $this->vacancyRepository->paginate(10);
           return $this->sendResponse($vacancy, 'Vacancies retrieved successfully',null);
       } catch (\Exception $e){
           return $this->sendResponse(null, null, 'Vacancies retrieved failed. '. $e->getMessage());
       }
   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(Request $request)
   {
       try {
           $vacancy = $this->vacancyRepository->create($request->all());
           return $this->sendResponse($vacancy, 'Vacancy created successfully',null);
       } catch (\Exception $e){
           return $this->sendResponse(null, null, 'Vacancy creation failed. '. $e->getMessage());
       }
   }

   /**
    * Display the specified resource.
    */
   public function show($id)
   {
        $vacancy = $this->vacancyRepository->find($id);

        if (empty($vacancy)) {
            return $this->sendResponse(null, null, 'Vacancy not found.');
        }
         $jobApplication = JobApplication::with('user')->where('vacancy_id',$id)->get();

        $vacancy->jobApplications = $jobApplication;
        return $this->sendResponse($vacancy, 'Vacancy retrieved successfully',null);
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, $id)
   {
       $vacancy = $this->vacancyRepository->find($id);

       if (empty($vacancy)) {
           return $this->sendResponse(null, null, 'Vacancy not found.');
       }

       $vacancy = $this->vacancyRepository->update($request->all(), $id);
       return $this->sendResponse($vacancy, 'Vacancy updated successfully',null);
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy($id)
   {
       $vacancy = $this->vacancyRepository->find($id);

       if (empty($vacancy)) {
           return $this->sendResponse(null, null, 'Vacancy not found.');
       }

       $vacancy = $this->vacancyRepository->delete( $id);
       return $this->sendResponse(null, 'Vacancy deleted successfully',null);
   }
}
