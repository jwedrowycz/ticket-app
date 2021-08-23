@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('Tablica zgłoszeń') }}</h2>
    <tickets-component></tickets-component>
</div>
@endsection
