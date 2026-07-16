@extends('layouts.main')

@section('title', 'Profil — ' . config('app.name', 'DocuPocket'))

@push('head')
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
@endpush

@section('content')
    <section class="page-heading">
        <span class="eyebrow">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                <path d="m9 12 2 2 4-4"/>
            </svg>
            Postavke računa
        </span>
        <h1>Profil</h1>
        <p>Uredi osobne podatke, promijeni lozinku ili obriši račun.</p>
    </section>

    <div class="space-y-6 max-w-4xl">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
