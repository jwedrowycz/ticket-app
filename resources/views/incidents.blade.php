@extends('layouts.app')

@section('title', 'Awarie')
@section('content')
<div class="container">
    <add-ticket-component category="incidents"></add-ticket-component>
    <tickets-component category="incidents"></tickets-component>
</div>
@endsection
