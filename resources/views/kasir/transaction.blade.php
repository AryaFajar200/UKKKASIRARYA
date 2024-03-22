<x-app-layout>
    <script src="https://kit.fontawesome.com/e0d812d232.js" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css','resources/js/app.js'])

    
    <link rel="stylesheet" href="/css/style.css">
    <x-slot name="header">
        <div class="bg-[#136788] py-4">
            <h2 class="font-semibold text-3xl text-white dark:text-gray-200 leading-tight text-center">
                {{ __('KASIR RAMEN XYZ') }}
            </h2>
        </div>
    </x-slot>
   
    <div class="py-12 bg-[]">
       

        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 flex flex-wrap" >
            <!-- Menus grid -->
            <div class="w-full lg:w-2/3">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg"
                    style="height: 600px; overflow-y: auto; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);">
                    
                    <div class="p-8 text-gray-900">
                        <h2 class="font-semibold text-lg text-center">DATA MENU</h2>
                      
                        
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach ($menuData as $menu)
                            <div class="border rounded-lg overflow-hidden shadow-md">
                                <img src="{{ asset($menu->menu_image) }}" alt="menu Image" class="w-full h-40 object-cover">
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold">{{ $menu->menu_name }}</h3>
                                    <div class="flex justify-between items-center mt-2">
                                        <div>
                                            @if (isset($menu->discount_price) && $menu->discount_price != $menu->price)
                                            <p class="text-sm text-green-600 line-through">Rp {{ number_format($menu->price) }}</p>
                                            <p class="text-sm text-red-600">Rp {{ number_format($menu->discount_price) }}</p>
                                        
                                         

                                            @else
                                            <p class="text-sm text-green-600">Rp {{ number_format($menu->price) }}</p>
                                            @endif
                                            <p class="text-sm">{{ $menu->stock }}</p>
                                        </div>
                                        <div class="">
                                            <button
                                        onclick="MENUQTY('{{ $menu->id }}', '{{ $menu->menu_name }}', {{ $menu->discount_price ?? $menu->price }}, '{{ $menu->stock }}', false)"
                                        class="px-4 py-2 text-white rounded ml-2  {{
                                            $menu->stock == 'habis' ? 'bg-gray-500 disabled:opacity-50 cursor-not-allowed' : 'bg-blue-700'
                                            }}"
                                        {{ $menu->stock == 'habis' ? 'disabled' : '' }}>-</button>
                                    <button
                                    onclick="MENUQTY('{{ $menu->id }}', '{{ $menu->menu_name }}', {{ $menu->discount_price ?? $menu->price }}, '{{ $menu->stock }}', true, {{ $menu->discount()->exists() && $menu->discount->first() ? $menu->discount->first()->discount_rate : 0 }})"
                                    class="px-4 py-2 text-white rounded bg-color {{
                                            $menu->stock == 'habis' ? 'bg-gray-500 disabled:opacity-50 cursor-not-allowed' : 'bg-red-700'
                                            }}"
                                        {{ $menu->stock == 'habis' ? 'disabled' : '' }}>+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            
            

            <!-- Selected items list -->
            <div class="w-full lg:w-1/3 pl-4 "  >
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg"
                    style="height: 850px; overflow-y: auto; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);">
                    
                    <div class="p-4 text-gray-900 ">
                       
                            <div class="flex justify-between items-center bg-[#136788] text-white px-4 py-2">
                                <div class="flex items-center"> <!-- Menambahkan flex dan items-center di sini -->
                                    <i class="fas fa-shopping-cart mr-2"></i> <!-- Tambahkan ikon keranjang di sini -->
                                    <h2 class="font-semibold text-lg">Keranjang</h2>
                                </div>
                                <button onclick="clearAllItems()" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                            
                  
                        
                        
                        <div style="overflow-y: auto; height: 300px;">
                            <table id="addedItemsTable"
                                class="mt-4 min-w-full divide-y divide-gray-200">
                                <thead class="">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">
                                            Nama
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">
                                            QTY
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">
                                            Discount Rate
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">
                                            Harga
                                        </th>
                                        
                                    </tr>
                                </thead>
                                <tbody id="itemsTableBody"
                                    class="bg-white divide-gray-200">
                                    <!-- Data yang dipilih akan muncul disini -->
                                    
                                </tbody>
                            </table>
                        </div>
                        <hr class="mt-5 mb-5">
                        <p hidden>Total Harga: <span id="totalHarga" style="color: red;" hidden>Rp 0</span></p>
                        <form id="submitForm" action="{{ route('proses-transaction') }}" method="POST" class="shrink-0 grid grid-cols-2 gap-4">
                            @csrf
                            <input type="hidden" name="items" id="itemsInput">
                            <input type="hidden" name="payment_status" id="payment_status" value="sudah dibayar">
                            <!-- Form data transaksi -->
                            <div>
                                <label for="no_table">Nomor Meja</label>
                                <input type="text" name="no_table" id="no_table" class="mt-1 block w-full">
                            </div>
                            <div>
                                <label for="order_type">Jenis Pesanan</label>
                                <select name="order_type" id="order_type" class="mt-1 block w-full">
                                    <option value="dine in">Dine In</option>
                                    <option value="takeaway">Takeaway</option>
                                </select>
                            </div>
                            <div>
                                <label for="payment_type">Jenis Pembayaran</label>
                                <select name="payment_type" id="payment_type" class="mt-1 block w-full">
                                    <option value="tunai">Tunai</option>
                                    <option value="non tunai">Non Tunai</option>
                                </select>
                            </div>
                           
                            <div class="hidden"
                                <label for="bonus_discount">Bonus Diskon</label>
                                <input type="number" name="bonus_discount" id="bonus_discount" class="mt-1 block w-full">
                            </div>
                            <div>
                                <label for="total_price">Total Harga</label>
                                <input type="number" name="total_price" id="total_price" class="mt-1 block w-full" readonly>
                            </div>
                            <div>
                                <label for="cash">Dibayar</label>
                                <input type="number" name="cash" id="cash" class="mt-1 block w-full">
                            </div>
                            <div>
                                <label for="uang_kembalian">Kembalian</label>
                                <input type="number" name="uang_kembalian" id="uang_kembalian" class="mt-1 block w-full" readonly>
                            </div>
                            <!-- Tombol untuk submit -->
                            <button class="col-span-2 mt-4 px-4 py-2 bg-[#0c4e68]  text-white rounded hover:bg-[#136788] focus:outline-none" type="submit">Beli</button>
                        </form>
                        
                        
                            </div>
                        </div>
                    </div>
         
                </div>
            </div>
       
        </div>
    </div>

    <script>
        let addedItems = [];

