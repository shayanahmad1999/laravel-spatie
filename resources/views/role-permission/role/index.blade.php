@extends('layout.app')
@section('title', 'Role')
@section('content')
    <div class="container">

        <div class="card border-0 shadow my-5">
            <div class="card-header bg-light">
                @if (Session::has('success'))
                    <span class="text-success">{{ Session::get('success') }}</span>
                @endif
                <h3 class="h5 pt-2">Create Role</h3>
            </div>
            <div class="card-body">
                <form action="{{ isset($edit) ? route('role.update', $edit->id) : route('role.store') }}" method="post">
                    @csrf
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                            <label for="name" class="col-form-label">Name</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" name="name" value="{{ isset($edit) ? $edit->name : '' }}"
                                id="name" class="form-control">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary">{{ isset($edit) ? 'Update' : 'Save' }}</button>
                        </div>
                    </div>
                </form>

                <div class="mt-4">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Role</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $role)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        {{-- we define role here as well and in web as well and in controller as well define it where you want --}}
                                        @role('delete role')
                                        <a href="{{ route('role.index', $role->id) }}">Edit</a> |
                                        @endrole
                                        @can('delete role')
                                        <form action="{{ route('role.destroy', $role->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-link p-0 m-0 align-baseline">Delete</button>
                                        </form>
                                        @endcan |
                                        <a href="javascript:;" data-bs-toggle="modal"
                                            data-bs-target="#assignPermission{{ $role->id }}">Assign Permission</a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="assignPermission{{ $role->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Assign Permission to
                                                    {{ $role->name }}</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('role.assign.permission', $role->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @foreach ($permissions as $permission)
                                                        <input type="checkbox" name="permissions[]"
                                                            value="{{ $permission->name }}" class="mb-3"
                                                            {{-- {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}  --}}
                                                            />
                                                        {{ $permission->name }}
                                                    @endforeach
                                                    @error('permissions')
                                                        <div>
                                                            <span class="text-danger">{{ $message }}</span>
                                                        </div>
                                                    @enderror
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Assign</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-danger">No Roles found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection
