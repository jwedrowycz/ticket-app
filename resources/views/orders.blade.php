@extends('layouts.app')

@section('title', 'Zapotrzebowanie')
@section('content')
<div class="container">
    <add-ticket-component category="orders" title="Zapotrzebowanie"></add-ticket-component>
    <tickets-component category="orders"></tickets-component>
</div>
@endsection
