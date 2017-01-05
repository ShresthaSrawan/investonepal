@extends('emails.master')
@section('title')
Reset Password
@endsection
@section('content')
    Dear {{$username}},
    Please follow the link to reset your password
    <a href="{{route('reset-password-form',$confirmation_code)}}">{{route('reset-password-form',$confirmation_code)}}</a>.<br/>
@endsection