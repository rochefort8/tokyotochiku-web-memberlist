<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Club;
use Illuminate\Http\Request;

class ClubController extends BaseController
{
    protected $club = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Club $club)
    {
        $this->middleware('auth:api');
        $this->club = $club;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clubs = $this->club->latest()->paginate(10);

        return $this->sendResponse($clubs, 'Club list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $clubs = $this->club->pluck('name');

        return $this->sendResponse($clubs, 'Club list');
    }


    /**
     * Store a newly created resource in storage.
     *
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $tag = $this->club->create([
            'name' => $request->get('name'),
        ]);

        return $this->sendResponse($tag, 'Club Created Successfully');
    }

    /**
     * Update the resource in storage
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $tag = $this->club->findOrFail($id);

        $tag->update($request->all());

        return $this->sendResponse($tag, 'Club Information has been updated');
    }
}
