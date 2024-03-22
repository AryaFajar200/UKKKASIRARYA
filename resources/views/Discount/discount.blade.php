<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@vite(['resources/css/app.css','resources/js/app.js'])


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Discount') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <h2 class="text-lg font-semibold mt-4  text-center ">Daftar Discount</h2>

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                        <button class="px-6 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
                            <a href="{{ route('add-discount-page')}}" class="px-4 py-2">Tambah Discount</a>
                        </button>
                        
                </div> 
                           
                        
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <td scope="col" class="px-6 py-3">No.</th>
                <td scope="col" class="px-6 py-3">
                    Nama Discount
                </th>
                <th scope="col" class="px-6 py-3">
                    Discount Rate
                </th>
                <th scope="col" class="px-6 py-3">
                    Start Date
                </th>
                <th scope="col" class="px-6 py-3">
                    End Date
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @php
            // $no = ($data->currentPage() - 1) * $data->perPage() + 1;
            $no = 1;
        @endphp
                @foreach ($data as $index => $discount) 
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white ">
                    {{ $no++ }}
                </td>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$discount->discount_name}}
                </th>
                <td class="px-6 py-4">
                    {{$discount->discount_rate}}%
                </td>
                <td class="px-6 py-4">
                    {{$discount->start_date}}
                </td>
                <td class="px-6 py-4">
                    {{$discount->end_date}}
                </td>
            </td>
            <td class="px-6 py-4">
                <div style="display: flex; align-items: center; margin-top: 15px;">
                    <form action="{{ route('edit-discount', ['id' => $discount->id]) }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-primary" style="background-color: #007bff; color: #fff;">Edit</button>
                    </form>
                    <form action="{{ route('delete-discount', ['id' => $discount->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger ml-2" style="background-color: #FF0000; color: #fff;">Delete</button>
                    </form>
                    

                </div>
            </td>
            </tr>
            
            @endforeach 
        </tbody>
    </table>
    {{-- <div class="d-flex justify-content-center">
        {!! $menu->links() !!}
    </div> --}}
            </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        let message = "{{ session('success') }}";
            if ("{{ session('status') }}" === "added") {
                message = "Data Added Successfully";
            } else if ("{{ session('status') }}" === "updated") {
                message = "Data Updated Successfully";
            }

            Toast.fire({
                icon: "success",
                title: message
            });
        @endif
    });
</script>
    
</x-app-layout>
