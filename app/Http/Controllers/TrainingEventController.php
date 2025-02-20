<?php

namespace App\Http\Controllers;

use App\Models\TrainingEvent;
use App\Services\TrainingEventService;
use App\Services\EnumService;
use App\Services\SelectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingEventController extends Controller
{
    protected $resourceService;   
    protected $enumService;
    protected $selectionService;

    public function __construct(TrainingEventService $trainingeventService, EnumService $enumService, SelectionService $selectionService)
    {
        $this->resourceService = $trainingeventService;
        $this->enumService = $enumService;
        $this->selectionService = $selectionService;
    }

    public function index()
    {
        $resources = $this->resourceService->getAllTrainingEventsWithUserName();
        $columns = $this->resourceService->getTrainingEventTableColumns();
        $pageTitle = 'Training Event';
        return view('trainingevents', compact( 'columns', 'pageTitle'));
    }

    public function create()
    {
        
        $departments = $this->selectionService->getDepartments();
        $statuses = $this->enumService->getEnumValues('trainingevents', 'status');
        $pageTitle = 'Resources';
        
        return view('create-trainingevent', compact('departments','statuses', 'pageTitle'));
    }

    public function store(Request $request)
    {
        $validData = $request->validate([
            'name' => 'required|string|max:255',
            'responsible_department' => 'required|string',
            'status' => 'required|string',
            'start_date_time' => 'required|date|after_or_equal:today',
            'end_date_time' => 'required|date|after:start_date_time',

           
        ]);
        
        $trainingevent = new TrainingEvent($validData);
        $trainingevent->user_id = Auth::id();
        $trainingevent->save();

        return redirect()->route('trainingevents.index')->with('success', 'Resource created successfully.');
    }

    public function edit($id)
    {
        $trainingevent = TrainingEvent::findOrFail($id);
        $departments = $this->selectionService->getDepartments();
        $statuses = $this->enumService->getEnumValues('trainingevents', 'status');
        $pageTitle = 'Resources';
        return view('edit-trainingevent', compact('trainingevent',  'departments', 'statuses', 'pageTitle'));
    }

    public function update(Request $request,TrainingEvent $trainingevent)
    {
        $validDate = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $data['name'] = $validDate['name'];
        $data['quantity'] = $validDate['quantity'];
        $data['responsible_department'] = $request->input('responsible_department');
        $data['status'] = $request->input('status');
        $trainingevent->update($data);
        return redirect()->route('trainingevents.index')->with('success', 'Resource updated successfully');
    }

    public function destroy($id)
    {
        $trainingevent = TrainingEvent::findOrFail($id);
        $trainingevent->delete();
        return redirect()->route('trainingevents.index')->with('success', 'Resource deleted successfully');
    }
}
