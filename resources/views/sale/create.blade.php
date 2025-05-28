@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row g-4">
        <!-- New Sale Card -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-purple text-white">
                    <h5 class="mb-0"><i class="bi bi-cart-plus me-2"></i>New Sale</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="item_select" class="form-label">Select Item</label>
                        <select id="item_select" class="form-select select2" required>
                            <option disabled selected>Choose an item...</option>
                            @foreach ($items as $item)
                            <option value="{{ $item->id }}" data-price="{{ $item->price }}" data-qty="{{ $item->qty }}" data-name="{{ $item->name }}">
                                {{ $item->name }} - {{ number_format($item->price, 2) }} ({{ $item->qty }} in stock)
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="qty" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="qty" min="1" value="1" required>
                        </div>
                        <div class="col-md-6">
                            <label for="total_price" class="form-label">Total Price</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="text" class="form-control" id="total_price" readonly>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="add_to_cart" class="btn btn-primary w-100">
                        <i class="bi bi-cart-plus me-1"></i> Add to Cart
                    </button>
                </div>
            </div>
        </div>

        <!-- Shopping Cart Card -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-cart-check me-2"></i>Shopping Cart</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="cart_items"></tbody>
                            <tfoot>
                                <tr class="table-active">
                                    <td colspan="3" class="text-end fw-bold">Total:</td>
                                    <td class="fw-bold" id="cart_total">$0.00</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <form id="checkout_form" action="{{ route('sale.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="cart_items" id="cart_items_input">
                        <input type="hidden" name="total" id="cart_total_input">

                        <div class="mb-3">
                            <label for="customer_select" class="form-label">Customer</label>
                            <select id="customer_select" class="form-select select2" name="customer_id">
                                <option disabled selected>Select customer...</option>
                                @foreach ($customers as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" id="clear_cart" class="btn btn-outline-danger">
                                <i class="bi bi-x-circle me-1"></i> Clear Cart
                            </button>
                            <button type="submit" class="btn btn-success" id="checkout_btn" disabled>
                                <i class="bi bi-check-circle me-1"></i> Checkout
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const cartItemsEl = document.getElementById('cart_items');
        const cartTotalEl = document.getElementById('cart_total');
        const checkoutBtn = document.getElementById('checkout_btn');
        const cartItemsInput = document.getElementById('cart_items_input');
        const cartTotalInput = document.getElementById('cart_total_input');

        const formatCurrency = (amount) => '$' + (parseFloat(amount).toFixed(2) || 0);
        const calculateCartTotal = () => cart.reduce((sum, item) => sum + (item.price * item.qty), 0);

        function updateCartDisplay() {
            cartItemsEl.innerHTML = cart.length ? '' : '<tr><td colspan="5" class="text-center py-3">Your cart is empty</td></tr>';
            checkoutBtn.disabled = cart.length === 0;

            cart.forEach((item, index) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                <td>${item.name}</td>
                <td>${formatCurrency(item.price)}</td>
                <td>
                    <div class="d-flex">
                        <button class="btn btn-sm btn-outline-secondary qty-btn decrease" data-index="${index}">-</button>
                        <input type="number" class="form-control form-control-sm qty-input mx-1" value="${item.qty}" min="1" data-index="${index}">
                        <button class="btn btn-sm btn-outline-secondary qty-btn increase" data-index="${index}">+</button>
                    </div>
                </td>
                <td>${formatCurrency(item.price * item.qty)}</td>
                <td><button class="btn btn-sm btn-outline-danger remove-item" data-index="${index}"><i class="bi bi-trash"></i></button></td>
            `;
                cartItemsEl.appendChild(tr);
            });

            const total = calculateCartTotal();
            cartTotalEl.textContent = formatCurrency(total);
            cartTotalInput.value = total;
            cartItemsInput.value = JSON.stringify(cart);

            addCartEventListeners();
        }

        function addCartEventListeners() {
            document.querySelectorAll('.remove-item').forEach(btn => {
                btn.addEventListener('click', () => {
                    cart.splice(btn.dataset.index, 1);
                    saveCart();
                });
            });

            document.querySelectorAll('.decrease').forEach(btn => {
                btn.addEventListener('click', () => {
                    const index = btn.dataset.index;
                    if (cart[index].qty > 1) cart[index].qty--;
                    saveCart();
                });
            });

            document.querySelectorAll('.increase').forEach(btn => {
                btn.addEventListener('click', () => {
                    cart[btn.dataset.index].qty++;
                    saveCart();
                });
            });

            document.querySelectorAll('.qty-input').forEach(input => {
                input.addEventListener('change', () => {
                    const index = input.dataset.index;
                    const newQty = parseInt(input.value);
                    cart[index].qty = newQty > 0 ? newQty : cart[index].qty;
                    saveCart();
                });
            });
        }

        const saveCart = () => {
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartDisplay();
        };

        document.getElementById('clear_cart').addEventListener('click', () => {
            if (confirm('Are you sure you want to clear your cart?')) {
                cart = [];
                saveCart();
            }
        });

        document.getElementById('add_to_cart').addEventListener('click', () => {
            const itemSelect = document.getElementById('item_select');
            const selectedOption = itemSelect.options[itemSelect.selectedIndex];
            const qty = parseInt(document.getElementById('qty').value) || 0;

            if (!selectedOption.value) return alert('Please select an item');
            if (qty < 1) return alert('Please enter a valid quantity');

            const itemId = selectedOption.value;
            const itemName = selectedOption.dataset.name;
            const price = parseFloat(selectedOption.dataset.price);
            const stockQty = parseInt(selectedOption.dataset.qty);

            const existingItem = cart.find(item => item.id === itemId);

            if (existingItem) {
                if ((existingItem.qty + qty) > stockQty) return alert(`Only ${stockQty} items available in stock`);
                existingItem.qty += qty;
            } else {
                if (qty > stockQty) return alert(`Only ${stockQty} items available in stock`);
                cart.push({
                    id: itemId,
                    name: itemName,
                    price: price,
                    qty: qty
                });
            }

            saveCart();
            document.getElementById('qty').value = 1;
            updateTotalPrice();
        });

        function updateTotalPrice() {
            const itemSelect = document.getElementById('item_select');
            const selectedOption = itemSelect.options[itemSelect.selectedIndex];
            const qty = parseInt(document.getElementById('qty').value) || 0;
            const price = selectedOption.value ? parseFloat(selectedOption.dataset.price) : 0;
            document.getElementById('total_price').value = formatCurrency((price * qty) ? price * qty  : 0);
        }

        document.getElementById('item_select').addEventListener('change', updateTotalPrice);
        document.getElementById('qty').addEventListener('input', updateTotalPrice);

        updateCartDisplay();
        updateTotalPrice();
    });
</script>
@endpush