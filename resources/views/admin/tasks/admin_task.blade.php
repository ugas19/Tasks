@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <form method="POST" action="{{ route('tasks.store') }}">
                        @csrf
            <div class="card card-new-task">
                <div class="card-header">New Task</div>

                <div class="card-body">
                    
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input id="title" name="title" type="text" maxlength="255" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" autocomplete="off" />
                            @if ($errors->has('title'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                         
                        <button type="submit" class="btn btn-primary">Create</button>
                    
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">Manage Users</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Edit Tasks</th>
                            <th scope="col">Check</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <th>{{ $user->name}}</th>
                                <th>{{ $user->email}}</th>
                                <th>
                                    <a href="{{ route('admin.users.edit',$user->id) }}">
                                        <button type="button" class="btn btn-primary btn-sm">Edit</button>
                                    </a>
                                </th>
                                <th>
                                <input type="checkbox" name="my_checkbox[]" value="{{$user->id}}"> 
                                
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                    
                    </table>
                </div>
            </div>
            </form>
            
        </div>
    </div>
</div>
@endsection