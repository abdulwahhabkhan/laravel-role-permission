@extends('layouts.app')
@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('elements.success')
                <div class="card">
                    <div class="card-header">
                        {{ __('Roles List') }}
                        <a class="float-right" href="{{ route('role.create') }}">Add Role</a>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 30%">Name</th>
                                    <th>Description</th>
                                    <th style="width: 100px">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->description }}</td>
                                <td><a href="{{ route('role.edit', $role->id) }}">Edit</a></td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
