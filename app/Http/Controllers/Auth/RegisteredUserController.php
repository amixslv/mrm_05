<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Services\EnumService;

class RegisteredUserController extends Controller
{
    protected $enumService;

    public function __construct(EnumService $enumService)
    {
        $this->enumService = $enumService;
    }
    /**
     * Display the registration view.
     */
    public function create()
    {
        $enumCountry = $this->enumService->getEnumValues('users', 'country');
        $enumStructure = $this->enumService->getEnumValues('users', 'structure');
        $enumSubStructure = $this->enumService->getEnumValues('users', 'sub_structure');

        return view('auth.register', compact('enumCountry', 'enumStructure', 'enumSubStructure'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'country' => ['required', 'string'],
            'structure' => ['required', 'string'],
            'sub_structure' => ['required', 'string'],
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'active' => false,
            'country' => $request->country,
            'structure' => $request->structure,
            'sub_structure' => $request->sub_structure,
            'role_id' => null, 
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
    

    
}

