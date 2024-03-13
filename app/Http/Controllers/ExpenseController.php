<?php

namespace App\Http\Controllers;

use App\Http\Requests\Expense\ExpenseStoreRequest;
use App\Http\Requests\Expense\ExpenseUpdateRequest;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ExpenseController extends Controller
{
    /**
     * Show create form
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create()
    {
        return view(
            'expense.create',
            [
                'users' => User::whereNot('id', 1)->get(['id', 'name'])
            ]
        );
    }

    /**
     * Handle store request
     *
     * @param ExpenseStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ExpenseStoreRequest $request)
    {
        try {
            Expense::create($request->validated());
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة اضافة المصروف', 'error');
            return to_route('expenses.index');
        }
        toast('تم إضافة المصروف بنجاح', 'success');
        return to_route('expenses.index');
    }

    /**
     * Show expense information
     *
     * @param Expense $expense
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function show(Expense $expense)
    {
        return view(
            'expense.show',
            [
                'expense' => $expense
            ]
        );
    }

    /**
     * Show edit form
     *
     * @param Expense $expense
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(Expense $expense)
    {
        return view(
            'expense.edit',
            [
                'expense' => $expense,
                'users' => User::whereNot('id', 1)->get(['id', 'name'])
            ]
        );
    }

    /**
     * Handle update request
     *
     * @param ExpenseUpdateRequest $request
     * @param Expense $expense
     * @return RedirectResponse
     */
    public function update(ExpenseUpdateRequest $request, Expense $expense)
    {
        try {
            if ($expense->fill($request->validated())->isDirty()) {
                $expense->save();
            }
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة تعديل بيانات المصروف', 'error');
            return to_route('expenses.index');
        }
        toast('تم تعديل المصروف بنجاح', 'success');
        return to_route('expenses.index');
    }

    /**
     * Handle delete request
     *
     * @param Expense $expense
     * @return RedirectResponse
     */
    public function destroy(Expense $expense)
    {
        try {
            $expense->delete();
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة حذف مصروف', 'error');
            return to_route('expenses.index');
        }
        toast('تم حذف مصروف بنجاح', 'success');
        return to_route('expenses.index');
    }
}