// Fungsi ini digunakan untuk menambahkan atau mengurangi barang ke dalam keranjang
function MENUQTY(id, menu_name, price, stock, isAdding, discount_rate) {
    // Mencari index barang dalam array berdasarkan nama
    const existingItemIndex = addedItems.findIndex(item => item.menu_name === menu_name);
    // Jika barang sudah ada dalam array
    if (existingItemIndex !== -1) {
        // Jika aksi adalah menambahkan
        if (isAdding) {
            // Cek apakah status stok adalah "tersedia"
            if (stock === 'tersedia') {
                addedItems[existingItemIndex].qty += 1;
            } else {
                // Jika status stok adalah "habis", tampilkan pesan error
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: `${menu_name} sedang habis.`,
                });
            }
        } else {
            // Jika aksi adalah mengurangi
            if (addedItems[existingItemIndex].qty > 1) {
                addedItems[existingItemIndex].qty -= 1;
            } else {
                // Jika kuantitas = 1, hapus barang dari array
                addedItems.splice(existingItemIndex, 1);
            }
        }
    } else {
        // Jika barang belum ada dalam array dan aksi adalah menambahkan
        if (isAdding && stock === 'tersedia') {
            // Terapkan diskon jika ada

            addedItems.push({ id, menu_name, price, discount_rate, qty: 1, totalHarga: price });
        } else {
            // Jika barang belum ada dalam keranjang dan aksi adalah mengurangi, atau status stok adalah "habis", tampilkan pesan error
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: stock === 'tersedia' ? `${menu_name} tidak ada di keranjang.` : `${menu_name} sedang habis.`,
            });
        }
    }
    if (existingItemIndex !== -1 || isAdding) {
        addedItems.forEach(item => {
            if (item.menu_name === menu_name) {
                if (item.discount_rate > 0) {
                    const discountAmount = item.price * (item.discount_rate / 100);
                    const discountedHarga = item.price - discountAmount;
                    item.totalHarga = item.price * item.qty;
                } else {
                    item.totalHarga = item.price * item.qty;
                }
            }
        });
    }
    // Memperbarui daftar barang yang telah ditambahkan
    updateAddedItemsList();
}

