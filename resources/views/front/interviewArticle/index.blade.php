@extends('front.main')

@section('title')
    @if(isset($interviewList))
        Interview
    @else
        Article
    @endif
@endsection

@section('specificheader')
@endsection

@section('content')
    <?php $itemList="";
        if(isset($interviewList)):
            $itemList = $interviewList;
            $title = "Interview";
        else:
            $itemList = $articleList;
            $title = "Article";
        endif; ?>
    <section class="col-md-12 col-xs-12 category-container box">
        @foreach($itemList as $item)
            <?php 
                $author = "";
                $authorImage = "";
                if(is_null($item->externalDetail)):
                    $author = $item->user;
                    $authorImage = $author->profile_picture;
                else:
                    $author = $item->externalDetail;
                    $authorImage = $author->photo;
                endif;
            ?>
            <div class="col-xs-12 category-list {{is_nepali($item->title)?'np':''}}">
                <div class="media">
                    <div class="media-left">
                        <img class="media-object" src="{{$item->featuredImage->first()->getThumbnail(185,300)}}">
                    </div>
                    <div class="media-body">
                        <a href="#" class="link category-link">
                            {{$item->category->label}}
                        </a>
                        <h4 class="media-heading"><a href="{{$item->getLink('front.interviewArticle.show',$item->category->label)}}" target="_blank" class="link">{{$item->title}}</a></h4>
                        <p class="category-details">{!!mb_strimwidth(strip_tags($item->details),0,160,"...")!!}</p>
                        <div class="category-author">
                            @if(is_null($authorImage) || $authorImage == "")
                                <img src="http://placehold.it/60x60/dddddd/333333?text=NA" class="img-circle no-padding">
                            @else
                                <img src="{{$author->getThumbnail(60,60)}}" class="img-circle no-padding category-author-image">
                            @endif
                            @if(is_null($item->externalDetail))
                                <span class="category-author-name">{{$author->userInfo->first_name}} {{$author->userInfo->last_name}}</span>
                            @else
                                <span class="category-author-name">{{$author->name}}</span>
                            @endif
                            <span class="category-date">{{date_create($item->pub_date)->format('F d, Y')}}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
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