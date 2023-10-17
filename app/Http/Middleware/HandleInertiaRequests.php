<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\SimulationJob;
use App\Models\User;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        //dd($request->pathInfo);

        return array_merge(parent::share($request), [
            // Synchronously...
            'appName' => config('app.name'),

            // Lazily...
            'auth.user' => fn () => $request->user()
                ? $this->getCurrentUser($request)
                : null,
            'jobs.activeJob' => fn () => $request->user()
                ? $this->getActiveJob($request->user())
                : null
        ]);
    }


    private function getActiveJob($user){
        $currentJob =  SimulationJob::where('user_id',$user->id)->orderBy('id','desc')->first();
        if(!$currentJob){
            $currentJob = new SimulationJob();
        }
        return $currentJob;
    }

    private function getCurrentUser($request){
        if($request->path() == 'notifications'){
            User::where('id',$request->user()->id)->update(['pending_notifications'=> 0]);
        }
        return $request->user()->only('id', 'name', 'email','profile_picture','handle','pending_notifications');
    }
}
