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
                    <form action="{{ route('proses-edit-menu', ['id' => $menu->id]) }}" method="POST" class="form-container" enctype="multipart/form-data">
                        @csrf


                        <div class="form-group">
                            <label for="name">Nama Menu:</label>
                            <input type="text" class="form-control" id="menu_name" name="menu_name" placeholder="Nama Barang" value="{{ $menu->menu_name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="stock">Stock:</label>
                            <select class="form-control" name="stock" id="stock" required>
                                <option value="tersedia" {{ $menu->stock == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="habis" {{ $menu->stock == 'habis' ? 'selected' : '' }}>Habis</option>
                            </select>
                        </div>
                        

                    
                        <div class="form-group">
                            <label for="foto_barang">Foto Barang:</label>
                            <img src="{{ asset($menu->menu_image) }}" alt="Barang Image" class="mb-3" style="width: 300px;">
                            <input type="file" class="form-control" name="menu_image">
                        </div>

                        <div class="form-group">
                            <label for="category_id">Category:</label>
                            <select class="form-control" name="category_id" id="category_id" required>
                                <option value="">Choose a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $menu->category_id == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">description:</label>
                            <input type="text" class="form-control" name="description" placeholder="description" value="{{ $menu->description }}"  required>
                        </div>
                     

                        <div class="form-group">
                            <label for="price">price:</label>
                            <input type="number" class="form-control" name="price" placeholder="price" value="{{ $menu->price }}" min="0" required>
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