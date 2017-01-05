<?php
$index = unserialize($index);
$articles = unserialize($articles);
$interviews = unserialize($interviews);
$user = unserialize($user);
$announcements = unserialize($announcements);
?>
@extends('emails.master')
@section('title')
    Watchlist
@endsection
@section('content')
    @if(isset($confirmSend))
        <a href="{{route('admin.command','newsletter:send')}}" style="display: block; width: 160px; position: fixed;top:10px; right: 20px; padding: 10px 20px; text-decoration: none;background: #666; color: #fff;">Confirm Send Newsletter</a>
    @endif
    <a href="{{route('stock','index')}}" style="text-decoration: none;"><h3
                style="color: #fff; background: #666; padding: 5px 15px; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-break: normal; font-size: 25px; margin: 0;"
                align="left">Market Index</h3>

        <p>Data as on {{$index->date }}</p></a>
    <table class="row"
           style="border-spacing: 0; border-collapse: collapse; vertical-align: middle; text-align: left; width: 100%; position: relative; padding: 5px;"
           width="100%" cellpadding="5" cellspacing="5" border="1">
        <thead>
        <th>Index</th>
        <th>Value</th>
        <th>Previous</th>
        <th>Change</th>
        <th>% Change</th>
        </thead>
        <tbody>
        @foreach($index->indexValue as $key => $value)
            <tr>
                @if($value->type!=null)
                    <?php
                    $style = '';
                    $prepend = '';
                    if (intval($value->change()) > 0) {
                        $style = 'color: #f00';
                    } elseif (intval($value->change()) < 0) {
                        $style = 'color: #188811';
                        $prepend = '+ ';
                    }
                    ?>
                    <th style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 5px;"
                        align="left" valign="top">{{$value->type->name}}</th>
                    <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 5px;"
                        align="left" valign="top">{{$value->value}}</td>
                    <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 5px;"
                        align="left" valign="top">{{$value->previous()->value}}</td>
                    <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 5px;"
                        align="left" valign="top"><span style='{{$style}}'>{{$prepend.$value->change()}}</span></td>
                    <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 5px;"
                        align="left" valign="top"><span style='{{$style}}'>{{$prepend.$value->changePercent()}}</span>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    <a href="{{route('stock','today')}}" style="text-decoration: none;"><h3
                style="color: #fff; background: #666; padding: 5px 15px; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-break: normal; font-size: 25px; margin: 35px 0 0 0;"
                align="left">Todays Market Summary</h3></a>
    <table class="row"
           style="border-spacing: 0; border-collapse: collapse; vertical-align: middle; text-align: left; width: 100%; position: relative; padding: 5px;"
           width="100%" cellpadding="5" cellspacing="5">
        <tr style="border-bottom: 1px dotted #aaa">
            <th>Total Companies</th>
            <th style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 5px;"
                align="left" valign="top">{{$todaysSummary['total_company']}}</th>
        </tr>
        <tr style="border-bottom: 1px dotted #aaa">
            <th>Transaction</th>
            <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 5px;"
                align="left" valign="top">{{$todaysSummary['total_tran']}}</td>
        </tr>
        <tr style="border-bottom: 1px dotted #aaa">
            <th>Volume</th>
            <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 5px;"
                align="left" valign="top">{{$todaysSummary['total_vol']}}</td>
        </tr>
        <tr style="border-bottom: 1px dotted #aaa">
            <th>Amount (Rs)</th>
            <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 5px;"
                align="left" valign="top">{{$todaysSummary['total_amt']}}</td>
        </tr>
        <tr style="border-bottom: 1px dotted #aaa">
            <th>Advance</th>
            <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 5px;"
                align="left" valign="top">{{$todaysSummary['advance']}}</td>
        </tr>
        <tr style="border-bottom: 1px dotted #aaa">
            <th>Decline</th>
            <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 5px;"
                align="left" valign="top">{{$todaysSummary['decline']}}</td>
        </tr>
        <tr style="border-bottom: 1px dotted #aaa">
            <th>Neutral</th>
            <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 5px;"
                align="left" valign="top">{{$todaysSummary['neutral']}}</td>
        </tr>
        <tr style="border-bottom: 1px dotted #aaa">
            <th>Market Cap (Mil)</th>
            <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 5px;"
                align="left" valign="top">{{$todaysSummary['market_cap']}}</td>
        </tr>
        <tr style="border-bottom: 1px dotted #aaa">
            <th>Float Market Cap (Mil)</th>
            <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 5px;"
                align="left" valign="top">{{$todaysSummary['float_cap']}}</td>
        </tr>
    </table>
    <table class="row"
           style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;  margin-top: 35px;">
        <tr style="vertical-align: top; text-align: left; padding: 0;" align="left">
            <td class="eight columns"
                style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0 10px 0 0;"
                align="left" valign="top">
                <table class="row"
                       style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;">
                    <tr class="twelve columns" style="vertical-align: top; text-align: left; padding: 0;" align="left">
                        <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;"
                            align="left" valign="top">
                            <a href="{{route('front.news.index')}}" style="text-decoration: none;"><h3
                                        style="color: #fff; background: #666; padding: 5px 15px; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-break: normal; font-size: 25px; margin: 9px 0 0 0;"
                                        align="left">News</h3></a>
                            @foreach($newsList as $news)
                                <table class="row"
                                       style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;">
                                    <tr style="vertical-align: top; text-align: left; padding: 0;" align="left">
                                        <td class="nine columns"
                                            style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; width: 75%; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;"
                                            align="left" valign="top">
                                            <h5 style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 1.2; word-break: normal; font-size: 18px; margin: 0; padding: 0;"
                                                align="left">
                                                <a href="{{$news['link']}}" target="_blank" class="link"
                                                   style="color: #2ba6cb; text-decoration: none;">{{$news['title']}}</a>
                                            </h5>

                                            <p style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 13px; margin: 0 0 10px; padding: 0;"
                                               align="left">
                                                {!! mb_strimwidth(strip_tags($news['details']),0,160,"...")!!}<a
                                                        href="{{$news['link']}}" target="_blank" class="link"
                                                        style="color: #2ba6cb; text-decoration: none;">Read More</a>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            @endforeach
                        </td>
                    </tr>
                </table>
            </td>
            <td class="four columns panel"
                style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #f2f2f2; margin: 0; padding: 10px; border: 1px solid #d9d9d9;"
                align="left" bgcolor="#f2f2f2" valign="top">
                <table class="row"
                       style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;">
                    <tr class="twelve columns" style="vertical-align: top; text-align: left; padding: 0;" align="left">
                        <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;"
                            align="left" valign="top">
                            @if($articles->count()>0)
                                <a href="{{route('front.interviewArticle.index','article')}}"
                                   style="text-decoration: none"><h4
                                            style="color: #fff; background: #666; padding: 5px 15px; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-break: normal; font-size: 23px; margin: 0;"
                                            align="left">Articles</h4></a>
                                @foreach($articles as $article)
                                    <table style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; padding: 0;">
                                        <tr style="vertical-align: top; text-align: left; padding: 0;" align="left">
                                            <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;"
                                                align="left" valign="top">
                                                <h5 class="media-heading"
                                                    style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-break: normal; margin: 0; padding: 0; font-size: 14px;"
                                                    align="left">
                                                    <a href="{{$article->getLink('front.interviewArticle.show',$article->category->label)}}"
                                                       target="_blank" class="link"
                                                       style="color: #2ba6cb; text-decoration: none;">{{$article->title}}</a>
                                                </h5>

                                                <p style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 12px; margin: 0 0 10px; padding: 0;"
                                                   align="left">{!! mb_strimwidth(strip_tags($article->details),0,160,"...")!!}
                                                    <a href="{{$article->getLink('front.interviewArticle.show',$article->category->label)}}"
                                                       target="_blank" class="link"
                                                       style="color: #2ba6cb; text-decoration: none;">Read More</a></p>
                                            </td>
                                        </tr>
                                    </table>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                </table>
                <table class="row"
                       style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;">
                    <tr class="twelve columns" style="vertical-align: top; text-align: left; padding: 0;" align="left">
                        <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;"
                            align="left" valign="top">
                            @if($interviews->count()>0)
                                <a href="{{route('front.interviewArticle.index','article')}}"
                                   style="text-decoration: none"><h4
                                            style="color: #fff; background: #666; padding: 5px 15px; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-break: normal; font-size: 23px; margin: 0;"
                                            align="left">Interviews</h4></a>
                                @foreach($interviews as $interview)
                                    <table style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; padding: 0;">
                                        <tr style="vertical-align: top; text-align: left; padding: 0;" align="left">
                                            <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;"
                                                align="left" valign="top">
                                                <h5 class="media-heading"
                                                    style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-break: normal; font-size: 14px; margin: 0; padding: 0;"
                                                    align="left">
                                                    <a href="{{$interview->getLink('front.interviewArticle.show',$interview->category->label)}}"
                                                       target="_blank" class="link"
                                                       style="color: #2ba6cb; text-decoration: none;">{{$interview->title}}</a>
                                                </h5>

                                                <p style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 12px; margin: 0 0 10px; padding: 0;"
                                                   align="left">{!! mb_strimwidth(strip_tags($interview->details),0,160,"...")!!}
                                                    <a href="{{$interview->getLink('front.interviewArticle.show',$interview->category->label)}}"
                                                       target="_blank" class="link"
                                                       style="color: #2ba6cb; text-decoration: none;">Read More</a></p>
                                            </td>
                                        </tr>
                                    </table>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="twelve columns" style="vertical-align: top; text-align: left; padding: 0;" align="left">
            <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;"
                align="left" valign="top" colspan="2">
                <a href="{{route('front.announcement.index')}}" style="text-decoration: none;"><h3
                            style="color: #fff; background: #666; padding: 5px 15px; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-break: normal; font-size: 25px; margin: 35px 0 0 0;"
                            align="left">Recent Announcements</h3></a>
                <ul>
                    @foreach ($announcements as $announcement)
                        <li>
                            <a href="{{$announcement->getLink('front.announcement.show',$announcement->type->label)}}"
                               target="_blank"
                               style="color: #2ba6cb; text-decoration: none;">{{$announcement->title}}</a>
                        </li>
                    @endforeach
                </ul>
            </td>
        </tr>
    </table>
    <center>
        <p style="font-size:10px;">This newsletter is sent to {{$user->email}}. Click <a
                    href="{{route('user.profile.newsletter')}}">here</a> to unsubscribe any future newsletters. </p>
    </center>
@endsection