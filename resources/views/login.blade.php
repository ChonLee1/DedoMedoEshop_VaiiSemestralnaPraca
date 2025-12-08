@extends('layouts.app')
{{-- dedíme základný layout aplikácie --}}

@section('title','Prihlásenie')
{{-- nastavíme title pre <title> v layoute --}}

@section('content')
    {{-- hlavný obsah stránky --}}
    <div class="login-page">
        <div class="login-container">
            <div class="login-card">

                {{-- Hlavička prihlasovacej karty --}}
                <div class="login-card__header">
                    <h1 class="login-card__title">Prihlásenie</h1>
                    <p class="login-card__subtitle">
                        Vitaj späť v DedoMedo e-shope. Prihlás sa do svojho účtu.
                    </p>
                </div>

                <div class="login-card__body">

                    {{-- Zobrazenie chybových hlásení (napr. nesprávny email/heslo) --}}
                    @if ($errors->any())
                        <div class="login-flash-error">
                            <p class="login-flash-error__text">{{ $errors->first() }}</p>
                        </div>
                    @endif

                    {{-- FORMULÁR – odosiela POST na route('login') --}}
                    <form method="POST" action="{{ route('login') }}" class="login-form">
                        @csrf {{-- ochrana proti CSRF útoku --}}

                        {{-- EMAIL --}}
                        <div class="login-form__group">
                            <label for="email" class="login-form__label">Email</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="login-form__input @error('email') login-form__input--error @enderror"
                                value="{{ old('email') }}" {{-- vyplní späť pri chybe --}}
                                required
                                autofocus
                            >
                        </div>

                        {{-- HESLO --}}
                        <div class="login-form__group">
                            <label for="password" class="login-form__label">Heslo</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="login-form__input @error('password') login-form__input--error @enderror"
                                required
                            >
                        </div>

                        {{-- CHECKBOX "Zapamätať si ma" --}}
                        <div class="login-form__group">
                            <div class="login-form__checkbox-row">
                                <input
                                    type="checkbox"
                                    id="remember"
                                    name="remember"
                                    class="login-form__checkbox"
                                    {{ old('remember') ? 'checked' : '' }} {{-- predvyplnenie --}}
                                >
                                <label for="remember" class="login-form__checkbox-label">
                                    Zapamätať si ma
                                </label>
                            </div>
                        </div>

                        {{-- ODESLANIE FORMULÁRA --}}
                        <div class="login-form__group">
                            <button type="submit" class="login-submit-btn">
                                Prihlásiť sa
                            </button>
                        </div>

                    </form>
                    {{-- Koniec formulára --}}

                </div>
            </div>
        </div>
    </div>
@endsection
