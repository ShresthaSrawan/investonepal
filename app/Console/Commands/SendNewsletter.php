<?php

namespace App\Console\Commands;

use App\Models\TodaysPrice;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Mail;
use App\Models\User;
use App\Models\Index;
use App\Models\News;
use App\Models\Watchlist;
use App\Models\Announcement;
use App\Models\InterviewArticle;


class SendNewsletter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send newsletter to the users.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $subscribedUsers = User::whereSubscribed('1')->get();
        foreach ($subscribedUsers as $user) {

            $data = News::generateNewsletter($user);

            Mail::queue('emails.watchlist', $data, function ($message) use ($user) {
                $message->subject('NSM: Daily Newsletter');
                $message->from('no-reply@nsm.com');
                $message->to($user->email);
            });
        }
        $this->comment('newsletters sent');
    }
}
