<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('proses-edit-discount', ['id' => $discount->id]) }}" method="POST" class="form-container" enctype="multipart/form-data">
                        @csrf


                        <div class="form-group">
                            <label for="name">Nama Discount</label>
                            <input type="text" class="form-control" id="discount_name" name="discount_name" placeholder="Nama discount" value="{{ $discount->discount_name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="discount_rate">discount_rate:</label>
                           <input type="number" class="form-control" id="discount_rate" name = "discount_rate" placeholder="discount Ratio" value="{{ $discount->discount_rate }}" required>
                        </div>
                        <div class="form-group">
                            <label for="start_date">start_date:</label>
                           <input type="date" class="form-control" id="start_date" name = "start_date" placeholder="discount Ratio" value="{{ $discount->start_date }}" required>
                        </div>
                        <div class="form-group">
                            <label for="end_date">end_date:</label>
                           <input type="date" class="form-control" id="end_date" name = "end_date" placeholder="discount Ratio" value="{{ $discount->end_date }}" required>
                        </div>
                        

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                        <button type="submit" class="btn btn-primary" style="background-color: #007bff; color: #fff;">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>




<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>