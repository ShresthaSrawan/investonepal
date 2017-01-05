<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width"/>
    <title>InvestoNepal | @yield('title')</title>
</head>
<body style="width: 100% !important; min-width: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 0; padding: 0;">
<!-- Navigation -->
<table class="body"
       style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; height: 100%; width: 100%; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0; border: 1px solid #aaa;">
    <tr style="vertical-align: top; text-align: left; padding: 0;" align="left">
        <td class="center" align="center" valign="top"
            style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: center; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;">
            <table class="row header"
                   style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; padding: 0px; background: #2c3e50; color:#fff">
                <tr style="vertical-align: top; text-align: left; padding: 0;" align="left">
                    <td class="center" align="center"
                        style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: center; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;"
                        valign="top">
                        <table class="container"
                               style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: inherit; width: 580px; margin: 0 auto; padding: 0;">
                            <tr style="vertical-align: top; text-align: left; padding: 0;" align="left">
                                <td class="wrapper last"
                                    style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 0px 0px;"
                                    align="left" valign="top">
                                    <table class="twelve columns"
                                           style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 580px; margin: 0 auto; padding: 0;">
                                        <tr style="vertical-align: top; text-align: left; padding: 0;" align="left">
                                            <td class="six sub-columns"
                                                style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; min-width: 0px; width: 50%; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 10px 10px 0px;"
                                                align="left" valign="top">
                                                <span style="float: left">
                                                    <a href="{{route('index')}}" target="_blank"
                                                   style="color: #2ba6cb; text-decoration: none; font-size: 17px; text-transform: uppercase">InvestoNepal</a>
                                                </span>
                                                <span style="float: right;color:#fff">
                                                    @if(isset($date))
                                                        Send Date: {{$date}}
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <br>
    <table class="container"
           style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: inherit; width: 580px; margin: 15px auto; padding: 0;">
        <tr style="vertical-align: top; text-align: left; padding: 0;" align="left">
            <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;"
                align="left" valign="top">
                @yield('content')
            </td>
        </tr>
    </table>
    <hr style="color: #d9d9d9; height: 1px; background: #d9d9d9; border: none;">
    <table class="row"
           style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; padding: 0px;">
        <tr class="twelve columns" style="vertical-align: top; text-align: left; padding: 0;">
            <td class="wrapper last"
                style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 0px 0px;"
                align="left" valign="top">
                <center style="width: 100%; min-width: 580px;">
                    For feedback, please mail us at <a target="_blank" href="mailto:investonepal@gmail.com"
                                                       style="color: #2ba6cb; text-decoration: none;">investonepal@gmail.com</a>
                </center>
            </td>
        </tr>
        <tr class="twelve columns" style="vertical-align: top; text-align: left; padding: 0;">
            <td align="center"
                style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;"
                valign="top">
                <center style="width: 100%; min-width: 580px;">
                    <a target="_blank" href="{{route('index')}}" style="color: #2ba6cb; text-decoration: none;">Home</a> |
                    <a target="_blank" href="{{route('stock','index')}}" style="color: #2ba6cb; text-decoration: none;">Index</a> |
                    <a target="_blank" href="{{route('stock','today')}}" style="color: #2ba6cb; text-decoration: none;">Todays
                        Price</a> |
                    <a target="_blank" href="{{route('stock','marketreport')}}"
                       style="color: #2ba6cb; text-decoration: none;">Market Report</a>
                </center>
            </td>
        </tr>
        <tr class="twelve columns" style="vertical-align: top; text-align: left; padding: 0;">
            <center>
                <p style="font-size:10px;">
                    (c) Copyright. InvestoNepal.
                    Kathmandu, Nepal

                    All rights reserved. The information contained herein: (1) is proprietary
                    to InvestoNepal and/or its content providers; (2) may not be copied or
                    distributed; and (3) is not warranted to be accurate, complete or timely.
                    Neither InvestoNepal nor its content providers are responsible for any damages
                    or losses arising from any use of this information.
                </p>
            </center>
        </tr>
    </table>
</table>
</body>
</html>