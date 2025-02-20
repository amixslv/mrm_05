<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DepartmentService;
use App\Models\Department;
use App\Services\EnumService;
use App\Services\SelectionService;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    protected $departmentService;
    protected $enumService;
    protected $selectionService;

    public function __construct(DepartmentService $departmentService, EnumService $enumService, SelectionService $selectionService)
    {
        $this->departmentService = $departmentService;
        $this->enumService = $enumService;
        $this->selectionService = $selectionService;
    }

    public function index()
    {
        $departments = $this->departmentService->getAlldepartmentsWithUserName();
        $columns = $this->departmentService->getDepartmentTableColumns();
        $pageTitle = 'Departments';
        
        return view('departments', compact( 'departments', 'columns', 'pageTitle'));
    }

    public function create()
    {
        $departments = $this->selectionService->getDepDep();
        $pageTitle = 'Create Department';
        return view('create-department', compact('departments', 'pageTitle'));
    }

    public function store(Request $request)
{
    $validData = $request->validate([
        'name' => 'required', 'string', 'max:255',
        'description' => 'required', 'string', 'max:255',
    ]);
   
    $department = new Department($validData);
    $department->user_id = Auth::id();
    $department->save();
    return redirect()->route('departments.create')->with('success', 'Department created successfully. You can enter the next department.');
}


    public function edit($id)
    {
        $department = Department::findOrFail($id);
        $pageTitle = 'Departments';
        return view('Users.edit-department', compact('department','pageTitle'));
    }

    public function update(Request $request, Department $department)
    {
        $data['name'] = $request->input('name');

        $department->update($data);
        return redirect()->route('departments.index')->with('success', 'Department updated successfully');
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully');
    }
}
