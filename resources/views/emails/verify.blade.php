@extends('emails.master')
@section('title')
Verify Email
@endsection
@section('content')
		Dear {{$username}},
        Thanks for creating an account in InvestoNepal.
        Please follow the link below to verify your email address
        <a href="{{ route('verify-user', $confirmation_code) }}">{{ route('verify-user', $confirmation_code) }}</a>.<br/>
@endsection