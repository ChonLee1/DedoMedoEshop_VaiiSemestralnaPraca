@extends('layouts.app')
@section('title','Prihlásenie')
@section('content')
<div class="login-page">
    <div class="login-container">
        <div class="login-card">
            <div class="login-card__header">
                <h1 class="login-card__title">Prihlásenie</h1>
                <p class="login-card__subtitle">Vitaj späť v DedoMedo e-shope. Prihlás sa do svojho účtu.</p>
            </div>

            <div class="login-card__body">
                @if ($errors->any())
                    <div class="login-flash-error">
                        <p class="login-flash-error__text">{{ $errors->first() }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf

                    <div class="login-form__group">
                        <label for="email" class="login-form__label">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="login-form__input @error('email') login-form__input--error @enderror"
                            value="{{ old('email') }}"
                            required
                            autofocus
                        >
                        @error('email')
                            <div class="login-form__error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="login-form__group">
                        <label for="password" class="login-form__label">Heslo</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="login-form__input @error('password') login-form__input--error @enderror"
                            required
                        >
                        @error('password')
                            <div class="login-form__error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="login-form__group">
                        <div class="login-form__checkbox-row">
                            <input
                                type="checkbox"
                                id="remember"
                                name="remember"
                                class="login-form__checkbox"
                                {{ old('remember') ? 'checked' : '' }}
                            >
                            <label for="remember" class="login-form__checkbox-label">Zapamätať si ma</label>
                        </div>
                    </div>

                    <div class="login-form__group">
                        <button type="submit" class="login-submit-btn">Prihlásiť sa</button>
                    </div>
                </form>

                <div class="login-card__footer">
                    <span>Nemáš ešte účet?</span>
                    <a href="#" class="login-link">Kontaktuj podporu DedoMedo</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
