<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Services\ResourceService;
use App\Services\EnumService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ResourceController extends Controller
{
    protected $resourceService;   
    protected $enumService;

    public function __construct(ResourceService $resourceService, EnumService $enumService)
    {
        $this->resourceService = $resourceService;
        $this->enumService = $enumService;
    }

    public function index()
    {
        $resources = $this->resourceService->getAllResourcesWithUserName();
        $columns = $this->resourceService->getResourceTableColumns();
        $pageTitle = 'Resources';
        $resourceSummary = $this->resourceService->getResourceSummary();
        $resourceTotal = $this->resourceService->getResourceTotalSummary();
        return view('resources', compact('resources', 'columns', 'pageTitle', 'resourceSummary', 'resourceTotal'));
    }

    public function create()
    {
        $types = $this->enumService->getEnumValues('resources', 'type');
        $pageTitle = 'Resources';
        $resourceSummary = $this->resourceService->getResourceSummary();
        return view('create-resource', compact('types', 'pageTitle', 'resourceSummary'));
    }

    public function store(Request $request)
    {
        $validData = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'type' => 'required|string',
            'status' => 'nullable|string',
            'assigned_department' => 'sometimes|string|max:255',
           
        ]);
        $validData['assigned_department'] = $validData['assigned_department'] ?? 'Warehouse';
        $validData['status'] = $validData['status'] ?? 'Available';
        
        $resource = new Resource($validData);
        $resource->user_id = Auth::id();
        $resource->save();

        return redirect()->route('resources.create')->with('success', 'Resource created successfully. You can enter the next resource.');
    }

    public function edit($id)
    {
        $resource = Resource::findOrFail($id);
        $types = $this->enumService->getEnumValues('resources', 'type');
        $statuses = $this->enumService->getEnumValues('resources', 'status');
        $pageTitle = 'Resources';
        return view('edit-resource', compact('resource', 'types', 'statuses', 'pageTitle'));
    }

    public function update(Request $request, Resource $resource)
{
    $validData = $request->validate([
        'name' => 'required|string|max:255',
        'quantity' => 'required|integer|min:0',
    ]);
    $data['name'] = $validData['name'];
    $data['quantity'] = $validData['quantity'];
    $data['type'] = $request->input('type');
    $data['status'] = $request->input('status');

    // mainot statusu mainas atrašanās vieta
    if ($data['status'] == 'Available') {
        $data['assigned_department'] = 'Warehouse';
    } elseif ($data['status'] == 'Maintenance') {
        $data['assigned_department'] = 'Warehouse maintenance center';
    } else {
        $data['assigned_department'] = $resource->assigned_department;
    }

    $resource->update($data);

    return redirect()->route('resources.index')->with('success', 'Resource updated successfully');
}

    public function destroy($id)
    {
        $resource = Resource::findOrFail($id);
        $resource->delete();
        return redirect()->route('resources.index')->with('success', 'Resource deleted successfully');
    }
}
