<?php

namespace App\Http\Controllers\API\V1\Customer;

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

   public function index()
   {
       try {
           $vacancies = $this->vacancyRepository->paginate(10);
            foreach($vacancies as $vacancy){
                $jobApplication = JobApplication::where('vacancy_id',$vacancy->id)->where('user_id',auth()->user()->id)->first();
                if ($jobApplication == null) {
                    $vacancy->is_applied = false;
                } else {
                    $vacancy->is_applied = true;
                }
            }
           return $this->sendResponse($vacancies, 'Vacancies retrieved successfully',null);
       } catch (\Exception $e){
           return $this->sendResponse(null, null, 'Vacancies retrieved failed. '. $e->getMessage());
       }
   }

   public function show($id)
   {
       $vacancy = $this->vacancyRepository->find($id);

       if (empty($vacancy)) {
           return $this->sendResponse(null, null, 'Vacancy not found.');
       }
        $jobApplication = JobApplication::where('vacancy_id',$vacancy->id)->where('user_id',auth()->user()->id)->first();
        if ($jobApplication == null) {
        $vacancy->is_applied = false;
        } else {
            $vacancy->is_applied = true;
        }
       return $this->sendResponse($vacancy, 'Vacancy retrieved successfully',null);
   }

   public function store(Request $request)
   {
       $vacancy = $this->vacancyRepository->find($request->vacancy_id);

       if (empty($vacancy)) {
           return $this->sendResponse(null, null, 'Vacancy not found.');
       }
       $job = JobApplication::applyJob($request->vacancy_id);
       return $this->sendResponse($job, 'Your application has been submitted successfully',null);
   }
}
