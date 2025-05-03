<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;

class TaskManager extends Component
{
    public $title, $description, $taskId;
    public $isEditing = false;

    public function render()
    {
        return view('livewire.task-manager', [
            'tasks' => Task::all(),
        ]);
    }

    public function save()
    {
        Task::create(['title' => $this->title, 'description' => $this->description]);
        $this->resetForm();
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $this->title = $task->title;
        $this->description = $task->description;
        $this->taskId = $task->id;
        $this->isEditing = true;
    }

    public function update()
    {
        $task = Task::findOrFail($this->taskId);
        $task->update(['title' => $this->title, 'description' => $this->description]);
        $this->resetForm();
    }

    public function delete($id)
    {
        Task::destroy($id);
    }

    public function resetForm()
    {
        $this->title = '';
        $this->description = '';
        $this->taskId = null;
        $this->isEditing = false;
    }
}



