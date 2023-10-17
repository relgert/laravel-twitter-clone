<?php

namespace App\Jobs;

use App\Jobs\Simulation\Simulation;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\SimulationJob;

class SimulateActivityAfterLogin implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public SimulationJob $job,){}

    public $uniqueFor = 3600;

    public function uniqueId(): string
    {
        return $this->job->user_id;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $iterations = rand(10,20);

        $user = User::find($this->job->user_id);


        for($i = 0; $i < $iterations; $i++){
            $number = rand(0,5);
            switch($number){
                case 0:
                    $this->job->subtitle = 'Simulating tweet';
                    Simulation::tweet($user);
                    break;
                case 1:
                    $this->job->subtitle = 'Simulating follower';
                    Simulation::follow($user);
                    break;
                case 2:
                    $this->job->subtitle = 'Simulating retweet';
                    Simulation::retweet($user);
                    break;
                case 3:
                    $this->job->subtitle = 'Simulating reply';
                    Simulation::reply($user);
                    break;
                case 4:
                    $this->job->subtitle = 'Simulating favorite';
                    Simulation::likeTweet($user);
                    break;
                case 5:
                    $this->job->subtitle = 'Simulating quote';
                    Simulation::quote($user);
                    break;
            }
            $this->job->percent = round(($i / $iterations) * 100) ;
            $this->job->save();
            sleep(2);
        }
        $this->job->percent = 100;
        $this->job->status = 'Done';
        $this->job->subtitle = 'Finished';
        $this->job->save();
    }
}
