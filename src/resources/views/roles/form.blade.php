@extends('layouts.app')
@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('elements.errors')
                <div class="card">
                    <div class="card-header">
                        {{ $heading }}
                        <a href="{{ route('role.index') }}" class="float-right">Cancel</a>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ $action }}" id="role-form">
                            @csrf
                            <input type="hidden" name="_method" value="{{ $method }}">
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                        <input class="form-control" id="name"
                                               name="name"
                                               value="{{ old('name', $role->name) }}"
                                               aria-describedby="rolename" placeholder="role name">
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <label for="description">Description:</label>
                                        <input class="form-control" id="description" name="description"
                                               value="{{ old('description', $role->description) }}"
                                                  placeholder="role description"></input>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    @foreach($urls as $key=>$section)
                                    <div class="cpanel">
                                        <div class="panel-heading cbuilt">
                                            <div class="panel-tools">
                                                <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                                            </div>
                                            {{ $key }}
                                        </div>
                                        <div class="panel-body">
                                            @foreach($section as $skey => $module)
                                            <div class="permission-module">
                                                {{ $skey }}
                                            </div>
                                            <ul class="permission">
                                                @foreach($module as $mkey => $res)
                                                <li>
                                                    <div class="form-check">
                                                        <input class="form-check-input"
                                                               name="permissions[]"
                                                               type="checkbox"
                                                               @if(in_array($res->id, $role_permissions)) checked @endif
                                                               value="{{ $res->id }}"
                                                               id="{{ $res->id }}">
                                                        <label class="form-check-label" for="{{ $res->id }}">
                                                            {{ $res->name }}
                                                        </label>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="col-sm-12">

                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-muted text-center">
                        <button type="submit" form="role-form" class="btn btn-primary float-right">Submit</button>
                        <a href="{{ route('role.index') }}" class="btn btn-secondary float-left">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
