@extends('front.main')

@section('title')
    {{$ia->title}}
@endsection

@section('specificheader')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.5/jquery.bxslider.min.css" rel="stylesheet" type="text/css">
	<style>
		.page-title{display:none;}
		.individual-detail p{margin:0;}
	</style>
@endsection
@section('content')
<?php 
    $author = "";
    if(is_null($ia->externalDetail)):
        $author = $ia->user;
        $aname = $author->userInfo->first_name.' '.$author->userInfo->last_name;
        $aposition = $author->userInfo->work;
        $aorganization = "Investo Nepal";
    else:
        $author = $ia->externalDetail;
        $aname = $author->name;
        $aposition = $author->position;
        $aorganization = $author->organization;
    endif;
?>
    <section class="news-show col-md-9 col-xs-12">
        <div class="box indi-item">
            <header>
                <a href="#" class="link category-link">{{$ia->category->label}}</a>
                <h1 class="headline">{{$ia->title}}</h1>
				@if(!$ia->featuredImage->isEmpty())
					@if($ia->featuredImage->count() == 1)
						<img src="{{$ia->featuredImage->first()->getThumbnail(509,847)}}" class="img-responsive" />
					@else
						<div class="featured-image">
							<ul class="nsm-news-slider no-padding unlist">
								@foreach($ia->featuredImage as $fi)
									<li>
										<img src="{{$fi->getThumbnail(509,847)}}" class="img-responsive" />
									</li>
								@endforeach
							</ul>
						</div>
					@endif
				@endif
            </header>
			<div class="item-social-media">
				<h4>
				<a href="http://www.facebook.com/sharer.php?u={{urlencode($ia->getLink('front.interviewArticle.show',$ia->category->label))}}" target="_blank" class="js-social-share facebook">
					<i class="fa fa-facebook-square fa-2x"></i>
				</a>
				<a href="https://twitter.com/intent/tweet?text={{urlencode($ia->title)}}&url={{urlencode($ia->getLink('front.interviewArticle.show',$ia->category->label))}}&via=investonepal" target="_blank" class="js-social-share twitter">
					<i class="fa fa-twitter-square fa-2x"></i>
				</a>
                <span class="item-date">{{date_create($ia->pub_date)->format('F d, Y')}}. {{$aname}}</span></h4>
			</div>
            <div class="item-body">
                {!!$ia->details!!}
				<div class="row individual well" style="font-size:12px;">
					@if($ia->type==0)
						<div class="col-md-6 col-xs-12 individual-info">
							<div class="col-xs-3 no-padding">
								@if(url_exists($ia->intervieweDetail->getImage()))
									<img src="{{$ia->intervieweDetail->getImage()}}" class="img-responsive thumbnail">
								@endif
							</div>
							<div class="col-xs-9 individual-detail">
								<p class="title">Interviewee</p>
								<p>{{$ia->intervieweDetail->name}}</p>
								<p>{{$ia->intervieweDetail->organization}}</p>
								<p>{{$ia->intervieweDetail->position}}</p>
							</div>
						</div>
					@endif
					<div class="col-md-6 col-xs-12 author-info">
						<div class="col-xs-3 no-padding">
							@if(url_exists($author->getImage()))
								<img src="{{$author->getThumbnail(70,70)}}" class="img-responsive thumbnail">
							@else
								<img src="{{url('/')}}/profile_picture/placeholder-user.png" class="img-responsive thumbnail">
							@endif
						</div>
						<div class="col-xs-9 individual-detail">
							<p class="title">Interviewer</p>
							<p>{{$aname}}</p>
							<p>{{$aposition}}</p>
							<p>{{$aorganization}}</p>
						</div>
					</div>
				</div>
				<span class="clearfix"></span>
            </div>
            <div class="item-comments">
                <h3>Have Your Say</h3>
                <div class="fb-comments" data-href="{{\Illuminate\Support\Facades\Request::url()}}" data-numposts="5" width="100%"></div>
            </div>
        </div>
    </section>
    <aside class="col-md-3 col-xs-12">
        <div class="panel panel-default no-padding">
            <div class="panel-heading">
                <strong>Similar {{$ia->type==0 ? 'Interview' : 'Article'}}</strong>
            </div>
            <div class="panel-body no-padding">
                <ul class="unlist no-padding">
                    <li>
                        <h4 class="aside-heading"><a href="#" class="link">{{ucwords($ia->category->label)}}</a></h4>
                        <ul class="news-media-list unlist no-padding">
                            @foreach($iaList as $i=>$n)
                                <li class="aside-item">
                                    <div class="media">
                                        <div class="media-left">
                                            <img src="{{$n->featuredImage->first()->getThumbnail(75,75)}}" class="media-object" />
                                        </div>
                                        <div class="media-body">
                                            <h5 class="media-heading">
                                                <a href="{{$n->getLink('front.interviewArticle.show',$n->category->label)}}" target="_blank" class="link">
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