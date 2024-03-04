<?php

namespace App\Http\Controllers;

use App\Models\PackagesHasBag;
use Illuminate\Http\Request;

/**
 * Class PackagesHasBagController
 * @package App\Http\Controllers
 */
class PackagesHasBagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packagesHasBags = PackagesHasBag::paginate();

        return view('packages-has-bag.index', compact('packagesHasBags'))
            ->with('i', (request()->input('page', 1) - 1) * $packagesHasBags->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packagesHasBag = new PackagesHasBag();
        return view('packages-has-bag.create', compact('packagesHasBag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(PackagesHasBag::$rules);

        $packagesHasBag = PackagesHasBag::create($request->all());

        return redirect()->route('packages-has-bags.index')
            ->with('success', 'PackagesHasBag created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $packagesHasBag = PackagesHasBag::find($id);

        return view('packages-has-bag.show', compact('packagesHasBag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $packagesHasBag = PackagesHasBag::find($id);

        return view('packages-has-bag.edit', compact('packagesHasBag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  PackagesHasBag $packagesHasBag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PackagesHasBag $packagesHasBag)
    {
        request()->validate(PackagesHasBag::$rules);

        $packagesHasBag->update($request->all());

        return redirect()->route('packages-has-bags.index')
            ->with('success', 'PackagesHasBag updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $packagesHasBag = PackagesHasBag::find($id)->delete();

        return redirect()->route('packages-has-bags.index')
            ->with('success', 'PackagesHasBag deleted successfully');
    }
}
