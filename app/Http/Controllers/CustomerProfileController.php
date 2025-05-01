<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
  
class CustomerProfileController extends Controller
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
      return view('customerProfile.show', compact('user'));
  }

  public function edit()
  {
    $user = auth()->user(); 
    return view('customerProfile.edit', compact('user'));
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

    return redirect()->route('customerProfile.show')->with('success', 'Profile updated successfully!');
}

  public function showProfile()
  {
      $user = auth()->user(); 
      return view('customerProfile.show', compact('user'));
  }
 
}

?>