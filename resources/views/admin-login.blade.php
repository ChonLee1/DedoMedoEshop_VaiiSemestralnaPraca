@extends('layouts.app')
@section('title', 'Admin Login')
@section('content')
<div class="container" style="margin: 5rem auto; max-width: 450px;">
    <div style="background: #f9f9f9; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h1 style="text-align: center; margin-bottom: 2rem;">🔐 Admin Prihlásenie</h1>

        @if ($errors->any())
            <div style="background: #ffebee; border: 1px solid #ef5350; color: #c62828; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            <div style="margin-bottom: 1.5rem;">
                <label for="email" style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', 'admin@demo.test') }}"
                    required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="password" style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Heslo</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="1234"
                    required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem; font-size: 1rem;">
                Prihlásiť sa
            </button>
        </form>

        <div style="margin-top: 1.5rem; text-align: center; color: #999; font-size: 0.9rem;">
            <p><strong>Demo účet:</strong><br>
            Email: admin@demo.test<br>
            Heslo: 1234</p>
        </div>

        <div style="margin-top: 1rem; text-align: center;">
            <a href="{{ route('home') }}" style="color: #666;">← Späť na domov</a>
        </div>
    </div>
</div>
@endsection

