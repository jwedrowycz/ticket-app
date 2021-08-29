@extends('layouts.app')

@section('title', 'Pytania')
@section('content')
<div class="container">
    <add-ticket-component category="questions" title="Pytania"></add-ticket-component>
    <tickets-component category="questions" title="Pytania"></tickets-component>
</div>
@endsection
