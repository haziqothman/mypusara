<?php

use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\MCDMController;
use App\Http\Controllers\AdminSelectionController;
use App\Http\Controllers\MapController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
});

Auth::routes();

/*------------------------------------------
--------------------------------------------
All Customer Routes List
--------------------------------------------
--------------------------------------------*/

Route::middleware(['auth', 'user-access:customer'])->group(function () {
    Route::group(['prefix' => 'customer/'], function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        /**
         * Manage Catalogue
         */
        Route::get('/package/list', [CatalogueController::class, 'displayPackage'])->name('customer.display.package');
        Route::get('/search-pusara', [CatalogueController::class, 'searchPusara'])->name('search.pusara');

        /**
         * Manage Booking
         */
        Route::get('/customer/dashboard', [BookingController::class, 'show'])->name('ManageBooking.Customer.dashboardBooking');
        Route::get('/booking/{id}/create', [BookingController::class, 'create'])->name('ManageBooking.Customer.createBooking');  
        Route::get('/booking/{id}/store', [BookingController::class, 'store'])->name('ManageBooking.Customer.storeBooking');    
        Route::post('/customer/{id}/store-booking', [BookingController::class, 'store'])->name('customer.store.booking');
        Route::get('/customer/booking/{id}/edit', [BookingController::class, 'edit'])->name('ManageBooking.Customer.editBooking');
        Route::put('/customer/booking/{id}', [BookingController::class, 'update'])->name('customer.update.booking');
        Route::get('/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('customer.cancel.booking');
        Route::get('/booking/{id}/create', [BookingController::class, 'create'])->name('customer.create.booking');
        // Route::get('/booking/{id}/create', [BookingController::class, 'create'])->name('customer.booking.create');
        Route::get('/booking/{id}/view', [BookingController::class, 'view'])->name('ManageBooking.Customer.viewBooking');
        
         
        /**
         * Manage Customer Profile
         */
        Route::get('/customerProfile', [CustomerProfileController::class, 'show'])->name('customerProfile.show');
        Route::get('/customerProfile/edit', [CustomerProfileController::class, 'edit'])->name('customerProfile.edit');
        Route::post('/customerProfile/update', [CustomerProfileController::class, 'update'])->name('customerProfile.update');

        /**
         * Manage feedback
         */
        Route::get('/feedback', [FeedbackController::class, 'index'])->name('customer.feedback');
        Route::get('/feedback/create', [FeedbackController::class, 'create'])->name('customer.feedback.create');
        Route::get('feedback/show', [FeedbackController::class, 'show'])->name('customer.feedback.show');
   
        //  admin-selection
        // Customer routes
        Route::get('/customer/request-admin-selection', [AdminSelectionController::class, 'requestForm'])
        ->name('admin.select.package.request');
        Route::post('/customer/store-admin-selection', [AdminSelectionController::class, 'storeRequest'])
        ->name('admin.select.package.store');
        
        Route::get('/grave/{id}', function ($id) {
            $grave = \App\Models\Package::findOrFail($id);
            return response()->json($grave);
        });
    });
});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::group(['prefix' => 'admin/'], function () {
        Route::get('/home', [HomeController::class, 'adminHome'])->name('admin.home');

        // search Pusara

        Route::get('/search-pusara', [CatalogueController::class, 'searchPusara'])->name('search.pusara');
        /**
     * Manage Catalogue
     */
        Route::get('/manage/package', [CatalogueController::class, 'displayManagePackage'])->name('admin.display.package');
        Route::get('/add/package', [CatalogueController::class, 'createPackage'])->name('admin.create.package');
        Route::post('/store/package', [CatalogueController::class, 'storePackage'])->name('admin.store.package');
        Route::get('/package/{id}/edit', [CatalogueController::class, 'editPackage'])->name('admin.edit.package');
        Route::post('/update/{id}/package', [CatalogueController::class, 'updatePackage'])->name('admin.update.package');
        Route::put('/update/{id}/package', [CatalogueController::class, 'updatePackage'])->name('admin.update.package');
        Route::delete('/package/{id}', [CatalogueController::class, 'destroyPackage'])->name('admin.package.destroy');
        Route::get('/package/map', [CatalogueController::class, 'showMap'])->name('package.map');

        // Manage Booking
        Route::get('/admin/dashboard', [BookingController::class, 'showAdmin'])->name('ManageBooking.Admin.dashboardBooking');
        Route::get('/bookings', [BookingController::class, 'indexAdmin'])->name('admin.bookings.index'); // View all bookings
        Route::get('/bookings/{id}', [BookingController::class, 'viewAdmin'])->name('admin.bookings.view'); // View booking details
        Route::get('/bookings/{id}/edit', [BookingController::class, 'editAdmin'])->name('admin.bookings.edit'); // Edit booking
        Route::get('/booking/{id}/edit', [BookingController::class, 'editAdmin'])->name('ManageBooking.Admin.editBooking');
        Route::get('/booking/{id}/view', [BookingController::class, 'viewAdmin'])->name('ManageBooking.Admin.view');
        Route::put('/bookings/{id}', [BookingController::class, 'updateAdmin'])->name('admin.bookings.update'); // Update booking
        Route::post('/bookings/{id}/approve', [BookingController::class, 'approveBooking'])->name('admin.bookings.approve'); // Approve booking
        Route::get('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('admin.bookings.cancel'); // Cancel booking
        Route::get('/admin/booking/{id}/edit', [BookingController::class, 'editAdmin'])->name('ManageBooking.Admin.editBooking');
        Route::put('/admin/booking/{id}', [BookingController::class, 'updateAdmin'])->name('admin.update.booking');
        Route::put('/admin/booking/{id}', [BookingController::class, 'destroyAdmin'])->name('admin.bookings.destroy');
        Route::get('/admin/booking/{id}/view', [BookingController::class, 'viewAdmin'])->name('ManageBooking.Admin.viewBooking');
        Route::delete('/admin/bookings/{booking}', [BookingController::class, 'destroy'])
        ->name('admin.bookings.destroy');
        /**
         * Manage Admin Profile
         */
        Route::get('/adminProfile', [AdminProfileController::class, 'show'])->name('adminProfile.show');
        Route::get('/adminProfile/edit', [AdminProfileController::class, 'edit'])->name('adminProfile.edit');
        Route::post('/adminProfile/update', [AdminProfileController::class, 'update'])->name('adminProfile.update');

        // List Users
        Route::get('/users', [AdminProfileController::class, 'listUsers'])->name('adminProfile.users.index');
        Route::get('/admin/profile/users', [AdminProfileController::class, 'listUsers'])->name('adminProfile.users.index');
        Route::get('/users', [AdminProfileController::class, 'listUsers'])->name('adminProfile.users');
        Route::delete('/admin/users/{user}', [AdminProfileController::class, 'deleteUser'])->name('adminProfile.delete');
        Route::post('/admin/store', [AdminProfileController::class, 'store'])->name('adminProfile.store');
        Route::get('/admin/create', [AdminProfileController::class, 'create'])->name('adminProfile.create');
        Route::get('/admin/users/{id}/edit', [AdminProfileController::class, 'editUser'])->name('adminProfile.users.editUser');
        Route::put('/admin/users/{id}', [AdminProfileController::class, 'updateUser'])->name('adminProfile.updateUser');

        Route::get('/mcdm/recommend', [MCDMController::class, 'showCriteriaForm'])->name('mcdm.form');
        Route::post('/mcdm/process', [MCDMController::class, 'processSelection'])->name('mcdm.process');

        // Admin Selection Requests
        // Admin routes
       
            Route::get('/admin/selection-requests', [AdminSelectionController::class, 'index'])
                ->name('admin.selection.requests');
            Route::get('/admin/selection-requests/{id}', [AdminSelectionController::class, 'show'])
                ->name('admin.selection.request.show');
            Route::post('/admin/selection-requests/{id}/select-package', [AdminSelectionController::class, 'selectPackage'])
                ->name('admin.selection.select.package');

            Route::get('/admin/notifications', function() {
                return view('admin.notifications');
            })->name('admin.notifications');
            
            Route::post('/admin/notifications/mark-all-read', function() {
                Auth::user()->unreadNotifications->markAsRead();
                return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca');
            })->name('admin.notifications.markAllRead');
            });

            // Generate Excel Reports

            Route::post('/admin/generate-report', [HomeController::class, 'generateReport'])
    ->name('admin.generate.report');
});

  // Anonymous Dashboard Route
  Route::get('/', function () {
    return view('public.landing');
})->name('landing');


