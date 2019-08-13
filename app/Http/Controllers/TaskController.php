<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Paginate the authenticated user's tasks.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // paginate the authorized user's tasks with 5 per page
        $tasks = Auth::user()
            ->tasks()
            ->orderBy('is_complete')
            ->orderByDesc('created_at')
            ->paginate(5);

        // return task index view with paginated tasks
        return view('tasks', [
            'tasks' => $tasks
        ]);
    }

    /**
     * Store a new incomplete task for the authenticated user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if(Auth::user()){
            if(Auth::user()->hasAnyRole('admin')){
                // validate the given request
                $data = $this->validate($request, [
                    'title' => 'required|string|max:255',
                ]);
                $myCheckboxes = $request->my_checkbox;
                foreach($myCheckboxes as $myCheckboxe){
                    // create a new incomplete task with the given title
                    User::find($myCheckboxe)->tasks()->create([
                        'title' => $data['title'],
                        'is_complete' => false,
                    ]);
                   }
                return(redirect('/admin/tasks'));
            }

        }

        // validate the given request
        $data = $this->validate($request, [
            'title' => 'required|string|max:255',
        ]);

        // create a new incomplete task with the given title
        Auth::user()->tasks()->create([
            'title' => $data['title'],
            'is_complete' => false,
        ]);

        // flash a success message to the session
        session()->flash('status', 'Task Created!');

        // redirect to tasks index
        return redirect('/tasks');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.tasks.edits')->with(['tasks' => Task::find($id)]);
    }
    /**
     * Mark the given task as complete and redirect to tasks index.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request,Task $task)
    {
        $current_user = $task->user_id;
        if(Auth::user()){
            if(Auth::user()->hasAnyRole('admin')){
                $requests = $this->validate($request, [
                    'title' => 'required|string|max:255',
                ]);
                $task->title = $request->title;
                $task->save();
                return redirect('/admin/users/'.$current_user.'/edit');
            }
        }
        

        // check if the authenticated user can complete the task
        $this->authorize('complete', $task);

        // mark the task as complete and save it
        $task->is_complete = true;
        $task->save();

        // flash a success message to the session
        session()->flash('status', 'Task Completed!');

        // redirect to tasks index
        return redirect('/tasks');
    }


        /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $task_id)
    {  
        $user_id = Task::find($task_id)->user_id;
        Task::destroy($task_id);
        
        return redirect('/admin/users/'.$user_id.'/edit');
    }
}
