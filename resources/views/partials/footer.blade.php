{{-- resources/views/partials/footer.blade.php --}}
<div class="site-footer">
    <div class="footer-inner">

        {{-- Hlavná mriežka päty: 3 stĺpce (O nás / Kontakt / Sociálne siete) --}}
        <div class="footer-grid">

            {{-- Stĺpec: O nás / značka + krátky popis --}}
            <div class="col about">
                <div class="brand">
                    {{-- Ikona/logotyp (SVG) – jednoduchá „medová“ značka --}}
                    <svg width="48" height="48" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <circle cx="12" cy="12" r="12" fill="#F4C042"/>
                        <g transform="translate(3 3)" fill="#5B3F2B">
                            <ellipse cx="6" cy="6" rx="3" ry="2.5"/>
                            <rect x="4" y="9" width="4" height="1.2" rx="0.6"/>
                        </g>
                    </svg>

                    {{-- Názov brandu --}}
                    <span class="brand-name">DedoMedo</span>
                </div>

                {{-- Krátky opis (TIP: zvaž preklad cez @lang) --}}
                <p class="desc">
                    Natural honey straight from our beehives. Family-owned beekeeping tradition since 1995.
                </p>
            </div>

            {{-- Stĺpec: Kontakt – tel., e-mail, adresa --}}
            <div class="col contact">
                <h4>Contact Us</h4>
                <ul class="contact-list">
                    <li>
                        {{-- Ikona + telefón (klikateľný tel: odkaz) --}}
                        <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M2 3v18h20V3H2zm18 2v2l-4 2-4-2V5h8zM4 19V9l6 3v6H4z" />
                        </svg>
                        <a href="tel:+420123456789" aria-label="Call +420 123 456 789">+420 123 456 789</a>
                    </li>
                    <li>
                        {{-- Ikona + e-mail (mailto:) --}}
                        <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M2 4h20v16H2z" />
                        </svg>
                        <a href="mailto:info@dedomedo.cz" aria-label="Email info at dedomedo dot cz">info@dedomedo.cz</a>
                    </li>
                    <li>
                        {{-- Ikona + adresa (semanticky <address>) --}}
                        <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 2l4 4v14H8V6l4-4z" />
                        </svg>
                        <address class="adr">Bohemia, Czech Republic</address>
                    </li>
                </ul>
            </div>

            {{-- Stĺpec: Sociálne siete (ikony ako odkazy) --}}
            <div class="col social">
                <h4>Follow Us</h4>

                {{-- Skupina tlačidiel s ikonami (ARIA label pre čítačky) --}}
                <div class="social-icons" aria-label="Social links">
                    <a href="#" class="social-btn" aria-label="Facebook">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="#"/>
                        </svg>
                    </a>

                    <a href="#" class="social-btn" aria-label="Instagram">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="#"/>
                        </svg>
                    </a>

                    {{-- Rýchly kontakt e-mailom aj v „sociálnych“ ikonách --}}
                    <a href="mailto:info@dedomedo.cz" class="social-btn" aria-label="Email">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M2 4h20v16H2z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Deliaca linka medzi obsahom a spodkom päty --}}
        <hr class="footer-sep" />

        {{-- Spodná lišta s autorskými právami a dynamickým rokom --}}
        <div class="footer-bottom">
            <p>© {{ date('Y') }} DedoMedo. All rights reserved.</p>
        </div>
    </div>
</div>
