@extends('front.main')

@section('title')
    {{$news->title}}
@endsection

@section('specificheader')
<meta property="og:url" content="{{$news->getLink('front.news.show',$news->category->label)}}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{{$news->title}}" />
<meta property="og:description" content="{{strip_tags($news->details)}}" />
<meta property="og:image" content="{{$news->imageNews->first()->getThumbnail(500,500)}}" />
<meta property="og:image:width" content="500" />
<meta property="og:image:height" content="500" />
<style type="text/css">
    .tags a {    
    display: inline-block;
    height: 24px;
    line-height: 24px;
    position: relative;
    margin: 0 16px 8px 0;
    padding: 0 10px 0 12px;
    background: #777;    
    -webkit-border-bottom-right-radius: 3px;    
    border-bottom-right-radius: 3px;
    -webkit-border-top-right-radius: 3px;    
    border-top-right-radius: 3px;
    -webkit-box-shadow: 0 1px 2px rgba(0,0,0,0.2);
    box-shadow: 0 1px 2px rgba(0,0,0,0.2);
    color: #fff;
    font-size: 12px;
    font-family: "Lucida Grande","Lucida Sans Unicode",Verdana,sans-serif;
    text-decoration: none;
    text-shadow: 0 1px 2px rgba(0,0,0,0.2);
    font-weight: bold;
    }
    .tags a:before {
    content: "";
    position: absolute;
    top:0;
    left: -12px;
    width: 0;
    height: 0;
    border-color: transparent #777 transparent transparent;
    border-style: solid;
    border-width: 12px 12px 12px 0;        
    }

	.tags a:after {
    content: "";
    position: absolute;
    top: 10px;
    left: 1px;
    float: left;
    width: 5px;
    height: 5px;
    -webkit-border-radius: 50%;
    border-radius: 50%;
    background: #fff;
    -webkit-box-shadow: -1px -1px 2px rgba(0,0,0,0.4);
    box-shadow: -1px -1px 2px rgba(0,0,0,0.4);
    }
	
	.page-title{display:none;}
	h1.np{line-height: 1.4;}
    .indi-item .item-body { font-weight: 200; }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.5/jquery.bxslider.min.css" rel="stylesheet" type="text/css">
@endsection

@section('content')

<section class="news-show col-md-9 col-xs-12">
    <div class="box indi-item">
        <header>
            <a href="{{route('front.news.category',str_slug($news->category->label))}}" class="link category-link">{{$news->category->label}}</a>
            <h1 class="headline {{is_nepali($news->title)?'np':''}}">{{$news->title}}</h1>
        @if(!$news->imageNews->isEmpty())
            @if($news->imageNews->count() == 1)
                <img src="{{$news->imageNews->first()->getThumbnail(509,847)}}" class="img-responsive" width="100%" />
            @else
                <div class="featured-image">
                    <ul class="nsm-news-slider no-padding unlist">
                        @foreach($news->imageNews as $in)
                            <li>
                                <img src="{{$in->getThumbnail(509,847)}}" class="img-responsive"/>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endif
        @if($news->source != null)
            <div class="source"> Source: {{$news->source}}</div>            
        @endif
        </header>
        <div class="item-social-media">
			<h4>
            <a href="http://www.facebook.com/sharer.php?u={{urlencode($news->getLink('front.news.show',$news->category->label))}}" target="_blank" class="js-social-share facebook">
                <i class="fa fa-facebook-square fa-2x"></i>
            </a>
            <a href="https://twitter.com/intent/tweet?text={{urlencode($news->title)}}&url={{urlencode($news->getLink('front.news.show',$news->category->label))}}&via=investonepal" target="_blank" class="js-social-share twitter">
                <i class="fa fa-twitter-square fa-2x"></i>
            </a>
			<span class="item-date">{{date_create($news->pub_date)->format('F d, Y')}}. {{$news->user->userInfo->first_name}} {{$news->user->userInfo->last_name}}</span></h4>
        </div>
        <div class="item-body">
            {!!$news->details!!}
			<div class="item->tags tags">
                @foreach($news->tags as $tag)
                    <a href="{{route('front.news.tags.show',$tag->name)}}">{{$tag->name}}</a>
                @endforeach
            </div>
        </div>
		<div class="item-comments">
			<h3>Have Your Say</h3>
			<div class="fb-comments" data-href="{{\Illuminate\Support\Facades\Request::url()}}" data-numposts="5" width="100%"></div>
		</div>
        <span class="clearfix"></span>
    </div>
</section>
<aside class="col-md-3 col-xs-12">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- image7may -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:250px;height:250px"
         data-ad-client="ca-pub-5451183272464388"
         data-ad-slot="6647407961"></ins>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    <div class="panel panel-default no-padding">
        <div class="panel-heading">
            <strong>Similar News</strong>
        </div>
        <div class="panel-body no-padding">
            <ul class="unlist no-padding">
                <li>
                    <h4 class="aside-heading"><a href="{{route('front.news.category',str_slug($news->category->label))}}" class="link">{{ucwords($news->category->label)}}</a></h4>
                    <ul class="news-media-list unlist no-padding">
                        @foreach($newsList as $i=>$n)
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
            </ul>
        </div>
    </div>
</aside>

@endsection

@section('endscript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.5/jquery.bxslider.min.js" type="text/javascript"></script>
    <script>
        $(function(){
            $(document).ready(function(){
                $('.nsm-news-slider').bxSlider({
                    mode: 'fade',
                    auto: true
                });
            });
        });
    </script>
@endsection