function clearAllItems() {
    if (addedItems.length === 0) {
        Swal.fire({
            icon: 'info',
            title: 'Oops...',
            text: "There's no data to be cleared.",
        });
    } else {
        addedItems = [];
        updateAddedItemsList();
        document.getElementById('totalHarga').textContent = 'Rp 0';
    }
}
// Function to toggle visibility of payment fields based on payment status



// Fungsi ini digunakan untuk memperbarui tampilan daftar barang yang telah ditambahkan
// Fungsi untuk memperbarui total harga berdasarkan nilai bonus diskon yang dimasukkan pengguna
// Fungsi untuk memperbarui total harga berdasarkan bonus diskon dalam bentuk persentase
function updateTotalHargaWithBonusDiscount() {
    const totalHargaBeforeDiscount = addedItems.reduce((acc, item) => acc + item.totalHarga, 0);
    const bonusDiscountPercentage = parseFloat(document.getElementById('bonus_discount').value) || 0;

    // Ubah persentase diskon menjadi nilai diskon sebenarnya
    const bonusDiscount = (bonusDiscountPercentage / 100) * totalHargaBeforeDiscount;

    const totalHargaAfterDiscount = totalHargaBeforeDiscount - bonusDiscount;

    document.getElementById('totalHarga').textContent = `Rp ${totalHargaAfterDiscount.toLocaleString()}`;
    document.getElementById('total_price').value = totalHargaAfterDiscount;
}


// Panggil fungsi untuk memperbarui total harga ketika nilai bonus diskon berubah
document.getElementById('bonus_discount').addEventListener('input', updateTotalHargaWithBonusDiscount);

// Fungsi updateAddedItemsList() diperbarui untuk menghitung total harga tanpa bonus diskon
// Fungsi updateAddedItemsList() diperbarui untuk menghitung total harga tanpa bonus diskon
function updateAddedItemsList() {
    const tableBody = document.getElementById('itemsTableBody');
    tableBody.innerHTML = '';
    let totalHargaBeforeDiscount = 0;

    addedItems.forEach((item) => {
        const row = document.createElement('tr');

        const menu_nameCell = document.createElement('td');
        menu_nameCell.textContent = item.menu_name;
        menu_nameCell.className = 'px-6 py-4 whitespace-nowrap';

        const qty = document.createElement('td');
        qty.textContent = item.qty;
        qty.className = 'px-6 py-4 whitespace-nowrap';

        const discount_rateCell = document.createElement('td'); // Fix: Define discount_rateCell here
        discount_rateCell.className = 'px-6 py-4 whitespace-nowrap';
        if (item.discount_rate > 0) {
            const discountSpan = document.createElement('span');
            discountSpan.textContent = `${item.discount_rate}%`;
            discount_rateCell.appendChild(discountSpan);
        } else {
            discount_rateCell.textContent = 'No discount available';
        }

        const totalHargaCell = document.createElement('td');
        totalHargaCell.textContent = `Rp ${item.totalHarga.toLocaleString()}`;
        totalHargaCell.className = 'px-6 py-4 whitespace-nowrap';

        row.appendChild(menu_nameCell);
        row.appendChild(qty);
        row.appendChild(discount_rateCell);
        row.appendChild(totalHargaCell);

        tableBody.appendChild(row);
        totalHargaBeforeDiscount += item.totalHarga;
    });

    // Update nilai total harga tanpa bonus diskon
   document.getElementById('totalHarga').textContent = `Rp ${totalHargaBeforeDiscount.toLocaleString()}`;
    document.getElementById('total_price').value = totalHargaBeforeDiscount;

    // Enable or disable the Uang Diberikan input based on the addedItems array
    const cashInput = document.getElementById('cash');
    if (addedItems.length > 0) {
        cashInput.disabled = false;
    } else {
        cashInput.disabled = true;
        document.getElementById('uang_kembalian').value = '';
    }
}


