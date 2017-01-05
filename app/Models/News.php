<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DB;

class News extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'title', 'slug', 'category_id', 'event_date', 'bullion_id',
        'company_id', 'pub_date', 'details', 'source', 'location'];

    protected $appends = [/*'imagethumb',*/
        'link'];
    /**
     * Database table used by Model
     *
     * @var array
     */
    protected $table = 'news';

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tags', 'news_tags', 'news_id', 'tags_id');
    }

    public function bullionType()
    {
        return $this->belongsTo('App\Models\BullionType', 'bullion_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\NewsCategory', 'category_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function imageNews()
    {
        return $this->hasMany('App\Models\ImageNews', 'news_id', 'id');
    }

    public function firstImage()
    {
        return route('image.featured', $this->featured_image);
    }

    public function imageNewsFirst()
    {
        return $this->hasOne('App\Models\ImageNews', 'news_id', 'id');
    }

    public function imageThumbnail($h, $w)
    {
        return $this->imageNews->first()->getThumbnail($h, $w);
    }

    public function timeAgo()
    {
        $ua = Carbon::parse($this->updated_at);
        $uaLater = Carbon::parse($this->updated_at)->addHour(24);
        $pd = Carbon::parse($this->pub_date);
        $now = Carbon::parse(date('Y-m-d h:m:i'));

        if ($uaLater > $now) return $ua->diffForHumans();

        return $pd->format('M jS');
    }

    public static function getSortedNewsByCategory($category_id = "")
    {
        if ($category_id != "") {
            return self::with('category')->where('category_id', $category_id)->orderBy('pub_date', 'desc')->take(2)->get();
        }
        return null;
    }

    public function getLink($route, $category)
    {
        $category = str_slug(strtolower($category));

        return route($route, [$category, $this->slug]);
    }

    //Because error in news archive
    /*public function getImagethumbAttribute()
    {
        return $this->imageThumbnail(75,150);
    }
    */

    public function getLinkAttribute()
    {
        return $this->getLink('front.news.show', $this->category->label);
    }

    public static function generateNewsletter(User $user)
    {
        //value of nepse and sensitive
        $index = Index::with(['indexValue.type' => function ($q) {
            $q->where('name', 'like', '%nepse%');
            $q->orWhere('name', 'like', 'sensitive%');
        }])->orderBy('date', 'desc')->first();
        //news
        $favoritedCompanys = Watchlist::where('user_id', $user->id)->lists('company_id')->toArray();

        $favoritedNews = News::has('company')->whereIn('company_id', $favoritedCompanys)->orderBy('pub_date', 'desc')->whereBetween('pub_date', [Carbon::now()->subWeek()->format('Y-m-d'), Carbon::now()->format('Y-m-d')])->take(10)->get();

        //if user has less than 5 favorited news add general news in the last week
        $generalNews = News::orderBy('pub_date', 'desc')
            ->whereNotIn('company_id', $favoritedCompanys)
            ->orWhere('company_id', null)
            ->take(5 - $favoritedNews->count())->get();

        $newsList = $favoritedNews->merge($generalNews);

        $announcements = Announcement::orderBy('pub_date')->take(10)->get();

        $articles = InterviewArticle::whereType(1)->orderBy('pub_date', 'desc')->take(3)->get(); //0=article 1=interview
        $interviews = InterviewArticle::whereType(0)->orderBy('pub_date', 'desc')->take(3)->get(); //0=article 1=interview
        $todaysSummary = TodaysPrice::getSummaryByDate(TodaysPrice::getLastTradedDate());
        //data to be sent
        $data = [
            'index' => serialize($index),
            'newsList' => $newsList,
            'articles' => serialize($articles),
            'interviews' => serialize($interviews),
            'announcements' => serialize($announcements),
            'user' => serialize($user),
            'date' => Carbon::now()->format('l F jS, Y'),
            'todaysSummary' => $todaysSummary
        ];
        return $data;
    }
}