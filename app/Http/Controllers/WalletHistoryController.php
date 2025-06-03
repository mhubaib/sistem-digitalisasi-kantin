<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\User;
use App\Models\WalletHistory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class WalletHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fetch all users who are santris for the filter dropdown, ordered by name.
        // Assuming 'santris' table has a 'user_id' that links to 'users' table where the name is stored.
        $santris = User::whereHas('santri')->orderBy('name')->get();

        $query = WalletHistory::with(['santri.user', 'createdBy']); // Eager load santri.user relationship

        // Apply filters
        if ($request->filled('santri_id')) {
            // Filter by user_id in the related santris table
            $query->whereHas('santri', function (Builder $q) use ($request) {
                $q->where('user_id', $request->santri_id);
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Order by creation date descending
        $walletHistories = $query->latest()->paginate(10); // Get results with pagination

        return view('admin.wallet_histories.index', compact('walletHistories', 'santris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WalletHistory $wallet_histories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WalletHistory $wallet_histories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WalletHistory $wallet_histories)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WalletHistory $wallet_histories)
    {
        //
    }
}
