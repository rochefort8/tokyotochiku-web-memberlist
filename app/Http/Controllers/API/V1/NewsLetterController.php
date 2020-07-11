<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Members\MemberRequest;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class NewsLetterController extends BaseController
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

        # Verify address
        $query->where('zipcode', '!=', '');
        $query->where('address3', '!=', '');

        # Except removed items    
        $str = 'undelivered' ;
        $value = $request[$str] ;
        $undelivered_cond_str = '=';
        if (!empty($request[$str])) {
            $undelivered_cond_str = '!=';
        } 
        
        # Remove undeliverable
        $query->where('newsletter_undelivered',$undelivered_cond_str, NULL);

        # Except removed items    
        $str = 'removed' ;
        $value = $request[$str] ;
        $removed_cond_str = '=';
        if (!empty($request[$str])) {
            $removed_cond_str = '!=';
        } 
        $query->where('removed',$removed_cond_str,NULL);
 
        # Query 
        # TODO : 'address1', 'address2', 'address3'
        $keywords = [ 'email', 'graduate', 'junior_high_school', 'club', 'annual_fee', 'id'];
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
            $query->orWhere('phone2','like','%'.$value.'%')
                ->where('id', '!=', '')
                ->where('removed',$removed_cond_str,NULL)
                ->where('$newsletter_undelivered', $undelivered_cond_str , '')
                ->where('zipcode', '!=', '')
                ->where('address3', '!=', '');
        }
      
        # Convert Kana
        $str = 'name' ;
        $value = $request[$str] ;
        if (!empty($value)) {
            $value = mb_convert_kana($value,'KC','UTF-8') ;

            $query->where('first_name_kanji','like','%'.$value.'%');     
            $query->orWhere('last_name_kanji','like','%'.$value.'%')
                    ->where('id', '!=', '')
                    ->where('removed',$removed_cond_str,NULL)
                    ->where('undelivered',$undelivered_cond_str, NULL)
                    ->where('zipcode', '!=', '')
                    ->where('address3', '!=', '');
            
            $query->orWhere('first_name_kana','like','%'.$value.'%')
                    ->where('id', '!=', '')
                    ->where('removed',$removed_cond_str,NULL)
                    ->where('newsletter_undelivered',$undelivered_cond_str, NULL)
                    ->where('zipcode', '!=', '')
                    ->where('address3', '!=', '');
            $query->orWhere('last_name_kana','like','%'.$value.'%')
                    ->where('id', '!=', '')
                    ->where('removed',$removed_cond_str,NULL)
                    ->where('newsletter_undelivered',$undelivered_cond_str,NULL)
                    ->where('zipcode', '!=', '')
                    ->where('address3', '!=', '');
        }

        $members = $query->orderBy('id','asc')->paginate(10) ;  

//        \Log::info($members);

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
