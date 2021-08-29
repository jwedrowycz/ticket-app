@extends('layouts.app')

@section('title', 'Awarie')
@section('content')
<div class="container">
    <add-ticket-component category="incidents" title="Awaria"></add-ticket-component>
    <tickets-component category="incidents"></tickets-component>
</div>
@endsection
