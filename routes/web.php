<?php



use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

    Volt::route('task', 'task.index')->name('task.index');
    Volt::route('task/{task}/edit', 'task.crud', 'update')->name('task.edit');
    Volt::route('task/create', 'task.crud', 'store')->name('task.create');
