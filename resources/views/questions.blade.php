@extends('layouts.app')

@section('title', 'Pytania')
@section('content')
<div class="container">
    <add-ticket-component category="questions" title="Pytanie"></add-ticket-component>
    <tickets-component category="questions"></tickets-component>
</div>
@endsection
