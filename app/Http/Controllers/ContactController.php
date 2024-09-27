<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index() {
        return Inertia::render('Backend/Contacts');
    }

    public function apiIndex(Request $request) {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $query = Contact::query();
        // // Add sesrching by name, email and phone
        if ($startDate) {
            $query->where('created_at', '>=', Carbon::parse($startDate)->startOfDay());
        }

        if ($endDate) {
            $query->where('created_at', '<=', Carbon::parse($endDate)->endOfDay());
        }
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        // Add sorting
        if ($request->has('sortBy') && $request->has('sortDirection')) {
            $query->orderBy($request->sortBy, $request->sortDirection);
        }
        // $sqlQuery = $query->toSql();
        // \Log::info('Query:'. $sqlQuery);
        // Add pagination
        $contacts = $query->paginate($request->get('perPage', 25));
        
        return response()->json($contacts);
    }
}
