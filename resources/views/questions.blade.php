@extends('layouts.app')

@section('title', 'Pytania')
@section('content')
<div class="container">
    @unlessrole('admin')
        <add-ticket-component category="questions" title="Pytanie"></add-ticket-component>
    @endunlessrole
    <tickets-component category="questions"></tickets-component>
</div>
@endsection
