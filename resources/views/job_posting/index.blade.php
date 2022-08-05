@extends('master.master')

@section('title')
    Job_posting
@endsection

@section('content')
    <div class="container">
        <job-posting-component :posting ="{{ $posting }}"/>

    </div>
@endsection