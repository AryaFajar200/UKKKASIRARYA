<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit discount') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('proses-edit-detail-discount', ['id' => $discount->id]) }}" method="POST" class="form-container">
                        @csrf

                        <div class="form-group">
                            <label for="discount_name">Nama discount:</label>
                            <input type="text" class="form-control" id="discount_name" discount_name="discount_name" value="{{ $discount->discount_name }}" disabled>
                        </div>

                        <div class="form-group">
                            <label>Menu</label><br>
                            @foreach($menu as $menues)
                            <div class="form-check form-check-inline mb-3">
                                <input class="form-check-input" type="checkbox" name="menus[]" id="menu_{{ $menues->id }}" value="{{ $menues->id }}"
                                @if($discount->menus->pluck('id')->contains($menues->id)) checked @endif>
                                <label class="form-check-label" for="menu_{{ $menues->id }}">{{ $menues->menu_name}}</label>
                            </div>
                        @endforeach

                        </div>

                        <button type="submit" class="btn btn-primary" style="background-color: #007bff; color: #fff;">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>