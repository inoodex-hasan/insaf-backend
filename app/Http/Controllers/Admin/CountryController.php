<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view-countries')->only(['index']);
        $this->middleware('can:create-country')->only(['create', 'store']);
        $this->middleware('can:update-country')->only(['edit', 'update']);
        $this->middleware('can:delete-country')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $this->authorize('view-countries');

        $query = Country::query();

        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
        }

        $countries = $query->latest()->paginate(15)->withQueryString();

        return view('admin.countries.index', compact('countries'));
    }

    public function create()
    {
        $this->authorize('create-country');

        return view('admin.countries.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create-country');

        $validated = $this->validateCountry($request);

        Country::create($validated);

        return redirect()
            ->route('admin.countries.index')
            ->with('success', 'Country created successfully.');
    }

    public function edit(Country $country)
    {
        $this->authorize('update-country');

        return view('admin.countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $this->authorize('update-country');

        $validated = $this->validateCountry($request);

        $country->update($validated);

        return redirect()
            ->route('admin.countries.index')
            ->with('success', 'Country updated successfully.');
    }

    public function destroy(Country $country)
    {
        $this->authorize('delete-country');

        $country->delete();

        return redirect()
            ->route('admin.countries.index')
            ->with('success', 'Country deleted successfully.');
    }

    private function validateCountry(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:10'],
            'currency' => ['nullable', 'string', 'max:10'],
            'status' => ['required', 'boolean'],
        ]);
    }
}
