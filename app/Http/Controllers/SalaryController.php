<?php

namespace App\Http\Controllers;

use App\Http\Requests\Salary\StoreSalaryRequest;
use App\Http\Requests\Salary\UpdateSalaryRequest;
use App\Models\Salary;
use App\Models\User;

class SalaryController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('salary.create',
            [
                'users' => User::whereNot('id', 1)->get(['id', 'name'])
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSalaryRequest $request)
    {
        try {
            Salary::create($request->validated());
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة اضافة المرتب', 'error');
            return to_route('salaries.index');
        }
        toast('تم إضافة المرتب بنجاح', 'success');
        return to_route('salaries.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Salary $salary)
    {
        return view('salary.show',
            [
                'salary' => $salary
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salary $salary)
    {
        return view('salary.edit',
            [
                'salary' => $salary,
                'users' => User::whereNot('id', 1)->get(['id', 'name'])
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalaryRequest $request, Salary $salary)
    {
        try {
            if ($salary->fill($request->validated())->isDirty()) {
                $salary->save();
            }
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة تعديل بيانات المرتب', 'error');
            return to_route('salaries.index');
        }
        toast('تم تعديل المرتب بنجاح', 'success');
        return to_route('salaries.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salary $salary)
    {
        try {
            $salary->delete();
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة حذف مرتب', 'error');
            return to_route('salaries.index');
        }
        toast('تم حذف مرتب بنجاح', 'success');
        return to_route('salaries.index');
    }
}
