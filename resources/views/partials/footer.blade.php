<!-- resources/views/partials/footer.blade.php -->
<div class="site-footer">
    <div class="footer-inner">
        <div class="footer-grid">
            <div class="col about">
                <div class="brand">
                    <svg width="48" height="48" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <circle cx="12" cy="12" r="12" fill="#F4C042"/>
                        <g transform="translate(3 3)" fill="#5B3F2B">
                            <ellipse cx="6" cy="6" rx="3" ry="2.5"/>
                            <rect x="4" y="9" width="4" height="1.2" rx="0.6"/>
                        </g>
                    </svg>
                    <span class="brand-name">DedoMedo</span>
                </div>
                <p class="desc">Natural honey straight from our beehives. Family-owned beekeeping tradition since 1995.</p>
            </div>

            <div class="col contact">
                <h4>Contact Us</h4>
                <ul class="contact-list">
                    <li>
                        <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 3v18h20V3H2zm18 2v2l-4 2-4-2V5h8zM4 19V9l6 3v6H4z" /></svg>
                        <a href="tel:+420123456789" aria-label="Call +420 123 456 789">+420 123 456 789</a>
                    </li>
                    <li>
                        <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 4h20v16H2z" /></svg>
                        <a href="mailto:info@dedomedo.cz" aria-label="Email info at dedomedo dot cz">info@dedomedo.cz</a>
                    </li>
                    <li>
                        <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2l4 4v14H8V6l4-4z" /></svg>
                        <address class="adr">Bohemia, Czech Republic</address>
                    </li>
                </ul>
            </div>

            <div class="col social">
                <h4>Follow Us</h4>
                <div class="social-icons" aria-label="Social links">
                    <a href="#" class="social-btn" aria-label="Facebook">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M22 12a10 10 0 1 0-11.5 9.9v-7h-2.2V12h2.2V9.8c0-2.2 1.3-3.4 3.3-3.4.9 0 1.8.1 1.8.1v2h-1c-1 0-1.3.6-1.3 1.3V12h2.3l-.4 2.9h-1.9v7A10 10 0 0 0 22 12z"/></svg>
                    </a>
                    <a href="#" class="social-btn" aria-label="Instagram">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5z"/></svg>
                    </a>
                    <a href="mailto:info@dedomedo.cz" class="social-btn" aria-label="Email">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 4h20v16H2z"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <hr class="footer-sep" />

        <div class="footer-bottom">
            <p>© {{ date('Y') }} DedoMedo. All rights reserved.</p>
        </div>
    </div>
</div>
