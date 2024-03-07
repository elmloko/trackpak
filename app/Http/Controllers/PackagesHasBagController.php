<?php

namespace App\Http\Controllers;

use App\Models\PackagesHasBag;
use Illuminate\Http\Request;

class PackagesHasBagController extends Controller
{

    public function index()
    {
        $packagesHasBags = PackagesHasBag::paginate();

        return view('packages-has-bag.index', compact('packagesHasBags'))
            ->with('i', (request()->input('page', 1) - 1) * $packagesHasBags->perPage());
    }

    public function create()
    {
        $packagesHasBag = new PackagesHasBag();
        return view('packages-has-bag.create', compact('packagesHasBag'));
    }

    public function store(Request $request)
    {
        request()->validate(PackagesHasBag::$rules);

        $packagesHasBag = PackagesHasBag::create($request->all());

        return redirect()->route('packages-has-bags.index')
            ->with('success', 'PackagesHasBag created successfully.');
    }

    public function show($id)
    {
        $packagesHasBag = PackagesHasBag::find($id);

        return view('packages-has-bag.show', compact('packagesHasBag'));
    }

    public function edit($id)
    {
        $packagesHasBag = PackagesHasBag::find($id);

        return view('packages-has-bag.edit', compact('packagesHasBag'));
    }

    public function update(Request $request, PackagesHasBag $packagesHasBag)
    {
        request()->validate(PackagesHasBag::$rules);

        $packagesHasBag->update($request->all());

        return redirect()->route('packages-has-bags.index')
            ->with('success', 'PackagesHasBag updated successfully');
    }

    public function destroy($id)
    {
        $packagesHasBag = PackagesHasBag::find($id)->delete();

        return redirect()->route('packages-has-bags.index')
            ->with('success', 'PackagesHasBag deleted successfully');
    }
}