Route::post('/admin/bookings/{id}/notify-grave-digger', [BookingController::class, 'notifyGraveDigger'])
    ->name('admin.bookings.notify_grave_digger')
    ->middleware(['auth', 'user-access:admin']);
    Route::get('/test-twilio-config', function() {
        return [
            'sid' => config('services.twilio.sid'),
            'token' => config('services.twilio.token'),
            'whatsapp_number' => config('services.twilio.whatsapp_number')
        ];
    });
// For home pages
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');

// For showing single booking
Route::get('/bookings/{id}', [HomeController::class, 'show'])->name('bookings.show');


Route::get('/search/bookings', [PublicController::class, 'searchBookings'])->name('search.bookings');

// Temporary debug route - Add this to routes/web.php
Route::get('/debug-muhammad-ali', function() {
    $results = \App\Models\Package::whereHas('bookings', function($query) {
        $query->where('nama_simati', 'like', '%Muhammad Ali%')
              ->where('status', 'confirmed');
    })->with('bookings')->get();

    dd($results); // Check if records exist
});

     // MCDM Routes
Route::middleware(['auth', 'user-access:customer'])->group(function () {
    Route::get('/mcdm/recommend', [MCDMController::class, 'showCriteriaForm'])->name('mcdm.form');
    Route::post('/mcdm/process', [MCDMController::class, 'processSelection'])->name('mcdm.process');
});

Route::get('/customer/pusara', function() {
    return view('customer.pusara-selection');
})->name('customer.pusara.selection')->middleware(['auth', 'user-access:customer']);

 Route::get('/map', [MapController::class, 'index']);

Route::get('/verify-packages', function() {
    $problemPackages = Package::where('status', 'tersedia')
        ->whereHas('bookings', function($q) {
            $q->whereNotIn('status', ['cancelled', 'rejected']);
        })
        ->with(['bookings' => function($q) {
            $q->whereNotIn('status', ['cancelled', 'rejected']);
        }])
        ->get();

    return response()->json([
        'booked_but_marked_available' => $problemPackages->map(function($pkg) {
            return [
                'id' => $pkg->id,
                'pusaraNo' => $pkg->pusaraNo,
                'active_bookings' => $pkg->bookings->map(function($booking) {
                    return [
                        'id' => $booking->id,
                        'status' => $booking->status,
                        'customer' => $booking->customerName
                    ];
                })
            ];
        })
    ]);
});