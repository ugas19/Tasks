@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        @hasrole('admin')
            <div class="card card-new-task">
                <div class="card-header">New Task</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('tasks.update', $tasks->id) }}">
                    <input type="hidden" name="_method" value="PUT">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input id="title" value="{{$tasks->title}}" name="title" type="text" maxlength="255" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" autocomplete="off" />
                            @if ($errors->has('title'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
            @endhasrole
        </div>
    </div>
</div>
@endsection