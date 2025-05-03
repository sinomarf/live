<?php
use App\Models\Task;
use Livewire\Volt\Component;
use Livewire\Attributes\Computed;

new class extends Component {
    private $url = 'Task';

    #[Computed]
    public function data()
    {
        return Task::orderBy('title')->get();
    }
};
?>

<div>
    <x-w.card title="Units" enableFooter="false">
        <div class="table-responsive-lg">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                      
                        <th scope="col">Tile</th>
                        <th scope="col" width="17%">
                            <x-w.btnNav label="New" icon="plus-square" color="success"
                            router="{{ route('task.create') }}">
                        </x-w.btnNav>
                        </th>
                    </tr>
                </thead>
               <tbody class="table-group-divider">
                    @foreach ($this->data as $obj)
                        <tr wire:key="{{ $obj->id }}">
                            <th scope="row"> {{ $obj->title }} </th>
                        
                            <td> 
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-w.card>
</div>