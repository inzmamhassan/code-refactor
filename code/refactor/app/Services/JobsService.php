<?php

namespace App\Services;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\FirePHPHandler;

class JobService
{
    /**
     * @param $consumer_type
     * @param array $data
     * @return mixed
     */
    public function getAllJobsForAdmin($consumer_type, $data = [])
    {
        $allJobs = Job::query();

        $allJobs->when(($data['id'] ?? null), function($query, $param) {
            if (is_array($param)) {
                $query->whereIn('id', $param);
            } else {
                $query->where('id', $param);
            }
        });

        if ($consumer_type == 'RWS') {
            $allJobs->where('job_type', '=', 'rws');
        } else {
            $allJobs->where('job_type', '=', 'unpaid');
        }

        if (($data['feedback'] ?? null) != 'false') {
            $allJobs->where('ignore_feedback', '0');
            $allJobs->whereHas('feedback', function ($q) {
                $q->where('rating', '<=', '3');
            });
            if (($data['count'] ?? null) === 'true') {
                return $allJobs;
            }
        }

        $allJobs->when(($data['lang'] ?? null), function($query, $param) {
            $query->whereIn('from_language_id', $param);
        });

        $allJobs->when(($data['status'] ?? null), function($query, $param) {
            $query->whereIn('status', $param);
        });

        $allJobs->when(($data['job_type'] ?? null), function($query, $param) {
            $query->whereIn('job_type', $param);
        });

        $allJobs->when(($data['filter_timetype'] ?? null) === 'created', function($query, $param) use ($data) {
            $query->when(($data['from'] ?? null), function($query, $param) {
                $query->where('created_at', '>=', $param);
            })->when(($data['to'] ?? null), function($query, $param) {
                $to = $param . ' 23:59:00';
                $query->where('created_at', '<=', $to);
            })->orderBy('created_at', 'desc');
        });

        $allJobs->when(($data['filter_timetype'] ?? null) === 'due', function($query, $param) use ($data) {
            $query->when(($data['from'] ?? null), function($query, $param) {
                $query->where('due', '>=', $param);})
                ->when(($data['to'] ?? null), function($query, $param) {
                    $to = $param . ' 23:59:00';
                    $query->where('due', '<=', $to);
                })->orderBy('due', 'desc');
        });

        if (isset($requestdata['customer_email']) && $requestdata['customer_email'] != '') {
            $user = DB::table('users')->where('email', $requestdata['customer_email'])->first();
            if ($user) {
                $allJobs->where('user_id', '=', $user->id);
            }
        }

        $allJobs->orderBy('created_at', 'desc');
        $allJobs->with('user', 'language', 'feedback.user', 'translatorJobRel.user', 'distance');

        return $allJobs;
    }

