@extends('layouts.app')

@section('content')
@php
$sort = request()->query('sort');
@endphp
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <button type="button" class="btn btn-dark rounded px-4 py-2 shadow" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus-lg me-2"></i> Restock
            </button>
        </div>
        <div class="d-flex align-items-center ms-2">
            <form class="d-flex gap-3 align-items-center" method="get">
                <label for="sort" class="me-2">Sort:</label>
                <select class="form-select" id="sort" name="sort">
                    <option value="asc" {{ $sort == 'asc' ? 'selected' : '' }}>Oldest</option>
                    <option value="desc" {{ $sort == 'desc' ? 'selected' : '' }}>Newest</option>
                </select>

                <label for="start" class="me-2">Start</label>
                <input type="datetime-local" class="form-control" id="start" name="start" value="{{ request('start') }}">

                <label for="end" class="me-2">End</label>
                <input type="datetime-local" class="form-control" id="end" name="end" value="{{ request('end') }}">

                <button type="submit" class="btn btn-dark ms-3">Search</button>
                <a href="{{ route('sale.index') }}" role="link" class="btn btn-dark ms-3">Reset</a>

            </form>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark text-light border-0 rounded-4 shadow-lg">

                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="formModalLabel">Add new Purchase</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form class="needs-validation" action="{{ route('purchase.store' )}}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body px-5">
                        @csrf

                        <div class="mb-4">
                            <label for="item_select" class="form-label text-uppercase small">Item</label>
                            <select id="item_select" class="form-select bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" name="item_id" required>
                                <option class="bg-dark" disabled selected>Choose...</option>
                                @foreach ($items as $item)

                                <option class="bg-dark" value="{{ $item->id }}">{{$item->name}}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="supplier_select" class="form-label text-uppercase small">Supplier</label>
                            <select id="supplier_select" class="form-select bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" name="supplier_id" required>
                                <option class="bg-dark" disabled selected>Choose...</option>
                                @foreach ($suppliers as $supplier)

                                <option class="bg-dark" value="{{ $supplier->id }}">{{$supplier->name}}</option>
                                @endforeach

                            </select>
                        </div>


                        <div class="mb-4">
                            <label for="qty" class="form-label text-uppercase small">Quantity</label>
                            <input type="number" class="form-control bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" id="qty" name="qty" required>
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
                    <h5 class="modal-title fw-bold" id="formModalLabel">{{__('Edit Purchase')}}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form class="needs-validation" action="{{ route('purchase.update') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body px-5">
                        @method('PUT')
                        @csrf

                        <input type="hidden" id="id" name="id" value="">

                        <div class="mb-4">
                            <label for="item_select" class="form-label text-uppercase small">Items</label>
                            <select id="item_select" class="form-select bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" name="item_id" required>
                                <option class="bg-dark" disabled selected>Choose...</option>
                                @foreach ($items as $item)

                                <option class="bg-dark" value="{{ $item->id }}">{{$item->name}}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="supplier_select" class="form-label text-uppercase small">Supplier</label>
                            <select id="supplier_select" class="form-select bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" name="supplier_id" required>
                                <option class="bg-dark" disabled selected>Choose...</option>
                                @foreach ($suppliers as $supplier)

                                <option class="bg-dark" value="{{ $supplier->id }}">{{$supplier->name}}</option>
                                @endforeach

                            </select>
                        </div>


                        <div class="mb-4">
                            <label for="qty" class="form-label text-uppercase small">Quantity</label>
                            <input type="number" class="form-control bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" id="qty" name="qty" required>
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
                    <h5 class="modal-title" id="item_preview_title">{{__('Purchase (Readonly)')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-4">
                        <label for="supplier" class="form-label text-uppercase small">Supplier</label>
                        <input type="text" class="form-control bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" id="supplier" readonly disabled>
                    </div>

                    <div class="mb-4">
                        <label for="item" class="form-label text-uppercase small">Item</label>
                        <input type="text" step="0.01" class="form-control bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" id="item" name="item" readonly disabled>
                    </div>

                    <div class="mb-4">
                        <label for="qty" class="form-label text-uppercase small">Qty</label>
                        <input type="number" step="0.01" class="form-control bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" id="qty" name="qty" readonly disabled>
                    </div>

                    <div class="mb-4">
                        <label for="purchase_date" class="form-label text-uppercase small">Purchase Date</label>
                        <input type="datetime-local" class="form-control bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" id="purchase_date" name="purchase_date" readonly disabled>
                    </div>
                </div>
                <div class="modal-footer border-0 px-5 pb-4">
                    <button type="button" class="btn btn-outline-warning rounded-3 px-4" data-bs-toggle="modal" data-bs-target="#editModal">Edit Item</button>
                    <form action="{{ route('purchase.delete') }}" id="delete_item" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" value="" id="delete_id">
                    </form>
                    <button type="button" class="btn btn-danger rounded-3 px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#deleteSaleModal">Delete Item</button>
                </div>
            </div>
        </div>
    </div>
    <button type="button" id="preview_btn" class="d-none" data-bs-toggle="modal" data-bs-target="#previewModal"></button>

    <div class="modal fade" id="deletePurchaseModal" tabindex="-1" aria-labelledby="deletePurchaseLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deletePurchaseLabel">
                        {{ __('Are you sure you want to delete this item?') }}
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
                <th scope="col">{{__('No')}}</th>
                <th scope="col">{{__('Item Name')}}</th>
                <th scope="col">{{__('Purchase Date')}}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($purchases as $purchase)
            <tr class="hover-effect table-item" data-item='@json($purchase)'>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $purchase->item->name }}</td>
                <td class="text-center">{{ $purchase->purchase_date }}</td>
            </tr>
            @empty
            <tr class="hover-effect">
                <td colspan="4" class="text-center">{{ __('No data... yet?')}}</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $purchases->links('pagination::bootstrap-5') }}
    </div>


    @push('scripts')
    <script type="text/javascript">
        const edit_modal = document.getElementById('editModal');
        const preview_modal = document.getElementById('previewModal');
        const preview_btn = document.getElementById('preview_btn');

        // items = items == 'object' ? [items] : items;

        document.querySelectorAll('.table-item').forEach(el => {
            el.addEventListener('click', (e) => {
                let data = JSON.parse(el.dataset.item);
                
                preview_modal.querySelector('#delete_id').value = data.id;
                preview_modal.querySelector('#supplier').value = data.supplier.name;
                preview_modal.querySelector('#item').value = data.item.name;
                preview_modal.querySelector('#qty').value = data.qty;
                preview_modal.querySelector('#purchase_date').value = data.purchase_date;
                
                edit_modal.querySelector('#id').value = data.id;
                edit_modal.querySelector('#supplier_select').value = data.supplier.id;
                edit_modal.querySelector('#item_select').value = data.item.id;
                edit_modal.querySelector('#qty').value = data.qty;
                preview_btn.click()
            })
        })
    </script>
    @endpush

</div>
@endsection