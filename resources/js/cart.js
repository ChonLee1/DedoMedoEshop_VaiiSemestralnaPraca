class ShoppingCart {
    constructor() {
        this.storageKey = 'dedomedo_cart';
        this.cart = this.loadCart();
        this.updateCartUI();
    }

    loadCart() {
        const stored = localStorage.getItem(this.storageKey);
        return stored ? JSON.parse(stored) : [];
    }

    saveCart() {
        localStorage.setItem(this.storageKey, JSON.stringify(this.cart));
        this.updateCartUI();
    }

    addItem(productId, productName, price, quantity = 1) {
        const id = Number(productId);
        const safeQty = Math.max(1, Number(quantity) || 1);
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

    removeItem(productId) {
        const id = Number(productId);
        this.cart = this.cart.filter(item => Number(item.id) !== id);
        this.saveCart();
        return true;
    }

    updateQuantity(productId, quantity) {
        const id = Number(productId);
        const qty = Math.max(1, Number(quantity) || 1);
        const item = this.cart.find(item => Number(item.id) === id);
        if (item) {
            item.quantity = qty;
            this.saveCart();
        }
        return true;
    }

    clearCart() {
        this.cart = [];
        this.saveCart();
        return true;
    }

    getItems() {
        return this.cart;
    }

    getItemCount() {
        return this.cart.reduce((sum, item) => sum + item.quantity, 0);
    }

    getTotalPrice() {
        return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    }

    updateCartUI() {
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

        const cartContainer = document.getElementById('cart-items');
        if (cartContainer) {
            this.renderCartItems(cartContainer);
        }

        const totalEl =
            document.getElementById('cart-total-price') ||
            document.getElementById('total-price');

        if (totalEl) {
            totalEl.textContent = this.getTotalPrice().toFixed(2) + ' €';
        }
    }

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

    showNotification(message) {
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

    exportForCheckout() {
        return JSON.stringify(this.cart);
    }
}

window.cart = null;
document.addEventListener('DOMContentLoaded', function() {
    window.cart = new ShoppingCart();
});

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
