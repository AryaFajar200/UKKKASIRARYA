<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaction</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
    <div class="relative py-3 sm:max-w-xl sm:mx-auto">
        <div class="relative px-4 py-10 bg-white mx-8 md:mx-0 shadow rounded-3xl sm:p-10">
            <div class="max-w-md mx-auto">
                <div class="flex items-center space-x-5">
                    <div class="block pl-2 font-semibold text-xl self-start text-gray-700">
                        <h2 class="leading-relaxed">Edit Transaction</h2>
                    </div>
                </div>
                <div class="mt-7">
                    <p>TOTAL HARGA</p>
                    <label for="cash" class="block text-xs font-semibold text-gray-600 uppercase">{{ $transaction->total_price }}</label>
                </div>
                <form action="{{ route('transaction.update', ['transaction_id' => $transaction->id]) }}" method="POST" class="mt-10">
                    @csrf
                    @method('PUT')

                  
                    
                    <div class="mt-7">
                        <label for="payment_status" class="block text-xs font-semibold text-gray-600 uppercase">Payment Status</label>
                        <select id="payment_status" name="payment_status" class="border p-2 w-full mt-1">
                            <option value="sudah dibayar" {{ $transaction->payment_status == 'sudah dibayar' ? 'selected' : '' }}>Sudah Dibayar</option>
                            <option value="bayar nanti" {{ $transaction->payment_status == 'bayar nanti' ? 'selected' : '' }}>Bayar Nanti</option>
                        </select>
                    </div>
                    <div class="mt-7">
                        <label for="cash" class="block text-xs font-semibold text-gray-600 uppercase">Uang Diberikan</label>
                        <input type="text" id="cash" name="cash" value="{{ $transaction->cash }}" class="border p-2 w-full mt-1">
                    </div>
                    <div class="mt-7">
                        <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded-full tracking-wide font-semibold uppercase focus:outline-none focus:shadow-outline hover:bg-blue-600 hover:shadow-lg">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
     function updateTotalPrice() {
        const totalHargaBeforeDiscount = parseInt(document.getElementById("total_price").value, 0);
        const bonusDiscountPercentage = parseFloat(document.getElementById("bonus_discount").value) || 0;
    
    // Check if input values are valid numbers
  
    // Calculate the discount amount based on the bonus discount percentage
    const bonusDiscount = (bonusDiscountPercentage / 100) * totalHargaBeforeDiscount ;
    
    // Calculate the updated total price by subtracting the discount amount
    const totalHargaAfterDiscount = totalHargaBeforeDiscount - bonusDiscount;

    // Update the total price input value
    document.getElementById('total_price').value = totalHargaAfterDiscount;
}


    </script>
</body>
</html>
