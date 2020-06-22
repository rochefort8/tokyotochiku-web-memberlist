<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Members\MemberRequest;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends BaseController
{

    protected $member = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Member $member)
    {
        $this->middleware('auth:api');
        $this->member = $member;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $this->member->query() ;

        \Log::info($request);

        # Query 
        $keywords = [ 'email', 'address', 'graduate', 'junior_high_school', 'club', 'annual_fee', 'id'];
        foreach($keywords as $str) {   
            $value = $request[$str] ;
            if (!empty($value)) {
                $query->where($str,'like','%'.$value.'%');
            }    
        }

        # QUery both phone 1 and 2

        $str = 'phone' ;
        $value = $request[$str] ;
        if (!empty($request[$str])) {
            $query->where('phone1','like','%'.$value.'%');
            $query->orWhere('phone2','like','%'.$value.'%');
        }
      
        # Convert Kana
        $str = 'name' ;
        $value = $request[$str] ;
        if (!empty($value)) {
            $value = mb_convert_kana($value,'KC','UTF-8') ;

            $query->where('first_name_kanji','like','%'.$value.'%');
            $query->orWhere('last_name_kanji','like','%'.$value.'%');
            $query->orWhere('first_name_kana','like','%'.$value.'%');
            $query->orWhere('last_name_kana','like','%'.$value.'%');
        }

        $members = $query->latest()->paginate(10) ;  

        \Log::info($members);


        return $this->sendResponse($members, 'Member listt');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Members\MemberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MemberRequest $request)
    {
        $member = $this->member->create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => $request->get('price'),
            'category_id' => $request->get('category_id'),
        ]);

        // update pivot table
        $tag_ids = [];
        foreach ($request->get('tags') as $tag) {
            $tag_ids[] = $tag['id'];
        }
        $member->tags()->sync($tag_ids);

        return $this->sendResponse($member, 'Member Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = $this->member->with(['category', 'tags'])->findOrFail($id);

        return $this->sendResponse($Member, 'Member Details');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Member  $Member
     * @return \Illuminate\Http\Response
     */
    public function update(MemberRequest $request, $id)
    {
        $member = $this->member->findOrFail($id);

        $member->update($request->all());

        // update pivot table
        $tag_ids = [];
        foreach ($request->get('tags') as $tag) {
            $tag_ids[] = $tag['id'];
        }
        $member->tags()->sync($tag_ids);

        return $this->sendResponse($member, 'Member Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('isAdmin');

        $member = $this->member->findOrFail($id);

        $member->delete();

        return $this->sendResponse($member, 'Member has been Deleted');
    }

    public function upload(Request $request)
    {
        $fileName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('upload'), $fileName);

        return response()->json(['success' => true]);
    }
}
