<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\JuniorHighSchool;
use Illuminate\Http\Request;

class JuniorHighSchoolController extends BaseController
{
    protected $juniorhighschool = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(JuniorHighSchool $juniorhighschool)
    {
        $this->middleware('auth:api');
        $this->juniorhighschool = $juniorhighschool;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $juniorhighschools = $this->juniorhighschool->latest()->paginate(10);

        return $this->sendResponse($juniorhighschools, 'JuniorHighSchool list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $juniorhighschools = $this->juniorhighschool->pluck('name');
        \Log::info('JHS');
        \Log::info($juniorhighschools);

        return $this->sendResponse($juniorhighschools, 'JuniorHighSchool list');
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
        $tag = $this->juniorhighschool->create([
            'name' => $request->get('name'),
        ]);

        return $this->sendResponse($tag, 'JuniorHighSchool Created Successfully');
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
        $tag = $this->juniorhighschool->findOrFail($id);

        $tag->update($request->all());

        return $this->sendResponse($tag, 'JuniorHighSchool Information has been updated');
    }
}
