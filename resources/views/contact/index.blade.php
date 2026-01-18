@extends('layouts.app')
@section('title','Kontakt - DedoMedo e-shop')
@section('content')
    <div class="container" style="margin: 3rem auto; max-width: 800px;">
        <div class="contact-header" style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">Kontaktujte nás 📧</h1>
            <p style="font-size: 1.1rem; color: #666;">Máte otázky? Chcete vedieť viac o našom mede? Pošlite nám správu!</p>
        </div>

        @if ($errors->any())
            <div class="alert alert--error" style="margin-bottom: 2rem; padding: 1rem; background: #fee; border: 1px solid #fcc; border-radius: 4px; color: #c00;">
                <h4>Chyba pri odoslaní</h4>
                <ul style="margin-top: 0.5rem; padding-left: 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert--success" style="margin-bottom: 2rem; padding: 1rem; background: #efe; border: 1px solid #cfc; border-radius: 4px; color: #060;">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('contact.store') }}" class="contact-form" style="background: #f9f9f9; padding: 2rem; border-radius: 8px;">
            @csrf

            <div style="margin-bottom: 1.5rem;">
                <label for="name" style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Meno *</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;"
                    placeholder="Vaše meno"
                >
                @error('name')
                    <span style="color: #c00; font-size: 0.9rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="email" style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Email *</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;"
                    placeholder="vasa@email.com"
                >
                @error('email')
                    <span style="color: #c00; font-size: 0.9rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="subject" style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Predmet *</label>
                <input
                    type="text"
                    id="subject"
                    name="subject"
                    value="{{ old('subject') }}"
                    required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;"
                    placeholder="Téma vašej správy"
                >
                @error('subject')
                    <span style="color: #c00; font-size: 0.9rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="message" style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Správa *</label>
                <textarea
                    id="message"
                    name="message"
                    required
                    rows="6"
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box; font-family: inherit;"
                    placeholder="Vaša správa..."
                >{{ old('message') }}</textarea>
                @error('message')
                    <span style="color: #c00; font-size: 0.9rem;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn--primary" style="width: 100%; padding: 0.75rem; font-size: 1rem; cursor: pointer;">
                Odoslať správu
            </button>
        </form>

        <div class="contact-info" style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #ddd;">
            <h2 style="margin-bottom: 1.5rem;">Ďalšie kontaktné údaje</h2>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div>
                    <h3 style="margin-bottom: 0.5rem;">📍 Adresa</h3>
                    <p style="color: #666;">DedoMedo e-shop<br>Medová 123<br>Slovensko</p>
                </div>
                <div>
                    <h3 style="margin-bottom: 0.5rem;">📞 Telefón</h3>
                    <p style="color: #666;"><a href="tel:+421123456789" style="color: #d4a574; text-decoration: none;">+421 1 234 56789</a></p>
                </div>
                <div>
                    <h3 style="margin-bottom: 0.5rem;">✉️ Email</h3>
                    <p style="color: #666;"><a href="mailto:info@dedomedo.sk" style="color: #d4a574; text-decoration: none;">info@dedomedo.sk</a></p>
                </div>
                <div>
                    <h3 style="margin-bottom: 0.5rem;">🕐 Pracovný čas</h3>
                    <p style="color: #666;">Po - Pia: 09:00 - 17:00<br>So - Ne: Zatvorené</p>
                </div>
            </div>
        </div>
    </div>
@endsection

