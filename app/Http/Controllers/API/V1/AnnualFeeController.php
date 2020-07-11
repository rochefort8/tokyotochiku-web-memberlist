<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Members\MemberRequest;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MemberExport;

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
        $year = $request[$str] ;
        if (!empty($request[$str])) {
            $query->where($str,'like','%'.$year.'%');   
        }

        $members = $query->get()->groupBy('graduate'); 

        \Log::info($members);

        $g_array = array();

        foreach ($members as $graduate=>$persons) {
            \Log::info($graduate);

            $counts = [ 0, 0, 0, 0, 0, 0 ] ;
            $sum = 0 ;
            foreach ($persons as $p) {
                $types = [ 'A', 'B', 'C', 'D', 'E', 'F'];
                $annual_fee = $p['annual_fee'];
                $pos = 0 ;    
                foreach ($types as $type) {
                    $s = $year . $type ;

                    if (strpos($annual_fee,$s) !== false) {
                        $counts[$pos]++ ;
                        $sum++ ;
                        break ;
                    }
                    $pos++;    
                }    
            }
            \Log::info($counts[0] . ':' . $counts[1] . ':' . $counts[2] . ':' . $counts[3] . ':' . $counts[4] . ':' . $counts[5]);
            $total_count = $this->member->query()->where('graduate',$graduate)->count();
            \Log::info($total_count);

            $a = array(
                'graduate' => $graduate ,
                'total_count' => $total_count,
                'post' => $counts[1],
                'bank' => $counts[2],
                'bank_auto' => $counts[0],
                'cash' => $counts[4],
                'cash_konshinkai' => $counts[5],
                'online' => $counts[3],
                'sum' => $sum,
            );
            array_push($g_array,$a);
        }        

        $members = array() ;
        for ($g=45;$g < 118;$g++) {
            $found='';
            foreach ($g_array as $gg) {
                if ($gg['graduate'] == $g ) { 
                \Log::info($gg);
                array_push($members,$gg);
                    $found='y';
                    break ;
                }
            }
            if ( $found == '') {
                $total_count = $this->member->query()->where('graduate',$g)->count();

                $a = array(
                    'graduate' => $g ,
                    'total_count' => $total_count,
                    'post' => 0,
                    'bank' => 0,
                    'bank_auto' => 0,
                    'cash' => 0,
                    'cash_konshinkai' => 0,
                    'online' => 0,
                    'sum' => 0,
                );
                array_push($members,$a);
            }
        }

//        \Log::info($members);

//        $members = $g_array;

        $members = new LengthAwarePaginator(
            collect($members)->forPage($request->page, 10),
            count($members),
            10,
            $request->page,
            array('path' => $request->url())
        );

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

    public function export(Request $request)
    {
        \Log::info('Export');

        return Excel::download(new MemberExport, 'output.xlsx');
    }

    public function upload(Request $request)
    {
        $fileName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('upload'), $fileName);

        return response()->json(['success' => true]);
    }
}
