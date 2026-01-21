/**
 * API Helper - AJAX volania na backend
 */

class APIClient {
    constructor(baseUrl = '/api') {
        this.baseUrl = baseUrl;
    }

    /**
     * Filtruj produkty podľa kategórie a hľadaného textu
     */
    async filterProducts(categoryId = null, searchTerm = null) {
        const params = new URLSearchParams();
        if (categoryId) params.append('category_id', categoryId);
        if (searchTerm) params.append('search', searchTerm);

        try {
            const url = `${this.baseUrl}/products/filter?${params}`;
            console.log('Fetching:', url);
            const response = await fetch(url, {
                method: 'GET',
                headers: { 'Accept': 'application/json' }
            });
            const data = await response.json();
            console.log('API Response:', data);
            return data;
        } catch (error) {
            console.error('API Error:', error);
            return { success: false, error: error.message };
        }
    }

    /**
     * GET /api/products
     * Načítaj všetky produkty
     */
    async getProducts() {
        try {
            const response = await fetch(`${this.baseUrl}/products`, {
                method: 'GET',
                headers: { 'Accept': 'application/json' }
            });
            return await response.json();
        } catch (error) {
            console.error('API Error:', error);
            return { success: false, error: error.message };
        }
    }

    /**
     * POST /api/cart/add
     * Pridaj produkt do košíka
     */
    async addToCart(productId, qty = 1) {
        try {
            const response = await fetch(`${this.baseUrl}/cart/add`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    product_id: productId,
                    qty: qty
                })
            });
            return await response.json();
        } catch (error) {
            console.error('API Error:', error);
            return { success: false, error: error.message };
        }
    }
}

window.api = new APIClient('/api');

// ==================== PRODUCT FILTER ====================
function initProductFilter() {
    const categorySelect = document.getElementById('category-filter');
    const searchInput = document.getElementById('search-filter');
    const productsContainer = document.getElementById('products-list');
    const noResultsMsg = document.getElementById('no-results');

    if (!categorySelect && !searchInput) return;

    if (categorySelect) {
        categorySelect.addEventListener('change', () => filterAndDisplay());
    }

    if (searchInput) {
        let debounceTimer;
        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => filterAndDisplay(), 300);
        });
    }

    async function filterAndDisplay() {
        const categoryId = categorySelect?.value || null;
        const searchTerm = searchInput?.value || null;

        if (productsContainer) {
            productsContainer.innerHTML = '<p class="text-muted">Načítavam...</p>';
        }

        const result = await window.api.filterProducts(categoryId, searchTerm);

        if (!result.success) {
            if (productsContainer) {
                productsContainer.innerHTML = '<p class="alert alert-danger">Chyba pri načítavaní produktov</p>';
            }
            return;
        }

        const products = result.data;

        if (products.length === 0) {
            if (productsContainer) {
                productsContainer.innerHTML = '';
            }
            if (noResultsMsg) noResultsMsg.style.display = 'block';
            return;
        }

        if (productsContainer) {
            productsContainer.innerHTML = products.map(product => `
                <div class="product-card">
                    <div style="width: 100%; height: 200px; background: #f0f0f0; border-radius: 8px; overflow: hidden; margin-bottom: 1rem; display: flex; align-items: center; justify-content: center;">
                        ${product.image_url
                            ? `<img src="${product.image_url}" alt="${product.name}" style="width: 100%; height: 100%; object-fit: cover;">`
                            : `<span style="font-size: 3rem;">🍯</span>`
                        }
                    </div>
                    <h3><a href="/products/${product.id}" style="color: inherit; text-decoration: none;">${product.name}</a></h3>
                    <p class="text-muted">${product.category}</p>
                    <p class="price">€${product.price_eur}</p>
                    <p class="stock">
                        ${product.stock > 0
                            ? `<span class="badge bg-success">${product.stock} ks skladom</span>`
                            : `<span class="badge bg-danger">Vypredané</span>`
                        }
                    </p>
                    <p class="description">${product.description || 'Bez popisu'}</p>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="/products/${product.id}" class="btn btn-outline-primary" style="flex: 1;">
                            Zobraziť detail
                        </a>
                        <button class="btn btn-primary add-to-cart-btn" data-product-id="${product.id}">
                            🛒
                        </button>
                    </div>
                </div>
            `).join('');

            document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
                btn.addEventListener('click', handleAddToCart);
            });
        }

        if (noResultsMsg) noResultsMsg.style.display = 'none';
    }

    filterAndDisplay();
}

async function handleAddToCart(event) {
    const btn = event.target;
    const productCard = btn.closest('.product-card');
    const productId = btn.dataset.productId;
    const productName = productCard?.querySelector('h3')?.textContent || 'Produkt';
    const priceText = productCard?.querySelector('.price')?.textContent || '0 €';
    const price = parseFloat(priceText.replace('€', '').replace(',', '.'));

    btn.disabled = true;
    const originalText = btn.textContent;
    btn.textContent = 'Pridávam...';

    try {
        if (typeof cart !== 'undefined') {
            cart.addItem(productId, productName, price, 1);
            btn.textContent = '✅ Pridané!';
        } else {
            alert('Chyba: Košík nie je inicializovaný');
            btn.textContent = originalText;
            btn.disabled = false;
            return;
        }

        setTimeout(() => {
            btn.textContent = originalText;
            btn.disabled = false;
        }, 2000);
    } catch (error) {
        console.error('Cart Error:', error);
        alert('Chyba pri pridaní produktu do košíka');
        btn.textContent = originalText;
        btn.disabled = false;
    }
}

function updateCartCount() {
    const cartCount = document.querySelector('.cart-count');
    if (cartCount) {
        const currentCount = parseInt(cartCount.textContent) || 0;
        cartCount.textContent = currentCount + 1;
    }
}


document.addEventListener('DOMContentLoaded', () => {
    initProductFilter();
});

