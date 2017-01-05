@extends('emails.master')
@section('title')
Expiry notification
@endsection
@section('content')
Dear {{$username}},
Your account is going to expire on {{$expiry}}. Please renew your account in order to continue using the services provided. For furthur enquiry contact the administrator or send a mail at <a href="mailto:investonepal@gmail.com">investonepal@gmail.com</a>.

Thank You,

Regards.

Contact No: <a href="tel:5544567">5544567</a>
@endsection