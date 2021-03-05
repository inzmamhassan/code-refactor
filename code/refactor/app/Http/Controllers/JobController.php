<?php


namespace DTApi\Http\Controllers;


use DTApi\Repository\BookingRepository;

class JobController extends Controller
{
    /**
     * @var BookingRepository
     */
    protected $repository;

    /**
     * JobController constructor.
     * @param BookingRepository $bookingRepository
     */
    public function customerNotCalled(Request $request)
    {
        $data = $request->all();
        $response = $this->repository->customerNotCalled($data);
        return response()->json($response, 200);
    }


    public function customerNotCall(Request $request)
    {
        return response($this->repository->customerNotCall($request->all()));
    }

     /**
     * @param Request $request
     * @return mixed
     */
    public function getHistory(Request $request)
    {
        if($user_id = $request->get('user_id')) {
            $response = $this->repository->getUsersJobsHistory($user_id, $request);
            return response()->json($response, 200);
        }

        abort(404);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function acceptJob(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();

        $response = $this->repository->acceptJob($data, $user);

        return response()->json($response, 200);
    }

    public function acceptJobWithId(Request $request)
    {
        $data = $request->get('job_id');
        $user = Auth::user();

        $response = $this->repository->acceptJobWithId($data, $user);

        return response()->json($response, 200);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function cancelJob(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();

        $response = $this->repository->cancelJobAjax($data, $user);

        return response()->json($response, 200);
    }
   
    /**
     * @param Request $request
     * @return mixed
     */
    public function endJob(Request $request)
    {
        $data = $request->all();
        $response = $this->repository->endJob($data);
        return response()->json($response, 200);
    }

     /**
     * @param Request $request
     * @return mixed
     */
    public function getPotentialJobs(Request $request)
    {
        $data = $request->all();
        $user = $request->__authenticatedUser;
        $response = $this->repository->getPotentialJobs($user);
        return response()->json($response, 200);
    }

    public function reopen(Request $request)
    {
        return response($this->repository->reopen($request->all()));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function immediateJobEmail(Request $request)
    {
        return response($this->repository->storeJobEmail($request->all()));
    }

    public function resendNotifications(Request $request)
    {
        $data = $request->all();
        $job = $this->repository->find($data['jobid']);
        $job_data = $this->repository->jobToData($job);
        $this->repository->sendNotificationTranslator($job, $job_data, '*');

        return response()->json(['success' => 'Push sent']);
    }


    /**
     * Sends SMS to Translator
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function resendSMSNotifications(Request $request)
    {
        $job = $this->repository->find($request->only('jobid'));

        try {
            $this->repository->sendSMSNotificationToTranslator($job);
            return response()->json(['success' => 'SMS sent']);
        } catch (\Exception $e) {
            return response()->json(['success' => $e->getMessage()]);
        }
    }

}