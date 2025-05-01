<?php

namespace App\Http\Controllers;

use App\Models\AdminSelectionRequest;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSelectionController extends Controller
{
    // Customer submits request
    public function requestForm()
    {
        return view('customer.admin-selection-request');
    }

    // Customer stores request
    public function storeRequest(Request $request)
    {
        $request->validate([
            'requirements' => 'required|string|min:20|max:1000',
        ]);
    
        $selectionRequest = AdminSelectionRequest::create([
            'user_id' => Auth::id(),
            'requirements' => $request->requirements,
            'status' => 'pending'
        ]);
    
        // Notify admins
        $admins = User::where('type', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewSelectionRequest($selectionRequest));
        }
    
        return redirect()->route('customer.pusara.selection')
            ->with('success', 'Permohonan bantuan admin berjaya dihantar! Admin akan menghubungi anda.');
    }
    // Admin views all requests
    public function index()
    {
        $requests = AdminSelectionRequest::with(['user', 'package'])
            ->orderBy('status')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.selection-requests.index', compact('requests'));
    }

    // Admin views single request
    public function show($id)
    {
        $request = AdminSelectionRequest::with(['user', 'package'])->findOrFail($id);
        $packages = Package::where('status', 'tersedia')->get();
    
        // Mark notification as read
        auth()->user()->unreadNotifications()
            ->where('data->request_id', $id)
            ->update(['read_at' => now()]);
    
        return view('admin.selection-requests.show', compact('request', 'packages'));
    }
    // Admin selects package for customer
    public function selectPackage(Request $request, $id)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        $selectionRequest = AdminSelectionRequest::findOrFail($id);
        $selectionRequest->update([
            'selected_package_id' => $validated['package_id'],
            'admin_notes' => $validated['admin_notes'],
            'status' => 'completed'
        ]);

        // Here you would typically send a notification to the customer
        // For example via email or in-app notification

        return redirect()->route('admin.selection.requests')
            ->with('success', 'Pusara berjaya dipilih untuk pelanggan!');
    }
}