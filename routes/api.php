<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

// Route::get('/contacts', function (Request $request) {
//     $query = Contact::query();

//     if ($request->has('search')) {
//         $query->where('name', 'like', '%' . $request->search . '%')
//               ->orWhere('email', 'like', '%' . $request->search . '%');
//     }

//     // Add pagination
//     $contacts = $query->paginate($request->get('perPage', 10));

//     return response()->json($contacts);
// });

Route::get('/contacts',[ContactController::class, 'apiIndex'])->name('contacts.api');