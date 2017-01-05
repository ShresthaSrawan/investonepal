@extends('front.main')

@section('title')
    News
@endsection

@section('specificheader')
<style type="text/css">
    .news-link,figure > figcaption > a{
        display: block;
        font-size: 1.13em;
        line-height: normal;
        font-weight: 600;
        padding: 8px 10px;
        border-bottom: 1px solid #ddd;
    }
    figure {
        margin-bottom: 10px;
    }
    figure > .image {
        min-height: 202px;
    }
    
    figure > figcaption{
        background-color: rgba(62,62,62,0.8);
    }
    figure > figcaption > a{
        color: #fff;
        padding: 10px;
        border: 0;
    }
</style>
@endsection

@section('content')
<section class="news-container">
    @foreach ($categories->chunk(3) as $category)
        <div class="row">
            @foreach($category as $cat)
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="box category-group">
                        <h3 class="category-heading"><a href="{{route('front.news.category',str_slug($cat->label))}}" class="link" target="_blank">{{ucwords($cat->label)}}</a></h3>
                        @foreach ($cat->recentNews as $i=>$news)
                            @if($i == 0)
                                <figure>
                                    <div class="image">
                                        <img src="{{$news->imageThumbnail(400,712)}}" alt="{{$news->title}}" class="img-responsive">
                                    </div>
                                    <figcaption>
                                        <a href="{{$news->getLink('front.news.show',$cat->label)}}" class="link" target="_blank">{{$news->title}} <small>({{date_create($news->pub_date)->format('M-d')}})</small></a>
                                    </figcaption>
                                </figure>
                            @else
                                <a href="{{$news->getLink('front.news.show',$cat->label)}}" class="link news-link" title="{{$news->title}}"> {{mb_strimwidth($news->title,0,37,"...")}} <small>({{date_create($news->pub_date)->format('M-d')}})</small></a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</section>

@endsection