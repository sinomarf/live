
<?php

use App\Models\Task;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;


new class extends Component {

    private $url = 'task';

    public $data;
    public $action;

    #[Validate('required')]
    public $title;

    public function store()
    {
        $this->validate();

        $status = Task::create($this->all());

        Utils::msg($status, 'store');
        $this->reset();

        return $this->redirect('/' . $this->url, navigate: true);
    }

    public function update()
    {
        $this->validate();

        $status = $this->data->fill($this->all())->save();
        Utils::msg($status, 'update');

        return $this->redirect('/' . $this->url, navigate: true);
    }

    private function loadData()
    {
        $this->title = $this->data->title;
    }

    public function mount(Task $task)
    {
        $this->action = 'store';
        if ($task->exists) {
            $this->data = $task;
            $this->loadData();
            $this->action = 'update';
        }
    }
};
?>

<div>

    <form wire:submit="{{ $this->action }}">
        <x-w.card title="{{ $this->title }}" enableHeader=true>
            <div class="row mb-2">
                <x-w.input label="Name" name="title" col="col-md-6" >
                </x-w.input>
            </div>
            <x-w.save url="{{  'task.index' }}">
            </x-w.save>
        </x-w.card>
    </form>

</div>
