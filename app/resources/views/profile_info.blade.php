@extends('layouts.app')

@section('content')
    <meta name="user-id" content="{{ Auth::user()->id }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Client Info</div>

                    <div class="card-body">
                        <client-info></client-info>
                    </div>
                    <div class="card-header">Personal Info</div>

                    <div class="card-body">
                        <personal-info :auth-user="{{ Auth::user() }}"></personal-info>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


