<?php
  
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
  
class AdminProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('profile');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
  

  public function show()
  {
      $user = auth()->user(); 
      return view('adminProfile.show', compact('user'));
  }

  public function edit()
  {
    $user = auth()->user(); 
    return view('adminProfile.edit', compact('user'));
  }

  public function update(Request $request)
{
    // Validate the incoming data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:15',
        'address' => 'nullable|string|max:255',
        'postcode' => 'required|numeric|min:10000|max:99999',
        'city' => 'nullable|string|max:100',
        'identification_card' => 'nullable|string|max:255',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    $user = Auth::user();

    // Update the user's other details
    $user->name = $validatedData['name'];
    $user->phone = $validatedData['phone'];
    $user->address = $validatedData['address'];
    $user->city = $validatedData['city'];
    $user->postcode = $validatedData['postcode'];
    $user->identification_card = $validatedData['identification_card'];

    // Update password only if a new one is provided
    if ($request->filled('password')) {
        $user->password = Hash::make($validatedData['password']);
    }

    $user->save();

    return redirect()->route('adminProfile.show')->with('success', 'Profile updated successfully!');
}


// show all user   

  public function showProfile()
  {
      $user = auth()->user(); 
      return view('adminProfile.show', compact('user'));
  }

  // AdminProfileController.php
  public function listUsers()
  {
      $users = User::all();  // Fetch the users, adjust based on your logic
      return view('adminProfile.users.index', compact('users'));  // Pass users to the view
  }

  public function deleteUser(User $user)
  {
      // Delete the user
      $user->delete();

      // Redirect back with a success message
      return redirect()->route('adminProfile.users')->with('success', 'User deleted successfully!');
  }

  public function create()
    {
        return view('adminProfile.create'); // Return a view for creating an admin
    }

    // Method to handle storing the new admin
   // app/Http/Controllers/AdminProfileController.php

   public function store(Request $request)
    {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
        'address' => 'required|string|max:255', // Validate address
        'phone' => 'required|string|max:15',     // Validate phone number
        'city' => 'required|string|max:100',     // Validate city
        'postcode' => 'required|numeric|min:10000|max:99999', // Validate postcode
        'company' => 'nullable|string|max:255',  // Validate company (optional)
        'identification_card' => 'nullable|string|max:255', // Validate identification card (optional)
    ]);

    // Create user

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'type' => 1,
        'address' => $request->address,
        'phone' => $request->phone,
        'city' => $request->city,
        'postcode' => $request->postcode,
        'company' => $request->company,
        'identification_card' => $request->identification_card,
    ]);

    return redirect()->route('adminProfile.users')->with('success', 'Admin created successfully!');
    }

    // edit user for admin

    public function editUser($id)
    {
        $user = User::findOrFail($id); // Find the user by ID or fail if not found
        return view('adminProfile.users.editUser', compact('user')); // Return the view with user data
    }

    public function updateUser(Request $request, $id)
    {
        // Validate the input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'postcode' => 'nullable|numeric|min:10000|max:99999',
            'city' => 'nullable|string|max:100',
            'identification_card' => 'nullable|string|max:255',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Update the user's details
        $user->update($validatedData);

        return redirect()->route('adminProfile.users.index')->with('success', 'User updated successfully!');
    }
}
