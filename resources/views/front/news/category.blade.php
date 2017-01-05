@extends('front.main')

@section('title')
    {{ucwords($label)}}
@endsection

@section('specificheader')
<style type="text/css">

</style>
@endsection

@section('content')
    <section class="col-xs-12 col-md-9 category-container box" id="news-category">
        @if(!$categoryNews->isEmpty())
            @foreach($categoryNews as $news)
                <div class="col-xs-12 category-list {{is_nepali($news->title)?'np':''}}">
                    <div class="media">
                        <div class="media-left">
                            <img class="media-object" src="{{$news->imageNews->first()->getThumbnail(185,300)}}">
                        </div>
                        <div class="media-body">
                            <a href="{{route('front.news.category',str_slug($news->category->label))}}" class="link category-link">
                                {{$news->category->label}}
                            </a>
                            <h4 class="media-heading"><a href="{{$news->getLink('front.news.show',$news->category->label)}}" class="link">{{$news->title}}</a></h4>
                            <p class="category-details">{!! mb_strimwidth(strip_tags($news->details),0,160,"...")!!}</p>
                            <div class="category-author">
                                @if(is_null($news->user->profile_picture) || $news->user->profile_picture == "")
                                    <img src="http://placehold.it/60x60/dddddd/333333?text=NA" class="img-circle no-padding">
                                @else
                                    <img src="{{$news->user->getThumbnail(60,60)}}" class="img-circle no-padding category-author-image">
                                @endif
                                @if(!is_null($news->user_id))
                                    <span class="category-author-name">{{$news->user->userInfo->first_name}} {{$news->user->userInfo->last_name}}</span>
                                @endif
                                <span class="category-date">{{date_create($news->pub_date)->format('F d, Y')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </section>

    <aside class="col-xs-12 col-md-3">
        <div class="panel panel-default no-padding">
            <div class="panel-heading">
                <strong>Latest News</strong>
            </div>
            <div class="panel-body no-padding">
                <ul class="unlist no-padding">
                    @foreach($allCategories as $cat)
                        @if(!$cat->news->isEmpty())
                            <li>
                                <h4 class="aside-heading"><a href="{{route('front.news.category',str_slug($cat->label))}}" class="link">{{ucwords($cat->label)}}</a></h4>
                                <ul class="unlist news-media-list no-padding">
                                    @foreach($newsList[$cat->id] as $i=>$n)
                                        <?php if($i > 1) break; ?>
                                        <li class="aside-item">
                                            <div class="media">
                                                <div class="media-left">
                                                    <img class="media-object" src="{{$n->imageThumbnail(75,75)}}">
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="media-heading">
                                                        <a href="{{$n->getLink('front.news.show',$n->category->label)}}" class="link">
                                                            {{mb_strimwidth($n->title,0,65,"...")}} <small>({{date_create($n->pub_date)->format('M-d')}})</small>
                                                        </a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </aside>
@endsection

@section('endscript')
<script type="text/javascript">
    $('#sidebar').affix({
          offset: {
            top: 0
          }
    });
</script>
@endsection