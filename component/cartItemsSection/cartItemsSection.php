<div class="cart-card">
    <div class="cart-card-header">
        <span class="cart-card-title">
            <span class="material-icons-outlined">shopping_cart</span>
            Your Items
            <span class="item-count-badge" id="itemCountBadge">0</span>
        </span>
        <button class="clear-cart-btn" onclick="clearCart()">
            <span class="material-icons-outlined">delete_sweep</span>
            Clear All
        </button>
    </div>

    <div id="cart-item"></div>

    <div class="empty-cart" id="emptyCart">
        <div class="empty-cart-icon">
            <span class="material-icons-outlined">shopping_cart</span>
        </div>
        <p class="empty-cart-title">Your cart is empty</p>
        <p class="empty-cart-sub">Browse the bookstore and add items to get started.</p>
        <a href="../../pages/library/library.php" class="browse-btn">
            <span class="material-icons-outlined">storefront</span>
            Browse Products
        </a>
    </div>
</div>

<div class="cart-card">
    <div class="cart-card-header">
        <span class="cart-card-title">
            <span class="material-icons-outlined">edit_note</span>
            Order Notes
        </span>
    </div>
    <div class="notes-wrap">
        <textarea
            id="orderNotes"
            placeholder="Any special instructions or requests for your order..."
            class="notes-textarea"
            onfocus="this.style.borderColor='var(--primary-red)'; this.style.boxShadow='0 0 0 3px rgba(220,23,23,0.1)';"
            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
        ></textarea>
    </div>
</div>