@extends('layouts.app')

@section('title', 'Awarie')
@section('content')
<div class="container">
    @unlessrole('admin')
        <add-ticket-component category="incidents" title="Awaria"></add-ticket-component>
    @endunlessrole
    <tickets-component category="incidents"></tickets-component>
</div>
@endsection
