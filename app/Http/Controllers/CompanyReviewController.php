<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use Cache;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\CompanyReview;
use App\Models\Company;
use App\Models\Watchlist;

class CompanyReviewController extends Controller
{
    public function getReview(Request $request)
    {
        $company = $request->get('company_id', null);
        $type = $request->get('type', null);
        $today = Carbon::now()->format('Y-m-d');
        $startOfthisMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $lastMonth = Carbon::now()->subMonth()->format('Y-m-d');

        $output = Cache::remember('getReview_output_' . $company . $today . $startOfthisMonth . $lastMonth, 30, function () use ($company, $today, $startOfthisMonth, $lastMonth) {
            $topReviews = CompanyReview::select(DB::raw('*,length(up_user_id)-length(replace(up_user_id,",","")) upvote'))
                ->with(['user' => function ($q) {
                    $q->select('username', 'profile_picture', 'id');
                }])
                ->where('company_id', $company)
                ->whereBetween('date', [$startOfthisMonth, $today])
                ->orderBy('upvote', 'desc')
                ->limit(10)->take(10)
                ->get()
                ->toArray();

            $ratings = CompanyReview::select(DB::raw('type,count(type) as number'))->whereBetween('date', [$lastMonth, $today])->where('company_id', $company)->groupBy('type')->lists('number', 'type')->toArray();


            return ['topReviews' => $topReviews, 'ratings' => $ratings];
        });

        return $output;
    }

    public function getChart(Request $request)
    {
        $company = $request->get('company_id', null);

        $startOfMonth3 = Carbon::now()->subMonth()->format('Y-m-d');
        $endOfMonth3 = Carbon::now()->format('Y-m-d');

        $startOfMonth2 = Carbon::now()->subMonth(2)->endOfMonth()->format('Y-m-d');
        $endOfMonth2 = Carbon::now()->subMonth()->subDay()->format('Y-m-d');

        $startOfMonth1 = Carbon::now()->subMonths(3)->format('Y-m-d');
        $endOfMonth1 = Carbon::now()->subMonths(2)->subDay()->format('Y-m-d');

        $output = Cache::remember('getChart_output_' . $company . $startOfMonth3 . $endOfMonth3 . $startOfMonth2 . $endOfMonth2 . $startOfMonth1 . $endOfMonth1, 30, function () use ($company, $startOfMonth3, $endOfMonth3, $startOfMonth2, $endOfMonth2, $startOfMonth1, $endOfMonth1) {
            $rating3 = CompanyReview::select(DB::raw('type,count(type) as number'))->whereBetween('date', [$startOfMonth3, $endOfMonth3])->where('company_id', $company)->groupBy('type')->lists('number', 'type')->toArray();
            $rating2 = CompanyReview::select(DB::raw('type,count(type) as number'))->whereBetween('date', [$startOfMonth2, $endOfMonth2])->where('company_id', $company)->groupBy('type')->lists('number', 'type')->toArray();
            $rating1 = CompanyReview::select(DB::raw('type,count(type) as number'))->whereBetween('date', [$startOfMonth1, $endOfMonth1])->where('company_id', $company)->groupBy('type')->lists('number', 'type')->toArray();
            return [$rating1, $rating2, $rating3];
        });

        return $output;
    }

    public function review(Request $request)
    {
        $company = $request->get('company_id');
        $comment = $request->get('review_text');
        $type = $request->get('review_type');
        $validTypes = ['b', 's', 'h'];

        if ($type == null || !in_array($type, $validTypes) || !Auth::check()):
            return 0;
        endif;

        $user = Auth::id();

        $today = Carbon::now()->format('Y-m-d');
        $lastMonth = Carbon::now()->subMonth()->format('Y-m-d');

        $review = CompanyReview::whereBetween('date', [$lastMonth, $today])->where('user_id', $user)->where('company_id', $company)->first();

        if (is_null($review)):
            $review = new CompanyReview();
        endif;
        $review->company_id = $company;
        $review->user_id = $user;
        $review->type = $type;
        $review->review = $comment;
        $review->date = $today;
        $review->save();

        return 1;
    }

    public function vote(Request $request)
    {
        $id = $request->get('id');
        $thumb = $request->get('thumb');

        //check validity of request
        if ($thumb == null || !in_array($thumb, [0, 1]) || !Auth::check()):
            return 0;
        endif;

        //GET USER ID
        $user = Auth::id();

        //find review
        $review = CompanyReview::find($id);

        //has review??
        if (is_null($review)) return 0;

        //get all users who voted the comment
        $upVotedUsers = explode(',', $review->up_user_id);
        $downVotedUsers = explode(',', $review->down_user_id);

        //destroy the up and down votes for the user
        if (($key = array_search($user, $upVotedUsers)) !== false) {
            unset($upVotedUsers[$key]);
        }
        if (($key = array_search($user, $downVotedUsers)) !== false) {
            unset($downVotedUsers[$key]);
        }
        if (($key = array_search('', $upVotedUsers)) !== false) {
            unset($upVotedUsers[$key]);
        }
        if (($key = array_search('', $downVotedUsers)) !== false) {
            unset($downVotedUsers[$key]);
        }

        if ($thumb == '1'):
            array_push($upVotedUsers, $user);
        else:
            array_push($downVotedUsers, $user);
        endif;

        $review->up_user_id = !empty($upVotedUsers) ? implode(',', $upVotedUsers) . ',' : '';
        $review->down_user_id = !empty($downVotedUsers) ? implode(',', $downVotedUsers) . ',' : '';

        $review->save();

        return 1;
    }
}
