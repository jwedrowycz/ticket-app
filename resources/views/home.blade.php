@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
<div class="container">
    {{-- <add-ticket-component></add-ticket-component> --}}
    <tickets-component></tickets-component>
</div>
@endsection
