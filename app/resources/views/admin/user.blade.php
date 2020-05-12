@extends('layouts.app')

@section('content')
    <meta name="user-id" content="{{ Auth::user()->id }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <user-management ></user-management>
                </div>
            </div>
        </div>
    </div>
@endsection
