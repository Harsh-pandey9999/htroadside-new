@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    @include('home.partials.hero')
    
    <!-- Services Section -->
    @include('home.partials.services')
    
    <!-- How It Works Section -->
    @include('home.partials.how-it-works')
    
    <!-- Plans Section -->
    @include('home.partials.plans')
    
    <!-- Testimonials Section -->
    @include('home.partials.testimonials')
    
    <!-- Stats Section -->
    @include('home.partials.stats')
    
    <!-- CTA Section -->
    @include('home.partials.cta')
    
    <!-- FAQ Section -->
    @include('home.partials.faq')
@endsection
