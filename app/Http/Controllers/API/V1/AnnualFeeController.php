<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Members\MemberRequest;
use App\Models\Member;
use Illuminate\Http\Request;

class AnnualFeeController extends BaseController
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
        \Log::info($request);

        $query = $this->member->query() ;

        # Remove illegal ID
        $query->where('id', '!=', '');

        $str = 'annual_fee' ;
        $value = $request[$str] ;
        if (!empty($request[$str])) {
            $query->where($str,'like','%'.$value.'%');
        }

        $users = \DB::table('members')
            ->where('id', '!=', '')
            ->where('annual_fee','like','%'.$value.'%')
            ->select(\DB::raw('count(*) as count, graduate'))
            ->groupBy(\DB::raw('graduate'))->get();
            
        \Log::info($users);

        $members = $query->orderBy('id','asc')->paginate(10) ;  

        return $this->sendResponse($members, 'Member listt');

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

        \Log::info($id);
        \Log::info($request);

        $member = $this->member->findOrFail($id);

        $member->update($request->all());

        // update pivot table
/*        
        $tag_ids = [];
        foreach ($request->get('tags') as $tag) {
            $tag_ids[] = $tag['id'];
        }
        $member->tags()->sync($tag_ids);
*/
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
