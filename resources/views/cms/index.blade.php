@extends('layouts.app')

@section('content')

        <div class="col-md-10">
			Welcome {{ Auth::user()->name }}. You are logged in as {{Auth::user()->user_role}}.
        </div>

@endsection
