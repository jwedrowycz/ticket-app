@extends('layouts.app')

@section('title', 'Zapotrzebowanie')
@section('content')
<div class="container">
    @unlessrole('admin')
        <add-ticket-component category="orders" title="Zapotrzebowanie"></add-ticket-component>
    @endunlessrole
    <tickets-component category="orders"></tickets-component>
</div>
@endsection
