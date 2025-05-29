@extends('layouts.app')

@section('content')
@php
$orderBy = request()->query('order_by');
$sortBy = request()->query('sort');
$category = request('category');
@endphp
<div class="container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-3">
        <div class="w-25">
            <button type="button" class="btn btn-dark rounded px-4 py-2 shadow" data-bs-toggle="modal" data-bs-target="#addModal">
                Add Item
            </button>
        </div>

        <div class="w-75 w-md-auto">
            <form class="d-flex flex-column flex-md-row gap-4 align-items-md-center" method="get">
                <div class="d-flex align-items-center gap-2">
                    <label for="name" class="form-label text-uppercase small mb-0">Name</label>
                    <input type="text" class="form-control border-0 rounded-3 px-3"
                        id="name" name="name" value="{{ request()->query('name') }}" style="min-width: 120px;">
                </div>

                <div class="d-flex align-items-center gap-2">
                    <label for="order_by" class="mb-0 small">Order By:</label>
                    <select class="form-select border-0 rounded-3 px-3"
                        id="order_by" name="order_by" style="min-width: 100px;">
                        <option value="updated_at" {{ $orderBy == 'updated_at' ? 'selected' : '' }}>Edited</option>
                        <option value="created_at" {{ $orderBy == 'created_at' ? 'selected' : '' }}>Added</option>
                    </select>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <label for="sort" class="mb-0 small">Sort:</label>
                    <select class="form-select border-0 rounded-3 px-3"
                        id="sort" name="sort" style="min-width: 100px;">
                        <option value="asc" {{ $sortBy == 'asc' ? 'selected' : '' }}>Oldest</option>
                        <option value="desc" {{ $sortBy == 'desc' ? 'selected' : '' }}>Newest</option>
                    </select>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <label for="category_select" class="form-label small">Category</label>
                    <select id="category_select" class="form-select border-0 rounded-3 px-3"
                        name="category" style="min-width: 120px;">
                        <option class="bg-dark" disabled selected>Choose...</option>
                        @foreach ($categories as $id => $name)
                        <option class="bg-dark" value="{{ $id }}" {{ $category == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex gap-2 ms-md-3">
                    <button type="submit" class="btn btn-dark">Search</button>
                    <a href="{{ route('item.index') }}" role="link" class="btn btn-dark">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark text-light border-0 rounded-4 shadow-lg">

                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="formModalLabel">Add new Item</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form class="needs-validation" action="{{ route('item.store' )}}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body px-5">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="form-label text-uppercase small">Name</label>
                            <input type="text" class="form-control bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" id="name" name="name" required>
                        </div>

                        <div class="mb-4">
                            <label for="price" class="form-label text-uppercase small">Price</label>
                            <input type="number" step="0.01" class="form-control bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" id="price" name="price" required>
                        </div>

                        <div class="mb-4">
                            <label for="qty" class="form-label text-uppercase small">Stock</label>
                            <input type="number" class="form-control bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" id="qty" name="qty" required>
                        </div>

                        <div class="mb-4">
                            <label for="add_picture" class="form-label text-uppercase small">Picture <span class="text-capitalize">(Max 2MB)</span></label>
                            <div class="border border-secondary border-opacity-25 rounded-4 p-4 bg-secondary bg-opacity-10 text-center text-muted"
                                id="add_dropArea" style="cursor: pointer;">
                                <i class="bi bi-cloud-arrow-up-fill fs-3 d-block mb-2" style="color: white;"></i>
                                <span id="add_fileLabel" class="text-white">Drag & drop your picture here or click to choose file</span>
                                <input type="file" class="form-control d-none" id="add_picture" name="picture" accept="image/*">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="category_select" class="form-label text-uppercase small">Category</label>
                            <select id="category_select" class="form-select bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" name="category_id" required>
                                <option class="bg-dark" disabled selected>Choose...</option>
                                @foreach ($categories as $id => $name)
                                <option class="bg-dark" value="{{ $id }}">{{ $name }}</option>
                                @endforeach

                            </select>
                        </div>

                    </div>

                    <div class="modal-footer border-0 px-5 pb-4">
                        <button type="button" class="btn btn-outline-light rounded-3 px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-secondary rounded-3 px-4 shadow-sm">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark text-light border-0 rounded-4 shadow-lg">

                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="formModalLabel">Edit Item</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form class="needs-validation" action="{{ route('item.update') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body px-5">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="id" value="">
                        <div class="mb-4">
                            <label for="name" class="form-label text-uppercase small">Name</label>
                            <input type="text" class="form-control bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" value="{{ old('name') }}" id="name" name="name" required>
                        </div>

                        <div class="mb-4">
                            <label for="price" class="form-label text-uppercase small">Price</label>
                            <input type="number" step="0.01" class="form-control bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" value="{{ old('price') }}" id="price" name="price" required>
                        </div>

                        <div class="mb-4">
                            <label for="edit_picture" class="form-label text-uppercase small">Picture <span class="text-capitalize">(Max 2MB, Leave empty to keep old one)</span> </label>
                            <div class="border border-secondary border-opacity-25 rounded-4 p-4 bg-secondary bg-opacity-10 text-center text-muted"
                                id="edit_dropArea" style="cursor: pointer;">
                                <i class="bi bi-cloud-arrow-up-fill fs-3 d-block mb-2" style="color: white;"></i>
                                <span id="edit_fileLabel" class="text-white">Drag & drop your picture here or click to choose file</span>
                                <input type="file" class="form-control d-none" id="edit_picture" name="picture" accept="image/*">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="category_select" class="form-label text-uppercase small">Category</label>
                            <select id="category_select" class="form-select bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" name="category_id" required>
                                <option class="bg-dark" disabled selected>Choose...</option>
                                @foreach ($categories as $id => $name)
                                <option class="bg-dark" value="{{ $id }}">{{ $name }}</option>
                                @endforeach

                            </select>
                        </div>

                    </div>

                    <div class="modal-footer border-0 px-5 pb-4">
                        <button type="button" class="btn btn-outline-light rounded-3 px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-secondary rounded-3 px-4 shadow-sm">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="previewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="item_preview_title">Item Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center" style="min-width: 50dvh;">
                    <img src="" alt="" class="img-fluid h-50" id="item_preview">
                </div>
                <div class="modal-footer border-0 px-5 pb-4">
                    <button type="button" class="btn btn-outline-warning rounded-3 px-4" data-bs-toggle="modal" data-bs-target="#editModal" id="edit_btn">Edit Item</button>
                    <form action="{{ route('item.delete') }}" id="delete_item" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" value="" id="delete_id">
                    </form>
                    <button type="button" class="btn btn-danger rounded-3 px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#deleteItemModal">Delete Item</button>
                </div>
            </div>
        </div>
    </div>
    <button type="button" id="preview_btn" class="d-none" data-bs-toggle="modal" data-bs-target="#previewModal"></button>

    <div class="modal fade" id="deleteItemModal" tabindex="-1" aria-labelledby="deleteItemLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteItemLabel">
                        {{ __('Are you sure you want to delete your account?') }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        {{ __('Once you deleted the item, all of associated data will be lost.') }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="btn btn-danger" form="delete_item">
                        {{ __('Delete Item') }}
                    </button>
                </div>
            </div>
        </div>
    </div>


    <table class="table table-dark table-hover table-sm rounded-3 shadow-lg table-custom" style="user-select: none;">
        <thead class="table-dark">
            <tr class="text-center">
                <th scope="col">No</th>
                <th scope="col">Name</th>
                <th scope="col">Category</th>
                <th scope="col">Price</th>
                <th scope="col">Qty</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $item)

            <tr class="hover-effect item-table"
                data-id="{{ $item->id }}"
                data-img="{{ asset('storage/' . $item->picture) }}"
                data-name="{{ $item->name }}"
                data-category-id="{{ $item->category_id }}"
                data-price="{{ $item->price }}"
                data-qty="{{ $item->qty }}">
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $item->name }}</td>
                <td class="text-center">{{ $item->category->name }}</td>
                <td class="text-center">$ {{ $item->price }}</td>
                <td class="text-center">{{ $item->qty }}</td>
            </tr>
            @empty
            <tr class="hover table-dark text-center">
                <td colspan="5" class="fw-bold">No Data... yet?</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $items->links('pagination::bootstrap-5') }}
    </div>


    @push('scripts')
    <script type="text/javascript">
        setupDropArea({
            dropAreaId: "add_dropArea",
            inputId: "add_picture",
            labelId: "add_fileLabel"
        });
        setupDropArea({
            dropAreaId: "edit_dropArea",
            inputId: "edit_picture",
            labelId: "edit_fileLabel"
        });

        const item_preview = document.getElementById('item_preview');
        const item_preview_btn = document.getElementById('preview_btn');
        const item_preview_title = document.getElementById('item_preview_title');
        const delete_id = document.getElementById('delete_id');
        const item_edit_modal = document.getElementById('editModal');

        document.querySelectorAll('.item-table').forEach(row => {
            row.addEventListener('click', () => {
                const {
                    img,
                    id,
                    name,
                    price,
                    categoryId
                } = row.dataset;

                console.log(img);


                item_preview.src = (img !== '<?= asset('storage') ?>') ? img : '<?= asset('storage/pictures/no-preview.png') ?>';
                item_preview_title.textContent = `Item "${name}" preview`;
                delete_id.value = id;

                Object.assign(item_edit_modal.dataset, {
                    id,
                    name,
                    price,
                    categoryId
                });

                item_preview_btn.click();
            });
        });

        document.querySelector('#edit_btn').addEventListener('click', () => {
            item_edit_modal.querySelector('input[name="id"]').value = item_edit_modal.dataset.id;
            item_edit_modal.querySelector('input[name="name"]').value = item_edit_modal.dataset.name;
            item_edit_modal.querySelector('input[name="price"]').value = item_edit_modal.dataset.price;
            item_edit_modal.querySelector('select[name="category_id"]').value = item_edit_modal.dataset.categoryId || '';
        });
    </script>
    @endpush
</div>
@endsection