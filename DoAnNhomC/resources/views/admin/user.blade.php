@extends('admin.navbar')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var successAlert = document.querySelector('.alert-danger');

        if (successAlert) {
            
            setTimeout(function () {
                successAlert.style.display = 'none'; 
            }, 3000); 
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var successAlert = document.querySelector('.alert-success');

        if (successAlert) {
            
            setTimeout(function () {
                successAlert.style.display = 'none'; 
            }, 3000); 
        }
    });
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Users</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.adduser') }}" class="btn btn-primary">New User</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <!-- Trong file Blade -->
                    <form action="{{ route('admin.searchuser') }}" method="GET" class="input-group"
                        style="width: 250px;">
                        <input type="text" name="search" class="form-control float-right" placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
            
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th width="60">ID</th>
                            <th>Avatar</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th width="100">Status</th>
                            <th width="100">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if ($users->isEmpty())
            <p>Không có kết quả</p>
            @else
                        @foreach($users as $user)
                        
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                            <img src="{{ asset('user-image/images/' . $user->img) }}" alt="Avatar" class="rounded-circle avatar">
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->gender }}</td>
                            <td>
                                @if($user->status == '1')
                                <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                @else
                                <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.updateUser', ['id' => $user->id] )}}">
                                    <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                        </path>
                                    </svg>
                                </a>
                                <a href="#" class="text-danger w-4 h-4 mr-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{$user->id}}">
                                    <svg wire:loading.remove.delay="" wire:target=""
                                        class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="deleteModal{{$user->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$user->id}}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{$user->id}}">Xác nhận xóa</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn có chắc chắn muốn xóa người dùng này không?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <form action="{{ route('admin.deleteuser', ['id' => $user->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Xóa</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal -->
                        @endforeach
                        @endif
                    </tbody>
                </table>
                
            </div>
            <div class="card-footer clearfix">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
