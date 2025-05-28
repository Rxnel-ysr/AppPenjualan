@extends('layouts.app')

@section('content')

@php
$orderBy = request()->query('order_by');
$sortBy = request()->query('sort');
@endphp
<div class="container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-3">
        <!-- Add Item Button -->
        <div class="w-25">
            <button type="button" class="btn btn-dark rounded px-4 py-2 shadow" data-bs-toggle="modal" data-bs-target="#addModal">
                Add Item
            </button>
        </div>

        <!-- Search and Filter Form -->
        <div class="ms-md-auto w-75 w-md-auto">
            <form class="d-flex flex-column flex-md-row gap-4 align-items-md-center" method="get">
                <!-- Search by Name -->
                <div class="d-flex align-items-center gap-2">
                    <label for="name" class="form-label text-uppercase small mb-0">Name</label>
                    <input type="text" class="form-control border-0 rounded-3 px-3"
                        id="name" name="name" value="{{ request()->query('name') }}" style="min-width: 120px;">
                </div>

                <!-- Sorting Options -->
                <div class="d-flex align-items-center gap-2">
                    <label for="order_by" class="mb-0 small">Order By:</label>
                    <select class="form-select border-0 rounded-3 px-3"
                        id="order_by" name="order_by" style="min-width: 100px;">
                        <option value="created_at" {{ $orderBy == 'created_at' ? 'selected' : '' }}>Added</option>
                        <option value="updated_at" {{ $orderBy == 'updated_at' ? 'selected' : '' }}>Edited</option>
                    </select>
                </div>


                <!-- Action Buttons -->
                <div class="d-flex gap-2 ms-md-3">
                    <button type="submit" class="btn btn-dark">Search</button>
                    <a href="{{ route('customer.index') }}" role="link" class="btn btn-dark">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark text-light border-0 rounded-4 shadow-lg">

                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="formModalLabel">Add Category</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form class="needs-validation" action="{{ route('customer.store' )}}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body px-5">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="form-label text-uppercase small">Name</label>
                            <input type="text" class="form-control bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" id="name" name="name" required>
                        </div>

                        <div class="mb-4">
                            <p class="card-title mb-2">Gender</p>
                            <div class="d-flex flex-row gap-3">
                                <label for="male" class="form-check-label text-uppercase small">Male</label>
                                <input type="radio" class="form-check-input bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" id="male" name="gender" value="male" required>
                                <label for="female" class="form-check-label text-uppercase small">Female</label>
                                <input type="radio" class="form-check-input bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" id="female" name="gender" value="female" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label text-uppercase small">Email</label>
                            <input type="email" class="form-control bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" id="email" name="email" required>
                        </div>

                        <div class="mb-4">
                            <label for="address" class="form-label text-uppercase small">Address</label>
                            <textarea type="text" class="form-control bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" id="address" name="address" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="telephone" class="form-label text-uppercase small">Telephone</label>
                            <input type="text" class="form-control bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" id="telephone" name="telephone" required>
                        </div>


                    </div>

                    <div class="modal-footer border-0 px-5 pb-4">
                        <button type="button" class="btn btn-outline-light rounded-3 px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-secondary rounded-3 px-4 shadow-sm">Add</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark text-light border-0 rounded-4 shadow-lg">

                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="formModalLabel">Overview/Edit Item</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form class="needs-validation" action="{{ route('customer.update') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body px-5">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="id" name="id" value="">

                        <div class="mb-4">
                            <label for="name" class="form-label text-uppercase small">Name</label>
                            <input type="text" class="form-control bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" id="name" name="name" required>
                        </div>

                        <div class="mb-4">
                            <p class="card-title mb-2">Gender</p>
                            <div class="d-flex flex-row gap-3">
                                <label for="male" class="form-check-label text-uppercase small">Male</label>
                                <input type="radio" class="form-check-input bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" id="male" name="gender" value="male" required>
                                <label for="female" class="form-check-label text-uppercase small">Female</label>
                                <input type="radio" class="form-check-input bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" id="female" name="gender" value="female" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label text-uppercase small">Email</label>
                            <input type="email" class="form-control bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" id="email" name="email" required>
                        </div>

                        <div class="mb-4">
                            <label for="address" class="form-label text-uppercase small">Address</label>
                            <textarea class="form-control bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" id="address" name="address" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="telephone" class="form-label text-uppercase small">Telephone</label>
                            <input type="text" class="form-control bg-secondary bg-opacity-25 border-0 text-light rounded-3 px-4" id="telephone" name="telephone" required>
                        </div>

                        <input type="hidden" id="old_name" name="old_name" value="">

                    </div>

                    <div class="modal-footer border-0 px-5 pb-4">
                        <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger rounded-3 px-4" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
                        <button type="submit" class="btn btn-secondary rounded-3 px-4 shadow-sm">Update</button>
                    </div>
                </form>
                <form action="{{ route('customer.delete') }}" id="delete_form" method="post">
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
                <th scope="col">Name</th>
                <th scope="col">Address</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($customers as $customer)

            <tr class="hover-effect item-table" data-item='@json($customer)'>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $customer->name }}</td>
                <td class="text-center">{{ $customer->address }}</td>
            </tr>
            @empty
            <tr class="hover table-dark text-center">
                <td colspan="3" class="fw-bold">No Data... yet?</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $customers->links('pagination::bootstrap-5') }}
    </div>


    @push('scripts')
    <script type="text/javascript">
        const edit_modal = document.getElementById('editModal');
        const edit_btn = document.getElementById('edit_btn')
        document.querySelectorAll('.item-table').forEach(row => {
            row.addEventListener('click', () => {
                let data = JSON.parse(row.dataset.item);
                console.log(edit_modal, data);
                edit_modal.querySelector('#id').value = data.id;
                edit_modal.querySelector('#name').value = data.name;
                edit_modal.querySelector('#' + data.gender).checked = true;
                edit_modal.querySelector('#email').value = data.email;
                edit_modal.querySelector('#address').value = data.address;
                edit_modal.querySelector('#telephone').value = data.telephone;
                edit_modal.querySelector('#delete_id').value = data.id;
                edit_btn.click();
            });
        });
    </script>
    @endpush
    @endsection