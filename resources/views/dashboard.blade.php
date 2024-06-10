@extends('layout.app')
@section('title', 'Dashboard')
@section('content')
    <div class="container">
        <div class="card border-0 shadow my-5">
            <div class="card-header bg-light">
                @if (Session::has('success'))
                    <span class="text-success">{{ Session::get('success') }}</span>
                @endif
                <h3 class="h5 pt-2">Dashboard</h3>
            </div>
            <div class="card-body">
                <div class="mt-4">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if (!empty($user->getRoleNames()))
                                            @foreach ($user->getRoleNames() as $rolename)
                                                <span class="badge bg-primary mx-1">{{ $rolename }}</span>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        <a href="javascript:;" data-bs-toggle="modal"
                                            data-bs-target="#assignRole{{ $user->id }}">Assign Role</a>
                                    </td>
                                </tr>
                                @php
                                    $userRoles = DB::table('model_has_roles')
                                        ->where('model_has_roles.model_id', $user->id)
                                        ->pluck('model_has_roles.role_id')
                                        ->toArray();
                                @endphp
                                <div class="modal fade" id="assignRole{{ $user->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Assign Roles to
                                                    {{ $user->name }}</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('user.assign.role', $user->id) }}" method="post">
                                                    @csrf
                                                    @foreach ($roles as $role)
                                                        <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                                            class="mb-3"
                                                            {{ in_array($role->id, $userRoles) ? 'checked' : '' }}
                                                            />
                                                        {{ $role->name }}
                                                    @endforeach
                                                    @error('roles')
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
                                    <td colspan="3" class="text-danger">No Users found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
