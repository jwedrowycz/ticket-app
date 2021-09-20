@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
<div class="container bg-white p-5">
    
    <div class="col-lg-12">
        <h1>{{ $ticket->title }} | {{ $ticket->category->value }}</h1>
    </div>
    <div class="col-lg-12">
        <p>{{ $ticket->descr }}</p>
    </div>
    <div class="col-lg-12">
        <p><b>{{ $ticket->status->state }}</b> | <b>{{ $ticket->priority->state }}</b></p>
    </div>
    @if(count($ticket->files) > 0)
    <div class="col-lg-12">
        <h4>{{ __('Załączniki') }}:</h4>
    </div>
        <div class="col-lg-12 d-flex flex-row">
            <div>
                @foreach($ticket->files as $file)
                    <img class="thumbnail p-2" src="{{ url('/storage') . '/'. $file->filename}}">
                @endforeach
            </div>
        </div>
    @endif
    <div class="col-lg-12">
    @if(count($ticket->comments) > 0)
        <h3>{{ __('Komentarze') }}</h3>
        @foreach($ticket->comments as $comment)
        <div class="bg-light p-3 mb-2 rounded d-flex justify-content-between" >
            <div>
                <b>{{ $comment->user->name }}</b>:&nbsp;{{ $comment->content }}
            </div>
            <div>
                <small>{{ $comment->created_at }}</small>
            </div>
        </div>
        @endforeach
    @endif
    </div>
</div>
@endsection
