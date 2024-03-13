<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use Livewire\Component;
use Livewire\WithPagination;

class ExpensesList extends Component
{
    use WithPagination;

    public $search = '';
    public $from = '';
    public $to = '';
    public $type = '';

    public $total = 0;

    public function mount()
    {
        $this->from = now()->format('Y-m-d');
    }

    public function render()
    {
        $expenses = Expense::query();

        if ($this->search) {
            $expenses->where('name', 'like', "%$this->search%");
        }

        if ($this->type) {
            $expenses->where('type', $this->type);
        }

        if ($this->from) {
            $expenses->whereDate('created_at', '>=', $this->from);
        }

        if ($this->to) {
            $expenses->whereDate('created_at', '<=', $this->to);
        }

        if ($this->search || $this->type || $this->from || $this->to) {
            $this->total = $expenses->sum('value');
        }

        return view(
            'expense.index',
            [
                'expenses' => $expenses->latest()->paginate(config('app.default_pagination')),
            ]
        )
            ->layout('layouts.app')->title(config('app.name') . ' | ' . 'المصروفات');
    }

    public function updated(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset();
        $this->resetPage();
    }
}
