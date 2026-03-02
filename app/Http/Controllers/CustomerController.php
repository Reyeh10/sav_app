<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\CustomersImport;
use Maatwebsite\Excel\Facades\Excel;
//use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;


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
        'name'        => 'required|string|max:255',
        'type_client' => 'required|string|max:100',
        'phone'       => [
            'required',
            'regex:/^\d{2}\s\d{2}\s\d{2}\s\d{2}$/'
        ],
        'email'       => 'nullable|email|unique:customers,email',
        'address'     => 'nullable|string|max:255',
    ]);

    Customer::create($data);

    return redirect()->route('customers.index')
        ->with('success', "Client ajouté ✅");
}

/* ===============================
   ✅ EDIT
=============================== */
public function edit($id)
{
    $customer = Customer::findOrFail($id);
    return view('customers.edit', compact('customer'));
}

/* ===============================
   ✅ UPDATE
=============================== */
/* public function update(Request $request, Customer $customer)
{
    $data = $request->validate([
        'name'        => 'required|string|max:255',
        'type_client' => 'required|string|max:100',
        'phone'       => [
            'required',
            'regex:/^\d{2}\s\d{2}\s\d{2}\s\d{2}$/'
        ],
        'email'       => 'nullable|email|unique:customers,email,' . $customer->id,
        'address'     => 'nullable|string|max:255',
    ]);

    $customer->update($data);

    return redirect()->route('customers.index')
        ->with('success', "Client modifié ✅");
} */



public function update(Request $request, $id)
{
    $customer = Customer::findOrFail($id);

    $data = $request->validate([
        'name'        => 'required|string|max:255',
        'type_client' => 'required|string|max:100',
        'phone'       => 'required|string|max:20',
        'email'       => [
            'nullable',
            'email',
            Rule::unique('customers')->ignore($customer->id),
        ],
        'address'     => 'nullable|string|max:255',
    ]);

    $customer->update($data);

    return redirect()->route('customers.index')
        ->with('success', "Client modifié avec succès ✅");
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
   ✅ QUICK STORE (AJAX MODAL)
=============================== */
public function quickStore(Request $request)
{
    try {

        /* ================= NORMALISATION ================= */

        $name       = trim((string) $request->input('name'));
        $email      = trim((string) $request->input('email'));
        $phone      = trim((string) $request->input('phone'));
        $address    = trim((string) $request->input('address'));
        $typeClient = trim((string) $request->input('type_client'));

        // Nettoyage espaces multiples dans le nom
        $name = preg_replace('/\s+/', ' ', $name);

        // Email vide → null + lowercase
        $email = $email !== '' ? strtolower($email) : null;

        // Téléphone vide → null
        $phone = $phone !== '' ? $phone : null;

        $request->merge([
            'name'        => $name,
            'email'       => $email,
            'phone'       => $phone,
            'address'     => $address !== '' ? $address : null,
            'type_client' => $typeClient,
        ]);

        /* ================= VALIDATION ================= */

        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:customers,name',
            'type_client' => 'required|string|max:100',
            'phone'       => ['nullable', 'regex:/^\+[1-9]\d{1,14}$/'],
            'email'       => ['nullable', 'email', 'unique:customers,email'],
            'address'     => 'nullable|string|max:255',
           // 'payment_type' => 'required',
        ], [
            'name.required'        => 'Le nom est obligatoire.',
            'type_client.required' => 'Le type de client est obligatoire.',
            'phone.regex'          => 'Format téléphone invalide. Exemple : +25377123456',
            'email.email'          => 'Email invalide.',
           // 'payment_type.required' => 'Le type de paiement est obligatoire.',

            // 🔥 Message général pour doublons
            'name.unique'  => 'Ce nom ou cet email existe déjà.',
            'email.unique' => 'Ce nom ou cet email existe déjà.',
        ]);

        /* ================= CREATE ================= */

        $customer = Customer::create($validated);

        return response()->json([
            'success'  => true,
            'customer' => $customer
        ], 201);

    } catch (\Illuminate\Validation\ValidationException $e) {

        return response()->json([
            'errors' => $e->errors()
        ], 422);

    } catch (\Throwable $e) {

        \Illuminate\Support\Facades\Log::error(
            'QUICK STORE ERROR => ' . $e->getMessage(),
            ['trace' => $e->getTraceAsString()]
        );

        return response()->json([
            'error' => 'Erreur serveur.'
        ], 500);
    }
}
/* ===============================
   ✅ EXPORT EXCEL (admin + vendeur)
=============================== */
public function exportExcel()
{
    if (!in_array(auth()->user()->role, ['admin', 'vendeur'])) {
        abort(403);
    }

    return Excel::download(
        new \App\Exports\CustomersExport,
        'clients.xlsx'
    );
}

}