const cashInput = document.getElementById('cash');
cashInput.addEventListener('input', updateChangeAmount);

function updateChangeAmount() {
    const totalHarga = parseFloat(document.getElementById('total_price').value);
    const cashAmount = parseFloat(document.getElementById('cash').value);

    if (!isNaN(totalHarga) && !isNaN(cashAmount) && cashAmount >= totalHarga) {
        const changeAmount = cashAmount - totalHarga;
        document.getElementById('uang_kembalian').value = changeAmount;
    } else {
        document.getElementById('uang_kembalian').value = '';
    }
}

// Panggil fungsi untuk menginisialisasi total harga saat halaman dimuat
updateAddedItemsList();


// Fungsi ini dipanggil saat form disubmit untuk memastikan ada barang yang ditambahkan
document.getElementById('submitForm').onsubmit = function (event) {
    const selectedPaymentStatus = document.getElementById('payment_status').value;
    if (selectedPaymentStatus === 'bayar nanti') {
        // Jika status pembayaran adalah "bayar nanti", izinkan pengiriman dengan nilai uang diberikan = 0
        console.log("Data yang akan dikirim:", addedItems);
        document.getElementById('itemsInput').value = JSON.stringify(addedItems);
    } else {
        const cash = document.getElementById('cash').value;
        const uangKembalian = document.getElementById('uang_kembalian').value;
        if (!cash || isNaN(cash) || parseInt(cash, 10) <= 0) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Attention!',
                text: 'Please insert the Uang Diberikan input!',
            });
        } else if (uangKembalian < 0) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Sorry, Your money isn\'t enough.',
                text: 'Please input it again!',
            });
        } else {
            console.log("Data yang akan dikirim:", addedItems);
            document.getElementById('itemsInput').value = JSON.stringify(addedItems);
        }
    }
};

// Menampilkan pesan sukses jika ada setelah DOM dimuat
document.addEventListener('DOMContentLoaded', function () {
    const orderTypeSelect = document.getElementById('order_type');
    const noTableInput = document.getElementById('no_table');

    // Tambahkan event listener untuk memantau perubahan pada select order_type
    orderTypeSelect.addEventListener('change', function () {
        const orderType = orderTypeSelect.value;

        // Jika order_type adalah "takeaway", set readonly dan kosongkan nilai input no_table
        if (orderType === 'takeaway') {
            noTableInput.setAttribute('readonly', 'readonly');
            noTableInput.value = '';
        } else {
            // Jika order_type bukan "takeaway", hapus atribut readonly dari input no_table
            noTableInput.removeAttribute('readonly');
        }
    });

    // Panggil event listener untuk pertama kali saat DOM dimuat
    orderTypeSelect.dispatchEvent(new Event('change'));

    document.getElementById('payment_status').addEventListener('change', function() {
        // Ambil nilai yang dipilih pada dropdown
        var selectedPaymentStatus = this.value;
        
        // Ambil elemen-elemen yang perlu diubah tampilannya
        var cashInput = document.getElementById('cash');
        var changeInput = document.getElementById('uang_kembalian');
        var cashLabel = document.querySelector('label[for="cash"]');
        var changeLabel = document.querySelector('label[for="uang_kembalian"]');

        // Jika status pembayaran adalah "bayar nanti"
        if (selectedPaymentStatus === 'bayar nanti') {
            // Sembunyikan field untuk memasukkan jumlah uang yang dibayar dan kembalian
            cashInput.style.display = 'none';
            changeInput.style.display = 'none';
            cashLabel.style.display = 'none';
            changeLabel.style.display = 'none';
            
        } else {
            // Jika status pembayaran bukan "bayar nanti", tampilkan kembali kedua field tersebut
            cashInput.style.display = 'block';
            changeInput.style.display = 'block';
            cashLabel.style.display = 'block';
            changeLabel.style.display = 'block';
        }
    });
    updateChangeAmount();

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Completed!',
        text: '{{ session('success') }}',
    });
    @endif
});
    </script>
        
   

</x-app-layout>