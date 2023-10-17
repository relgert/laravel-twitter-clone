<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\SimulateActivityAfterLogin;

class SimulationJob extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $attributes = [
        'percent' => '0',
        'status' => false,
    ];


    static function startSimulation($user){
        $job = new SimulationJob;
        $job->user_id = $user->id;
        $job->title = 'Starting..';
        $job->status = 'Running';
        $job->subtitle = 'Starting..';
        $job->percent = 0;
        $job->save();
        SimulateActivityAfterLogin::dispatch($job);
        return $job;
    }
}
