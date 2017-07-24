@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="page-header">
                    <h1>
                        {{ $profile_user->name }}
                        <small>Since {{ $profile_user->created_at->diffForHumans() }}</small>
                    </h1>
                </div>

                @foreach($activities as $date => $activities_on_date)
                    <h3 class="page-header">{{ $date }}</h3>
                    @foreach($activities_on_date as $activity)
                        @if(view()->exists('profiles.activities.' . $activity->type))
                            @include('profiles.activities.' . $activity->type)
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@stop