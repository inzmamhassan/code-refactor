<?php

namespace DTApi\Http\Controllers;

use DTApi\Models\Job;
use DTApi\Http\Requests;
use DTApi\Models\Distance;
use Illuminate\Http\Request;
use DTApi\Repository\BookingRepository;
use Illuminate\Support\Facades\Auth;

use DB;

/**
 * Class BookingController
 * @package DTApi\Http\Controllers
 */
class BookingController extends Controller
{

    /**
     * @var BookingRepository
     */
    protected $repository;

    /**
     * BookingController constructor.
     * @param BookingRepository $bookingRepository
     */
    public function __construct(BookingRepository $bookingRepository)
    {
        $this->repository = $bookingRepository;
    }

    private function isAdmin($request)
    {
        // return $request->__authenticatedUser->user_type == env('ADMIN_ROLE_ID') 
        // || $request->__authenticatedUser->user_type == env('SUPERADMIN_ROLE_ID');
        
        //For Auth like build in Auth and have auth validation in Modals
        // $user = Auth::user();
        // return ($user && ($user->is('superadmin') || $user->is('admin')));

        // but this project repositories I might go for gates
        return Gate::any(['super-admin', 'admin'];
    }
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        // using early return 
        if($user_id = $request->get('user_id')) 
            return response( $this->repository->getUsersJobs($user_id) );

        if($this->isAdmin($request)) 
            return response( $this->repository->getAll($request) );        
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        try {
            return response(
                $this->repository
                ->with('translatorJobRel.user')
                ->findOrFail($id) );
        } catch (\Throwable $th) {
            abort(404);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $response = $this->repository->store($request->__authenticatedUser, $data);

        } catch (\Throwable $th) {
            DB::rollback();
            abort(404);
        }

        DB::commit();
        return response()->json($response, 200);

    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function update($id, Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $customerUser = $request->__authenticatedUser;
            $response = $this->repository->updateJob($id, array_except($data, ['_token', 'submit']), $customerUser);

        } catch (\Throwable $th) {
            DB::rollback();
            abort(404);
        }

        DB::commit();
        return response()->json($response, 200);
    }

    public function distanceFeed(Request $request)
    {
        $data = $request->all();

        if ($data['flagged'] == 'true' && $data['admincomment'] == '') {
            return "Please, add comment";            
        } 

        $distance = $data['distance'] ?? '';
        $time = $data['time'] ?? '';
        $jobid = $data['jobid'] ?? null;
        $session = $data['session_time'] ?? '';
        $admincomment = $data['admincomment'] ?? '';
        $manually_handled = ($data['manually_handled'] == 'true') ?  'yes' : 'no';
        $by_admin = ($data['by_admin'] == 'true') ? 'yes' : 'no';   
        $flagged =  ($data['flagged'] == 'true') ? 'yes' : 'no';

        $affectedRows = false;
        $affectedRows1 = false;

        if ($time || $distance) {
            $affectedRows = Distance::where('job_id', '=', $jobid)
                            ->update(array('distance' => $distance,
                             'time' => $time));
        }

        if ($admincomment || $session || $flagged || $manually_handled || $by_admin) {
            $affectedRows1 = Job::where('id', '=', $jobid)
                            ->update(array('admin_comments' => $admincomment, 
                            'flagged' => $flagged, 
                            'session_time' => $session,
                            'manually_handled' => $manually_handled,
                            'by_admin' => $by_admin));
        }

        if ($affectedRows || $affectedRows1) {
            return response()->json(['message' => 'Record updated!']);
        }

        return response()->json(['message' => 'Record not updated!']);

    }
}