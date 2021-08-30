@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
<div class="container">
    <div class="row row-cols-1 row-cols-md-2 mx-1 justify-content-between text-center">
        <div class="card border-primary mb-3" style="max-width: 18rem;">
            <div class="card-body text-primary">
                <h3 class="card-title">{{ __('Awarie') }}</h5>
                <a href="{{ route('incidents') }}" class="stretched-link"></a>
            </div>
        </div>
        <div class="card border-secondary mb-3" style="max-width: 18rem;">
            <div class="card-body text-secondary">
                <h3 class="card-title">{{ __('Zapotrzebowanie') }}</h5>
                <a href="{{ route('orders') }}" class="stretched-link"></a>
            </div>
        </div>
        <div class="card border-success mb-3" style="max-width: 18rem;">
            <div class="card-body text-success">
                <h3 class="card-title">{{ __('Pytania') }}</h5>
                <a href="{{ route('questions') }}" class="stretched-link"></a>
            </div>
        </div>
    </div>
    <h2>Najnowsze</h2>
    <tickets-component></tickets-component>
</div>
@endsection
