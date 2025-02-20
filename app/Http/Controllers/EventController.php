<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Resource;
use App\Models\EventResource;
use App\Services\EventService;
use App\Services\ResourceService;
use App\Services\EnumService;
use App\Services\UserService;
use Barryvdh\DomPDF\Facade\Pdf;

class EventController extends Controller
{
    protected $eventService;
    protected $resourceService;
    protected $enumService;
    protected $userService;

    public function __construct(EventService $eventService, ResourceService $resourceService, EnumService $enumService, UserService $userService)
    {
        $this->eventService = $eventService;
        $this->resourceService = $resourceService;
        $this->enumService = $enumService;
        $this->userService = $userService;
    }

    public function index()
    {
        // Iegūstam pašreizējo lietotāju
        $user = Auth::user();
    
        // Iegūstam lietotāja departamentu, izmantojot getUsersWithRoles funkciju
        $userWithRoles = $this->userService->getUsersWithRoles()->where('id', $user->id)->first();
        $userDepartment = $userWithRoles->department;
    
        // Iegūstam tikai tos pasākumus, kuru responsible_department sakrīt ar lietotāja departamentu
        $events = Event::with('resources')
            ->where('responsible_department', 'LIKE', '%' . $userDepartment . '%')
            ->get();
    
        $pageTitle = 'Events';
        return view('events', compact('events', 'pageTitle'));
    }
    
    public function create()
    {
        $enumStatus = $this->enumService->getEnumValues('events', 'status');
        $enumDep = $this->enumService->getEnumFiltrValues('department', 'name');
        $pageTitle = 'Create Event';
        return view('create-event', compact('pageTitle', 'enumDep', 'enumStatus'));
    }

    public function store(Request $request)
    {
        $validData = $request->validate([
            'name' => 'required|string|max:255',
            'responsible_department' => 'required|string|max:255',
            'start_date_time' => 'required|date|after_or_equal:now',
            'end_date_time' => 'required|date|after:start_date_time',
            'status' => 'required|in:Planned,In Progress,Completed'
        ]);

        $validData['user_id'] = Auth::id();

        $this->eventService->createEvent($validData);
        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $enumStatus = $this->enumService->getEnumValues('events', 'status');
        $enumDep = $this->enumService->getEnumFiltrValues('department', 'name');
        $pageTitle = 'Departments';
        $events = Event::all();
        return view('edit-event', compact('event', 'enumDep', 'enumStatus', 'pageTitle', 'events'));
    }
    

    public function update(Request $request, Event $event)
    {
        $data['name'] = $request->input('name');
        $data['responsible_department'] = $request->input('responsible_department');
        $data['start_date_time'] = $request->input('start_date_time');
        $data['end_date_time'] = $request->input('end_date_time');
        $data['status'] = $request->input('status');
    
        $event->update($data);
        return redirect()->route('events.index')->with('success', 'Event updated successfully');
    }
    
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully');
    }
    
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }
    
    public function print()
    {
        $events = Event::with('resources')->orderBy('start_date_time')->get()->groupBy('responsible_department');
        
        // Debug informācija
        if ($events->isEmpty()) {
            return response()->json(['message' => 'No events found.'], 404);
        }
    
        $pdf = Pdf::loadView('print', compact('events'));
        return $pdf->download('events.pdf');
    }
    
    
    
    // Resursu pievienošana pasākumam
    public function addResourceForm(Event $event)
    {
        $resources = Resource::all();
        $pageTitle = 'Add Resource for ' . $event->name . ' (Department: ' . $event->responsible_department . ')';
        $resourceSummary = $this->resourceService->getResourceSummary('Available');
        $enumResource = $this->enumService->getEnumIDValues('resources', 'name','status','Available');
        return view('add-resource', compact('event', 'resources', 'pageTitle', 'resourceSummary', 'enumResource'));
    }

    public function addResourceToEvent(Request $request, Event $event)
    {
        $request->validate([
            'resource_id' => ['required', 'integer', 'exists:resources,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            // Noņemiet 'assigned_department' no validācijas
        ]);
    
        // Iegūstam resursa nosaukumu un pieejamo statusu.
        $resource = Resource::findOrFail($request->resource_id);
        $resourceName = $resource->name;
    
        // Apkopojam visu resursu daudzumu ar vienādu nosaukumu un statusu "Available".
        $totalQuantity = Resource::where('name', $resourceName)
            ->where('status', 'Available')
            ->sum('quantity');
    
        if ($totalQuantity < $request->quantity) {
            return redirect()->back()->with('error', 'Not enough available resources in the warehouse.');
        }
    
        // Izmantoto daudzumu.
        $remainingQuantity = $request->quantity;
    
        // Atjauninām resursu ierakstus ar vienādu nosaukumu un statusu "Available".
        $resources = Resource::where('name', $resourceName)
            ->where('status', 'Available')
            ->get();
    
        foreach ($resources as $resource) {
            if ($resource->quantity >= $remainingQuantity) {
                $resource->quantity -= $remainingQuantity;
                $resource->save();
                $remainingQuantity = 0;
            } else {
                $remainingQuantity -= $resource->quantity;
                $resource->quantity = 0;
                $resource->save();
            }
            // Ja resursu daudzums kļūst par nulli, izdzēšam šo ierakstu.
            if ($resource->quantity == 0) {
                $resource->delete();
            }
        }
    
        // Izveidojam jaunu ierakstu ar statusu "In Use".
        $inUseResource = Resource::create([
            'name' => $resourceName,
            'type' => $resource->type,
            'quantity' => $request->quantity,
            'status' => 'In Use',
            'assigned_department' => $event->responsible_department,
            'user_id' => $resource->user_id,
        ]);
    
        // Izveidojam ierakstu pasākuma resursu tabulā.
        $eventResource = new EventResource();
        $eventResource->event_id = $event->id;
        $eventResource->resource_id = $inUseResource->id;
        $eventResource->quantity = $request->quantity;
        $eventResource->save();
    
        return redirect()->back()->with('success', 'Resources added to event successfully. You can now add another resource.');
    }
    

    // Resursu noņemšana no pasākuma
    public function returnResources(Request $request, $id)
    {
        $event = Event::find($id);
        foreach ($event->resources as $resource) {
            if ($resource->type === 'Ammo') {
                // Iegūstiet atgriezto daudzumu no pieprasījuma
                $remainingQuantity = $request->input("remaining_quantity_{$resource->id}");
    
                // Pārbaudiet, vai remainingQuantity ir skaitlis un ir lielāks vai vienāds ar 0
                if (is_numeric($remainingQuantity) && $remainingQuantity >= 0) {
                    // Atjauniniet resursa daudzumu, aizstājot to ar remaining_quantity vērtību
                    $resource->quantity = $remainingQuantity;
                }
            }
    
            // Atjaunojiet statusu un departamentu
            $resource->status = 'Maintenance';
            $resource->assigned_department = 'Warehouse maintenance center (from ' . $event->responsible_department . ')';
            $resource->save();
    
            // Noņemiet saistību starp pasākumu un resursiem
            $event->resources()->detach($resource->id);
        }
    
        return redirect()->route('events.index')->with('success', 'Resources returned to warehouse and status updated.');
    }
    
}
