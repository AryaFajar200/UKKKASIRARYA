<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@vite(['resources/css/app.css','resources/js/app.js'])


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Menu') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <h2 class="text-lg font-semibold mt-4  text-center ">Daftar Menu</h2>

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form action="{{ route('search-menu') }}" method="GET">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Search for Menu..." name="search" value="{{ request()->query('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                        <button class="px-6 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
                            <a href="{{ route('add-menu-page')}}" class="px-4 py-2">Tambah Menu</a>
                        </button>
                        
                </div> 
                           
                        
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <td scope="col" class="px-6 py-3">No.</th>
                <td scope="col" class="px-6 py-3">
                    Nama Menu
                </th>
                <th scope="col" class="px-6 py-3">
                    Image
                </th>
                <th scope="col" class="px-6 py-3">
                    Price
                </th>
                <th scope="col" class="px-6 py-3">
                    STOK
                </th>
                <th scope="col" class="px-6 py-3">
                    DESKRIPSI
                </th>
                <th scope="col" class="px-6 py-3">
                    Kategori
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
                @foreach ($menu as $menues) 
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white ">
                    {{ $no++ }}
                </td>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$menues->menu_name}}
                </th>
                <td class="px-6 py-4">
  
                    <img src="{{ asset($menues->menu_image) }}" alt="Barang Image" style="width: 100px; display: block; margin: auto;">
                  
                </td>
                <td class="px-6 py-4">
                    {{$menues->price}}
                </td>
                <td class="px-6 py-4">
                    {{$menues->stock}}
                </td>
                <td class="px-6 py-4">
                    {{$menues->description}}
                </td>
                <td class="px-6 py-4">
                    {{$menues->category->category_name}}
                </td>
            </td>
            <td class="px-6 py-4">
                <div style="display: flex; align-items: center; margin-top: 15px;">
                    <form action="{{ route('edit-menu', ['id' => $menues->id]) }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-primary" style="background-color: #007bff; color: #fff;">Edit</button>
                    </form>
                    <form action="{{ route('delete-menu', ['id' => $menues->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger ml-2" style="background-color: #FF0000; color: #fff;">Delete</button>
                    </form>

                </div>
            </td>
            </tr>
            
            @endforeach 
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {!! $menu->links() !!}
    </div>
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

