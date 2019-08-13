@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Managse {{$user->name}}</div>

                <div class="card-body">
                <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">Description</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                            </tr>
                        </thead>
                       @foreach ($tasks as $task)
                           <tr>
                               <td>
                                   @if ($task->is_complete)
                                       <s>{{ $task->title }}</s>
                                   @else
                                       {{ $task->title }}
                                   @endif
                               </td>
                               <td class="text-middle">
                                    <a href="{{ route('edits.edit',$task->id) }}">
                                        <button type="button" class="btn btn-primary btn-sm">Edit</button>
                                    </a>
                               </td>
                               
                               <td class="text-middle">
                                    <form action="{{ route('edits.destroy', $task->id) }}" method="POST">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-sm">DELETE</button>
                                    </form>
                               </td>
                           </tr>
                       @endforeach
                   </table>
                   {{ $tasks->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection