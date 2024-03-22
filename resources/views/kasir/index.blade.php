<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
</head>
<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Kasir') }}
            </h2>
        </x-slot>
        <style>
            body {
                overflow-x: hidden;
            }
        </style>
        <div class="row">
            <div class="col-md-8">
                <h2>Menu</h2>
                <div class="row">
                    @foreach($menus as $menu)
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <img src="{{ asset($menu->menu_image) }}" class="card-img-top img-fluid" alt="{{ $menu->menu_name }}" style="width: 100%; height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $menu->menu_name }}</h5>
                                <p class="card-text">{{ $menu->description }}</p>
                                <p class="card-text">Price: ${{ $menu->price }}</p>
                                <form action="{{ route('kasir.addToCart') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                    <div class="form-group">
                                        <label for="qty">Quantity:</label>
                                        <input type="number" class="form-control" name="qty" id="qty" value="1" min="1">
                                    </div>
                                    <button type="submit" class="btn btn-primary" style="background-color: #007bff; color: #fff;">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <h2>Cart</h2>
                @if(session()->has('cart'))
                <ul class="list-group">
                    @php $total = 0; @endphp
                    @foreach(session()->get('cart') as $menuId => $menu)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $menu['name'] }}
                        <span class="badge badge-primary badge-pill">{{ $menu['qty'] }}</span>
                        ${{ $menu['price'] * $menu['qty'] }}
                        <form action="{{ route('kasir.removeFromCart', $menuId) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" style="background-color: red;">Remove</button>
                        </form>
                    </li>
                    @php $total += $menu['price'] * $menu['qty']; @endphp
                    @endforeach
                </ul>
                <div class="col-md-12">
                    <h2>Transaction Details</h2>
                    <form action="{{ route('kasir.checkout') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="no_table">No. Table:</label>
                            <input type="text" class="form-control" id="no_table" name="no_table" required>
                        </div>
                        <div class="form-group">
                            <label for="order_type">Order Type:</label>
                            <select class="form-control" id="order_type" name="order_type" required>
                                <option value="dine in">Dine In</option>
                                <option value="take away">Take Away</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="payment_type">Payment Type:</label>
                            <select class="form-control" id="payment_type" name="payment_type" required>
                                <option value="tunai">Tunai</option>
                                <option value="non tunai">Non Tunai</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="payment_status">Payment Status:</label>
                            <select class="form-control" id="payment_status" name="payment_status" required>
                                <option value="bayar_nanti">Bayar Nanti</option>
                                <option value="sudah_dibayar">Sudah Dibayar</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cash">Cash:</label>
                            <input type="number" class="form-control" id="cash" name="cash" required>
                        </div>
                        <div class="form-group">
                            <label for="bonus_discount">Bonus Discount:</label>
                            <input type="number" class="form-control" id="bonus_discount" name="bonus_discount">
                        </div>
                        <div class="form-group">
                            <label for="total_price">Total Price:</label>
                            <input type="number" class="form-control" id="total_price" name="total_price" value="{{ $total }}" readonly>
                            
                        </div>
                        <div class="form-group">
                            <label for="change">Change:</label>
                            <input type="number" class="form-control" id="change" name="change" readonly>
                        </div>

                        <button type="submit" class="btn btn-success">Checkout</button>
                   
                    </form>
                </div>
                @else
                <p>Your cart is empty.</p>
                @endif
            </div>
        </div>
    </x-app-layout>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        // Function to calculate change
        $(document).ready(function() {
            $('#cash').on('input', function() {
                var cash = $(this).val();
                var total_price = $('#total_price').val();
                var change = cash - total_price;
                $('#change').val(change);
            });
        });
    </script>
</body>
</html>
