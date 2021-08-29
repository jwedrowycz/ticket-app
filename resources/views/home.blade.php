@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
<div class="container">
    {{-- <add-ticket-component></add-ticket-component> --}}
    <tickets-component category="all"></tickets-component>
</div>
@endsection
