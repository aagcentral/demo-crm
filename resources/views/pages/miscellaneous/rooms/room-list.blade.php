@extends('pages.layouts.app')
@section('title')
Room
@endsection

@section('css')

@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-6 col-sm-12">
                <h4>Create And Manage Room</h4>
            </div>
            <div class="col-md-6 col-sm-12">
                <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                    <li class="breadcrumb-item"><a href="{{route('panel.dashboard')}}">Dasboard</a></li>
                    <li class="breadcrumb-item active">Room</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="container-fluid py-3">
    <div class="row">
        <div class="col-md-12 d-flex">
            @if(havePermission('room.add'))
            <button id="toggleButton" class="btn btn-info mb-3 ml-1"><i class="fas fa-plus-circle me-2"></i>Add Room</button>
            @endif
        </div>
        @if ($errors->any())
        <div class="text-danger small">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    <div class="card togglediv overflow-auto" @if (!$errors->any()) style="display: none;" @endif>

        <div class="card-body">
            <div class="row">
                <form action="{{route('room.add')}}" method="POST">
                    @csrf

                    <div class="row">

                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Add Room <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="room_type" value="{{ old('room_type') }}" placeholder="Enter Room">
                            </div>
                        </div>
                        <!-- <div class="col-6">
                            <div class="form-group">
                                <label for="name">Room Fee <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="room_fees" id="validateno" value="{{ old('room_fees') }}" placeholder="Enter Room Fee">
                            </div>
                        </div> -->
                    </div>
                    <div class="col-md-12 d-flex justify-content-between align-items-center mt-2 w-100">
                        <div>
                            <input type="radio" class="btn-check" name="status" id="success-outlined" autocomplete="off" value="active" {{ old('status', 'active') == 'active' ? 'checked' : '' }}>
                            <label class="btn btn-outline-success btn-md" for="success-outlined">Active</label>

                            <input type="radio" class="btn-check" name="status" id="danger-outlined" autocomplete="off" value="inactive" {{ old('status') == 'inactive' ? 'checked' : '' }}>
                            <label class="btn btn-outline-danger btn-md" for="danger-outlined">Inactive</label>
                        </div>
                        <div>
                            <button class="btn btn-info btn-md mb-2" type="submit">Submit</button>
                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>

    <!-- table -->
    <div class="card">
        <div class="card-body">
            <table id="example1" class="table dataTable table-hover">
                <thead>
                    <tr class="">
                        <th>#</th>

                        <th>Room </th>
                        <!-- <th>Room Fee</th> -->
                        <th>Added Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($data as $row)
                    <tr class="">

                        <th>{{ $loop->iteration }}</th>

                        <td>{{ $row->room_type}}</td>
                        <!-- <td>{{ $row->room_fees }}</td> -->
                        <td>{{ $row->date }}</td>

                        <td>
                            <span class="badge {{ $row->status == '0' ? 'bg-success' : 'bg-danger' }}"> {{ $row->status == '0' ? 'Active' : 'Inactive' }}</span>
                        </td>
                        <td>
                            @if(havePermission('room.edit'))
                            <a href="{{ route('room.edit', $row->id) }}" class="text-info px-2"><i class="fas fa-edit"></i> </a>
                            @endif
                            @if(havePermission('room.destroy'))
                            <button class="btn btn-default text-danger btn-sm px-2 delete-room" data-id="{{ $row->id }}"><i class="fa-solid fa-trash"></i> </button>
                            @endif
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('.delete-room').click(function() {
        var id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('room.destroy') }}",
                    type: 'POST',
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function() {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    }
                });
            }
        });
    });
</script>


@endsection