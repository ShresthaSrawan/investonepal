@extends('front.main')

@section('title')
{{ucwords($label)}}
@endsection

@section('specificheader')
@endsection

@section('content')
    <section class="col-xs-12 col-md-9 category-container box" id="announcement-category">
        <div class="row">
            <div class="col-xs-12">
                <form>
                    <div class="input-group">
                        {!! Form::select('subtype',$allSubTypes, Request::get('subtype'),['class' => 'form-control']) !!}
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-primary">GO</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <div class="row">
            @if($typeAnn->isEmpty())
                <div class="col-xs-12">
                    <div class="well text-center">
                        <p>No announcements for this category.</p>
                    </div>
                </div>
            @else
                @foreach($typeAnn as $a)
                    <div class="col-xs-12 {{is_nepali($a->title)?'np':''}}">
                        <div class="category-list">
                            <div class="media">
                                <div class="media-left">
                                    <img class="media-object announcement-image" src="{{$a->imageThumbnail(185,300)}}">
                                </div>
                                <div class="media-body">
                                    <a href="{{route('front.announcement.category',str_slug($a->type->label))}}" class="link category-link">
                                        {{ucwords($a->type->label)}} @if($a->subtype!=null) | {{ucwords($a->subtype->label)}}@endif
                                    </a>
                                    <h4 class="media-heading"><a href="{{$a->getLink('front.announcement.show',$a->type->label)}}" class="link">{{$a->title}}</a></h4>
                                    <p>Event: {{strtotime($a->event_date) != false ? date_create($a->event_date)->format('j M') : 'NA'}}
                                    @if(!is_null($a->issue))
                                        @if(!is_null($auction = $a->issue->auction))
                                            @if(!is_null($auction->ordinary) && $auction->ordinary != 0)
                                                | Ordinary: {{$auction->ordinary}}
                                            @endif
                                            @if(!is_null($auction->promoter) && $auction->promoter != 0)
                                                | Promoter: {{$auction->promoter}}
                                            @endif
                                        @else
                                            | Close Date : {{date_create($a->issue->close_date)->format('j M')}} | Kitta: {{$a->issue->kitta}}
                                        @endif
                                    @elseif(!is_null($a->agm))
                                        | Time: {{date_create($a->agm->time)->format('h:i A') }} | Venue: {{ $a->agm->venue }}
                                    @elseif(!is_null($a->financialHighlight))
                                        | Net Profit: {{ $a->financialHighlight->net_profit }}
                                    @elseif(!is_null($a->bondDebenture))
                                        | Kitta: {{$a->bondDebenture->kitta}}
                                    @elseif(!is_null($a->bonusDividend))
                                        @if(!is_null($a->bonusDividend->bonus_share) && $a->bonusDividend->bonus_share != 0)
                                            | Bonus: {{$a->bonusDividend->bonus_share}}
                                        @endif
                                        @if(!is_null($a->bonusDividend->cash_dividend) && $a->bonusDividend->cash_dividend != 0)
                                            | Dividend: {{$a->bonusDividend->cash_dividend}}
                                        @endif
                                    @endif
                                    </p>
                                    <p class="category-details">{!! mb_strimwidth(strip_tags($a->details),0,160,"...")!!}</p>
                                    <div class="category-author">
                                        @if(is_null($a->user->profile_picture) || $a->user->profile_picture == "")
                                            <img src="http://placehold.it/60x60/dddddd/333333?text=NA" class="img-circle no-padding">
                                        @else
                                            <img src="{{$a->user->getThumbnail(60,60)}}" class="img-circle no-padding category-author-image">
                                        @endif
                                        @if(!is_null($a->user_id))
                                            <span class="category-author-name">{{$a->user->userInfo->first_name}} {{$a->user->userInfo->last_name}}</span>
                                        @endif
                                        <span class="category-date">{{$a->timeAgo()}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {!! $typeAnn->render() !!}
            @endif
        </div>
    </section>
    
    <aside class="col-xs-12 col-md-3">
        <div class="panel panel-default no-padding">
            <div class="panel-heading">
                <strong>Latest Announcements</strong>
            </div>
            <div class="panel-body no-padding">
                <ul class="unlist no-padding">
                    @foreach($allTypes as $id=>$type)
                        @if(!$annList[$id]->isEmpty())
                            <li>
                                <h4 class="aside-heading"><a href="{{route('front.announcement.category',str_slug($type))}}" class="link">{{ucwords($type)}}</a></h4>
                                <ul class="unlist news-media-list no-padding">
                                    @foreach($annList[$id] as $i=>$a)
                                        <?php if($i > 1) break; ?>
                                        <li class="aside-item">
                                            <div class="media">
                                                <div class="media-left">
                                                    <img class="media-object announcement-image" src="{{$a->imageThumbnail(75,75)}}">
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="media-heading">
                                                        <a href="{{$a->getLink('front.announcement.show',$a->type->label)}}" class="link">
                                                            {{mb_strimwidth($a->title,0,65,"...")}} <small>({{date_create($a->pub_date)->format('M-d')}})</small>
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
@endsection