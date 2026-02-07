<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

use App\Imports\CustomersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomersExport;


class CustomerController extends Controller
{
    /* ===============================
       ✅ LISTE CLIENTS (admin + vendeur)
    =============================== */
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('customers.index', compact('customers'));
    }


    /* ===============================
       ✅ CREATE
    =============================== */
    public function create()
    {
        return view('customers.create');
    }


    /* ===============================
       ✅ STORE
    =============================== */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:50',
            'email'   => 'nullable|email|unique:customers,email',
            'address' => 'nullable|string|max:255',
        ]);

        Customer::create($data);

        return redirect()->route('customers.index')
            ->with('success', "Client ajouté ✅");
    }


    /* ===============================
       ✅ EDIT
    =============================== */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }


    /* ===============================
       ✅ UPDATE
    =============================== */
    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:50',
            'email'   => 'nullable|email|unique:customers,email,' . $customer->id,
            'address' => 'nullable|string|max:255',
        ]);

        $customer->update($data);

        return redirect()->route('customers.index')
            ->with('success', "Client modifié ✅");
    }


    /* ===============================
       ✅ DELETE (admin only)
    =============================== */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', "Client supprimé ✅");
    }


    /* ===============================
       ✅ IMPORT EXCEL (admin + vendeur)
    =============================== */
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new CustomersImport, $request->file('file'));

        return redirect()->route('customers.index')
            ->with('success', "Import clients terminé ✅");
    }


    /* ===============================
       ✅ EXPORT EXCEL (admin + vendeur)
    =============================== */
    public function exportExcel()
    {
        // ✅ Vérification rôle simple
        if (!in_array(auth()->user()->role, ['admin', 'vendeur'])) {
            abort(403);
        }

        return Excel::download(new \App\Exports\CustomersExport, 'clients.xlsx');
    }
}
