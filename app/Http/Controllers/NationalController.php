<?php

namespace App\Http\Controllers;

use App\Models\National;
use Illuminate\Http\Request;

/**
 * Class NationalController
 * @package App\Http\Controllers
 */
class NationalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nationals = National::paginate();

        return view('national.index', compact('nationals'))
            ->with('i', (request()->input('page', 1) - 1) * $nationals->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $national = new National();
        return view('national.create', compact('national'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(National::$rules);

        $national = National::create($request->all());

        return redirect()->route('nationals.index')
            ->with('success', 'National created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $national = National::find($id);

        return view('national.show', compact('national'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $national = National::find($id);

        return view('national.edit', compact('national'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  National $national
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, National $national)
    {
        request()->validate(National::$rules);

        $national->update($request->all());

        return redirect()->route('nationals.index')
            ->with('success', 'National updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $national = National::find($id)->delete();

        return redirect()->route('nationals.index')
            ->with('success', 'National deleted successfully');
    }
}