    public function getAllJobsForSuperAdmin($data = [])
    {
        $allJobs = Job::query();
        if (($data['feedback'] ?? null) != 'false') {
            $allJobs->where('ignore_feedback', '0');
            $allJobs->whereHas('feedback', function ($q) {
                $q->where('rating', '<=', '3');
            });
            if (($data['count'] ?? null) === 'true') {
                return $allJobs;
            }
        }

        $allJobs->when(($data['id'] ?? null), function($query, $param) {
            if (is_array($param)) {
                $query->whereIn('id', $param);
            } else {
                $query->where('id', $param);
            }
        });

        $allJobs->when(($data['lang'] ?? null), function($query, $param) {
            $query->whereIn('from_language_id', $param);
        });

        $allJobs->when(($data['status'] ?? null), function($query, $param) {
            $query->whereIn('status', $param);
        });

        $allJobs->when(($data['job_type'] ?? null), function($query, $param) {
            $query->whereIn('job_type', $param);
        });

        $allJobs->when(($data['filter_timetype'] ?? null) === 'created', function($query, $param) use ($data) {
            $query->when(($data['from'] ?? null), function($query, $param) {
                $query->where('created_at', '>=', $param);
            })->when(($data['to'] ?? null), function($query, $param) {
                $to = $param . ' 23:59:00';
                $query->where('created_at', '<=', $to);
            })->orderBy('created_at', 'desc');
        });

        $allJobs->when(($data['filter_timetype'] ?? null) === 'due', function($query, $param) use ($data) {
            $query->when(($data['from'] ?? null), function($query, $param) {
                $query->where('due', '>=', $param);})
                ->when(($data['to'] ?? null), function($query, $param) {
                    $to = $param . ' 23:59:00';
                    $query->where('due', '<=', $to);
                })->orderBy('due', 'desc');
        });

        $allJobs->when(($data['expired_at'] ?? null), function($query, $param) {
            $query->where('expired_at', '>=', $param);
        });

        $allJobs->when(($data['will_expire_at'] ?? null), function($query, $param) {
            $query->where('will_expire_at', '>=', $param);
        });

        $allJobs->when(($data['customer_email'] ?? null), function($query, $param) {
            $users = DB::table('users')->whereIn('email', $param)->get();
            if ($users) {
                $query->whereIn('user_id', collect($users)->pluck('id')->all());
            }
        });

        $allJobs->when(($data['translator_email'] ?? null), function($query, $param) {
            $users = DB::table('users')->whereIn('email', $param)->get();
            if ($users) {
                $allJobIDs = DB::table('translator_job_rel')->whereNull('cancel_at')
                    ->whereIn('user_id', collect($users)->pluck('id')->all())->lists('job_id');
                $query->whereIn('id', $allJobIDs);
            }
        });

        $allJobs->when(($data['physical'] ?? null), function($query, $param) {
            $query->where('customer_physical_type', $param)
                ->where('ignore_physical', 0);
        });

        $allJobs->when(($data['phone'] ?? null), function($query, $param) use ($data) {
            $query->where('customer_phone_type', $param)
                ->when(($data['physical'] ?? null), function($query, $param) {
                    $query->where('ignore_physical_phone', 0);
                });
        });

        $allJobs->when(($data['flagged'] ?? null), function($query, $param) {
            $query->where('flagged', $param)
                ->where('ignore_flagged', 0);
        });

        $allJobs->when(($data['distance'] ?? null) === 'empty', function($query, $param) {
            $query->whereDoesntHave('distance');
        });

        $allJobs->when(($data['salary'] ?? null) === 'yes', function($query, $param) {
            $query->whereDoesntHave('user.salaries');
        });

        return $allJobs;
    }

    private function getJobForCertified($data = [])
    {
        $certified = '';
        if (in_array('normal', $data) && in_array('certified', $data)) {
            $certified = 'both';
        } else if(in_array('normal', $data) && in_array('certified_in_law', $data)) {
            $certified = 'n_law';
        } else if(in_array('normal', $data) && in_array('certified_in_helth', $data)) {
            $certified = 'n_health';
        } else if (in_array('normal', $data)) {
            $certified = 'normal';
        } else if (in_array('certified', $data)) {
            $certified = 'yes';
        } else if (in_array('certified_in_law', $data)) {
            $certified = 'law';
        } else if (in_array('certified_in_helth', $data)) {
            $certified = 'health';
        }

        return $certified;
    }

    private function getJobType($consumer_type = '')
    {
        $jobtype = '';
        if ($consumer_type == 'rwsconsumer') {
            $jobtype = 'rws';
        } else if ($consumer_type == 'ngo') {
            $jobtype = 'unpaid';
        } else if ($consumer_type == 'paid') {
            $jobtype = 'paid';
        }

        return $jobtype;
    }

    private function getJobGender($data = [])
    {
        $gender = '';
        if (in_array('male', $data)) {
            $gender = 'male';
        } else if (in_array('female', $data)) {
            $gender = 'female';
        }

        return $gender;
    }
}