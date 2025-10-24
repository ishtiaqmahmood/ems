<?php

namespace App\Http\Controllers\Salary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class SalaryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Admin and HR can see all salaries
        if (in_array($user->role, ['Admin', 'HR'])) {
            $salaries = Salary::with('user')->latest()->paginate(10);
        } else {
            // Normal user sees only their own salaries
            $salaries = Salary::where('user_id', $user->id)->paginate(10);
        }

        return view('salaries.index', compact('salaries'));
    }

    public function create()
    {
        $this->authorizeRole(['Admin', 'HR']);
        $users = User::all();
        return view('salaries.create', compact('users'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole(['Admin', 'HR']);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'payment_date' => 'required|date',
            'payment_method' => 'nullable|string|max:50',
            'status' => 'required|in:paid,pending,failed',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date',
        ]);

        Salary::create($request->all());
        return redirect()->route('salaries.index')->with('success', 'Salary added successfully.');
    }

    public function edit(Salary $salary)
    {
        $this->authorizeRole(['Admin', 'HR']);
        $users = User::all();
        return view('salaries.edit', compact('salary', 'users'));
    }

    public function update(Request $request, Salary $salary)
    {
        $this->authorizeRole(['Admin', 'HR']);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'payment_date' => 'required|date',
            'payment_method' => 'nullable|string|max:50',
            'status' => 'required|in:paid,pending,failed',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date',
        ]);

        $salary->update($request->all());
        return redirect()->route('salaries.index')->with('success', 'Salary updated successfully.');
    }

    public function destroy(Salary $salary)
    {
        $this->authorizeRole(['Admin', 'HR']);
        $salary->delete();
        return redirect()->route('salaries.index')->with('success', 'Salary deleted successfully.');
    }

    private function authorizeRole(array $roles)
    {
        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'Unauthorized access.');
        }
    }
}