@extends('layouts.app')

@section('content')
    <meta name="user-id" content="{{ Auth::user()->id }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-12">
                <div class="card">
                    <profile-info :auth-user="{{ Auth::user() }}"></profile-info>
                </div>
            </div>
        </div>
    </div>
@endsection


