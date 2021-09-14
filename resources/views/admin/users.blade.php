@extends('layouts.app')

@section('title', 'Użytkownicy')
@section('content')
<div class="container">
    <h2>{{ __('Użytkownicy') }}</h2>
    <users-component></users-component>
</div>
@endsection
