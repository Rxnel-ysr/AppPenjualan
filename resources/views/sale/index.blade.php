@extends('layouts.app')

@section('content')

@php
$orderBy = request()->query('order_by');
$sortBy = request()->query('sort');
@endphp
<div class="container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-3">
        <div class="w-25">
            <a href="{{ route('sale.create') }}" class="btn btn-dark rounded px-4 py-2 shadow">
                Add Item
            </a>
        </div>

        <div class="ms-md-auto">
            <form class="d-flex flex-column flex-md-row gap-4 align-items-md-center" method="get">

                <div class="d-flex align-items-center gap-2">
                    <label for="sort" class="mb-0 small">Sort:</label>
                    <select class="form-select border-0 rounded-3 px-3"
                        id="sort" name="sort" style="min-width: 100px;">
                        <option value="asc" {{ $sortBy == 'asc' ? 'selected' : '' }}>Oldest</option>
                        <option value="desc" {{ $sortBy == 'desc' ? 'selected' : '' }}>Newest</option>
                    </select>
                </div>

                <div class="d-flex gap-2 ms-md-3">
                    <button type="submit" class="btn btn-dark">Search</button>
                    <a href="{{ route('sale.index') }}" role="link" class="btn btn-dark">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark text-light border-0 rounded-4 shadow-lg">

                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="formModalLabel">Overview/Edit Item</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form class="needs-validation" action="{{ route('sale.update') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body px-5">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="id" name="id" value="">

                        <div class="mb-4">
                            <label for="customer_select" class="form-label text-uppercase small">Customer</label>
                            <select id="customer_select" class="form-select bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" name="customer_id" required>
                                <option class="bg-dark" disabled selected>Choose...</option>
                                @foreach ($customers as $id => $name)
                                <option class="bg-dark" value="{{ $id }}">{{ $name }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="cashier_select" class="form-label text-uppercase small">Cashier</label>
                            <select id="cashier_select" class="form-select bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" name="cashier_id" required>
                                <option class="bg-dark" disabled selected>Choose...</option>
                                @foreach ($cashiers as $id => $username)
                                <option class="bg-dark" value="{{ $id }}">{{ $username }}</option>
                                @endforeach

                            </select>
                        </div>

                    </div>

                    <div class="modal-footer border-0 px-5 pb-4">
                        <button type="submit" form="sale_pdf" class="btn btn-light rounded-3 px-4">Print Detail</button>
                        <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger rounded-3 px-4" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
                        <button type="submit" class="btn btn-secondary rounded-3 px-4 shadow-sm">Submit</button>
                    </div>
                </form>
                <form action="{{ route('sale.pdf') }}" id="sale_pdf" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                </form>
                <form action="{{ route('sale.delete') }}" id="delete_form" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" value="id" id="delete_id">
                </form>

            </div>
        </div>
    </div>
    <button type="button" class="d-none" data-bs-toggle="modal" data-bs-target="#editModal" id="edit_btn">Edit Item</button>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteLabel">
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
                    <button type="submit" class="btn btn-danger" form="delete_form">
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
                <th scope="col">Cashier</th>
                <th scope="col">Customer</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sales as $sale)

            <tr class="hover-effect item-table" data-item='@json($sale)'>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $sale->cashier->username }}</td>
                <td class="text-center">{{ $sale->customer->name }}</td>
            </tr>
            @empty
            <tr class="hover table-dark text-center">
                <td colspan="3" class="fw-bold">No Data... yet?</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $sales->links('pagination::bootstrap-5') }}
    </div>


    @push('scripts')
    <script type="text/javascript">
        const edit_modal = document.getElementById('editModal');
        const edit_btn = document.getElementById('edit_btn')
        document.querySelectorAll('.item-table').forEach(row => {
            row.addEventListener('click', () => {
                let data = JSON.parse(row.dataset.item);
                console.log(edit_modal, data);
                edit_modal.querySelectorAll('#id').forEach(item => item.value = data.id)
                edit_modal.querySelector('#customer_select').value = data.customer.id;
                edit_modal.querySelector('#cashier_select').value = data.cashier.id;
                // edit_modal.querySelector('#delete_id').value = data.id;
                edit_btn.click();
            });
        });
    </script>
    @endpush
    @endsection