<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Members\MemberRequest;
use App\Models\Member;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MemberImport;

use Illuminate\Pagination\LengthAwarePaginator;


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
        \Log::info($request);

        $query = $this->member->query() ;

        # Remove illegal ID
        $query->where('id', '!=', '');        

        # Except removed items    
        $str = 'removed' ;
        $value = $request[$str] ;
        $removed_cond_str = '=';
        if (!empty($request[$str])) {
            $removed_cond_str = '!=';
        } 
        $query->where('removed',$removed_cond_str,NULL);
 
        # Free
        $str = 'free' ;
        $value = $request[$str] ;
        if (!empty($value)) {

            $strlen= mb_strlen($value) ;

            if ($strlen < 4) {
                $query->where(\DB::raw('CONCAT(
                    junior_high_school, graduate, club,
                    last_name_kana, first_name_kana,
                    last_name_kanji, first_name_kanji)'), 'like', '%'.$value.'%');
            } else {
                $query->where(\DB::raw('CONCAT(
                    id,email, junior_high_school, graduate, club, phone1,
                    last_name_kana, first_name_kana,phone2,
                    last_name_kanji, first_name_kanji)'), 'like', '%'.$value.'%');
            }

            $query->where('id', '!=', '')
                ->where('removed',$removed_cond_str,NULL);
        }
        
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
                ->where('removed',$removed_cond_str,NULL);
        }
      
        # Convert Kana
        $str = 'name' ;
        $value = $request[$str] ;
        if (!empty($value)) {
            $value = mb_convert_kana($value,'KC','UTF-8') ;

            $query->where('first_name_kanji','like','%'.$value.'%');     
            $query->orWhere('last_name_kanji','like','%'.$value.'%')
                    ->where('id', '!=', '')
                    ->where('removed',$removed_cond_str,NULL);
            $query->orWhere('first_name_kana','like','%'.$value.'%')
                    ->where('id', '!=', '')
                    ->where('removed',$removed_cond_str,NULL);
            $query->orWhere('last_name_kana','like','%'.$value.'%')
                    ->where('id', '!=', '')
                    ->where('removed',$removed_cond_str,NULL);
        }

        $members = $query->orderBy('id','asc')->paginate(10) ;  

//        \Log::info($members);

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
        $graduate = $request->get('graduate');

        # generate ID
        $query = $this->member->query()->where('id', '!=', ' ');
        $query->where('graduate', $graduate );
        $ids = $query->orderBy('id','desc')->limit(1)->get();
        $id = $ids[0]['id']+1 ;
        
        \Log::info($id);

        $member = $this->member->create([
            'id'                => $id,
            'graduate'          => $request->get('graduate'),
            'removed'           => '',
            'former_name_kanji' => $request->get('former_name_kanji'),
            'last_name_kanji'   => $request->get('last_name_kanji'),
            'first_name_kanji'  => $request->get('first_name_kanji'),
            'former_name_kana'  => $request->get('former_name_kana'),
            'last_name_kana'    => $request->get('last_name_kana'),
            'first_name_kana'   => $request->get('first_name_kana'),

            // 'gender'            => $request->get('gender'),    
            'gender'           => '0',    
            'zipcode'           => $request->get('zipcode'),   
            'address1'          => $request->get('address1'),    
            'address2'          => $request->get('address2'),    
            'address3'          => $request->get('address3'),    
            'phone1'            => $request->get('phone1'),    
            'phone2'            => $request->get('phone2'),    
            'email'             => $request->get('email'),    
            'club'              => $request->get('club'),
            'junior_high_school'=> $request->get('junior_high_school'),
            'couple'            => $request->get('couple'),
            'representative'    => $request->get('representative'),
            'bereau'            => $request->get('bereau'),
            'remarks'           => $request->get('remarks'),
            'annual_fee'        => $request->get('annual_fee'),
            'party_attendance'  => $request->get('party_attendance'),      
        ]);

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
        \Log::info('Uoplad');

        $file = $request->file('file');

        // TODO ; Veryfication
        $array = Excel::toArray(new MemberImport,$file); 

        $members = array() ;
        foreach ($array as $m => $value) {

            foreach ($value as $row) {
                $m = array(
                    'graduate'           => $row[0] ,
                    'last_name_kanji'    => $row[1] ,
                    'first_name_kanji'   => $row[2] ,
                    'last_name_kana'     => $row[3] ,
                    'first_name_kana'    => $row[4] ,
                    'gender'             => $row[5] ,        
                    'zipcode'            => $row[6] ,
                    'address1'           => $row[7] ,
                    'address2'           => $row[8] ,
                    'address3'           => $row[9] ,
                    'phone1'             => $row[10] ,
                    'phone2'             => $row[11] ,
                    'email'              => $row[12] ,
                    'club'               => $row[13] ,
                    'junior_high_school' => $row[14] ,
                );
                array_push($members,$m);
            }
        }
        $members = new LengthAwarePaginator(
//            collect($members)->forPage($request->page, 10),
            collect($members)->forPage(1, 10),
            count($members),
            10,
//            $request->page,
            1,
            array('path' => $request->url())
        );
        return $this->sendResponse($members, 'Member listt');

 
//        return redirect()->action('API\V1\MemberController@index');

//        $fileName = time() . '.' . $request->file->getClientOriginalExtension();
//        $request->file->move(public_path('upload'), $fileName);

 //       return response()->json(['success' => true]);
    }
}
