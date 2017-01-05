<?php

namespace App\Console;

use Mail;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\SendNewsletter::class,
		\App\Console\Commands\LiveCrawl::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();

        //schedule cache clear daily
        $schedule->command('cache:clear')->weekly()->sundays();

        $schedule->call(function(){         
            $expiredUsers = User::where('expiry_date','<=',Carbon::now()->format('Y-m-d'))->where('status','<>','0')->get();
            // set status as inactive
            foreach ($expiredUsers as $user) {
                $user->status = 0;
                $user->save();
            }
        })->daily();

        //expiry email
        $schedule->call(function(){         
            $expiredUsers = User::where('expiry_date',Carbon::now()->addWeek()->format('Y-m-d'))->orWhere('expiry_date',Carbon::now()->addDay()->format('Y-m-d'))->get();

            foreach ($expiredUsers as $user) {
                $data = ['username'=>$user->username,'expiry'=>$user->expiry_date];
                
                Mail::queue('emails.expiry', $data, function($message) use ($user) {
                    $message->subject('Account Expiry');
                    $message->from('no-reply@nsm.com');
                    $message->to($user->email);
                });
            }
        })->dailyAt('09:00');

        //daily news letter
       // $schedule->command('newsletter:sentd')->everyMinute();

    }
}
