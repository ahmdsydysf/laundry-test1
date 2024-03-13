<?php

namespace App\Livewire\Salary;

use App\Models\User;
use App\Models\Salary;
use Livewire\Component;
use Livewire\WithPagination;

class SalaryList extends Component
{
    use WithPagination;

    public $search = '';
    public $from = '';
    public $to = '';
    public $total = 0;
    public function render()
    {
        $salaries = Salary::query();

        if ($this->search) {
            $salaries->whereHas('user', function ($q) {
                $q->where('phone', 'like', "%{$this->search}%")
                    ->orWhere('name', 'like', "%{$this->search}%");
            });
        }

        if ($this->from) {
            $salaries->whereDate('created_at', '>=', $this->from);
        }

        if ($this->to) {
            $salaries->whereDate('created_at', '<=', $this->to);
        }

        $this->total = $salaries->sum('value');

        return view(
            'salary.index',
            [
                'salaries' => $salaries->with(['user'])->latest()->paginate(config('app.default_pagination')),
            ]
        )
            ->layout('layouts.app')->title(config('app.name') . ' | ' . 'المرتبات');
    }
    public function updated($attr, $value): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset();
        $this->resetPage();
    }
}
