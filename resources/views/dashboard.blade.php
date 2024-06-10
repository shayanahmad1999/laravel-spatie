@extends('layout.app')
@section('title', 'Dashboard')
@section('content')
    <div class="container">
        <div class="card border-0 shadow my-5">
            <div class="card-header bg-light">
                <h3 class="h5 pt-2">Dashboard</h3>
            </div>
            <div class="card-body">
                <div class="mt-4">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">email</th>
                                <th scope="col">created at</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at }}</td>
                                </tr>
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
