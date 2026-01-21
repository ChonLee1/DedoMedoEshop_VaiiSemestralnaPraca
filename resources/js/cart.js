/**
 * DedoMedo Shopping Cart
 * Správa košíka pomocou localStorage
 */

class ShoppingCart {
    constructor() {
        this.storageKey = 'dedomedo_cart';
        this.cart = this.loadCart();
        this.updateCartUI();
    }

    /**
     * Načítaj košík z localStorage
     */
    loadCart() {
        const stored = localStorage.getItem(this.storageKey);
        return stored ? JSON.parse(stored) : [];
    }

    /**
     * Ulož košík do localStorage
     */
    saveCart() {
        localStorage.setItem(this.storageKey, JSON.stringify(this.cart));
        this.updateCartUI();
    }

    /**
     * Pridaj produkt do košíka
     */
    addItem(productId, productName, price, quantity = 1) {
        const id = Number(productId);
        const safeQty = Math.max(1, Number(quantity) || 1); // clamp to at least 1
        const existingItem = this.cart.find(item => Number(item.id) === id);

        if (existingItem) {
            existingItem.quantity += safeQty;
        } else {
            this.cart.push({
                id,
                name: productName,
                price: Number(price),
                quantity: safeQty,
            });
        }

        this.saveCart();
        this.showNotification(`${productName} bol pridaný do košíka!`);
        return true;
    }

    /**
     * Odstráň produkt z košíka
     */
    removeItem(productId) {
        const id = Number(productId);
        this.cart = this.cart.filter(item => Number(item.id) !== id);
        this.saveCart();
        return true;
    }

    /**
     * Uprav množstvo produktu
     */
    updateQuantity(productId, quantity) {
        const id = Number(productId);
        const qty = Math.max(1, Number(quantity) || 1); // ensure quantity stays positive
        const item = this.cart.find(item => Number(item.id) === id);
        if (item) {
            item.quantity = qty;
            this.saveCart();
        }
        return true;
    }

    /**
     * Vymaž celý košík
     */
    clearCart() {
        this.cart = [];
        this.saveCart();
        return true;
    }

    /**
     * Vrať všetky položky v košíku
     */
    getItems() {
        return this.cart;
    }

    /**
     * Vrať počet položiek v košíku
     */
    getItemCount() {
        return this.cart.reduce((sum, item) => sum + item.quantity, 0);
    }

    /**
     * Vrať celkovú cenu v EUR
     */
    getTotalPrice() {
        return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    }

    /**
     * Aktualizuj UI - počet položiek, cena
     */
    updateCartUI() {
        // Aktualizuj counter v navigácii
        const cartIcon = document.querySelector('.cart-icon');
        const cartCountEl = document.querySelector('.cart-count');
        const count = this.getItemCount();
        if (cartIcon) {
            cartIcon.style.fontWeight = count > 0 ? 'bold' : '';
            cartIcon.style.color = count > 0 ? '#d4a574' : '';
        }
        if (cartCountEl) {
            cartCountEl.textContent = String(count);
        }

        // Aktualizuj košík v checkout ak existuje
        const cartContainer = document.getElementById('cart-items');
        if (cartContainer) {
            this.renderCartItems(cartContainer);
        }

        // Aktualizuj celkovú cenu
        const totalEl =
            document.getElementById('cart-total-price') ||
            document.getElementById('total-price');

        if (totalEl) {
            totalEl.textContent = this.getTotalPrice().toFixed(2) + ' €';
        }
    }

    /**
     * Vykresli items v košíku
     */
    renderCartItems(container) {
        if (this.cart.length === 0) {
            container.innerHTML = '<p class="text-center text-muted">Košík je prázdny</p>';
            return;
        }

        let html = '<table class="table"><thead><tr><th>Produkt</th><th>Cena</th><th>Ks</th><th>Spolu</th><th>Akcia</th></tr></thead><tbody>';

        this.cart.forEach(item => {
            const itemTotal = (item.price * item.quantity).toFixed(2);
            html += `
                <tr>
                    <td>${item.name}</td>
                    <td>${item.price.toFixed(2)} €</td>
                    <td>
                        <input type="number" min="1" value="${item.quantity}"
                               onchange="cart.updateQuantity(${item.id}, this.value)"
                               style="width: 50px;">
                    </td>
                    <td><strong>${itemTotal} €</strong></td>
                    <td>
                        <button class="btn btn-sm btn-danger" onclick="cart.removeItem(${item.id})">
                            Odstrániť
                        </button>
                    </td>
                </tr>
            `;
        });

        html += '</tbody></table>';
        container.innerHTML = html;
    }

    /**
     * Zobraz notifikáciu
     */
    showNotification(message) {
        // Vytvor notifikáciu v rovnom rohu
        const notification = document.createElement('div');
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #4caf50;
            color: white;
            padding: 15px 20px;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 9999;
            animation: slideIn 0.3s ease-out;
        `;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    /**
     * Export košíka ako JSON pre server
     */
    exportForCheckout() {
        return JSON.stringify(this.cart);
    }
}

// Inicializuj globálny cart objekt
// Replace local variable with window-scoped instance for ES module context
window.cart = null;
document.addEventListener('DOMContentLoaded', function() {
    window.cart = new ShoppingCart();
});

// Pridaj CSS animáciu
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
`;
document.head.appendChild(style);
