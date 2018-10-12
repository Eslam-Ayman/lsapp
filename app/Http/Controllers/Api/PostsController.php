<?php
// PHP is not case sensitive
namespace App\Http\Controllers\Api;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\POST;
use Validator;
class PostsController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }*/
    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $OneItem
     * @return array
     */

    private function transform($OneItem){
        // return array_map(function(){
            return [
                    'current_page'=>$OneItem['current_page'],
                    'data'=>array_map(function($item){
                        return ['dodod'=>$item['id'], 'toto'=>$item['title'], 'bobo'=>$item['body']];
                    }, $OneItem['data']),
                    "from"=> $OneItem['from'],
                    "last_page"=> $OneItem['last_page'],
                    "next_page_url"=> $OneItem['next_page_url'],
                    "path"=> $OneItem['path'],
                    "per_page"=> $OneItem['per_page'],
                    "prev_page_url"=> $OneItem['prev_page_url'],
                    "to"=> $OneItem['to'],
                    "total"=> $OneItem['total']
                ];

        // }, $OneItem);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
         // return response([dd(Post::orderBy('created_at', 'desc')->with('usr')->paginate(3)->toArray())]);
        $dbRes = Post::orderBy('created_at', 'desc')->with('usr')->paginate(3)->toArray();
        // dd($dbRes->lastPage);
        // array map function run one function on the all array elemnt 
        // you can pass array that you need in the second argument and 
        // the first one is the function that you need to implement
        // return array_map([$this,'transform'], ['all'=>$dbRes]);

        return response([
                        'current_page'=>$dbRes['current_page'],
                        'data'=> $dbRes['data'],
                        "from"=> $dbRes['from'],
                        "last_page"=> $dbRes['last_page'],
                        "next_page_url"=> $dbRes['next_page_url'],
                        "path"=> $dbRes['path'],
                        "per_page"=> $dbRes['per_page'],
                        "prev_page_url"=> $dbRes['prev_page_url'],
                        "to"=> $dbRes['to'],
                        "total"=> $dbRes['total']
                        ]);

        // $result =  Post::orderBy('created_at', 'desc')->paginate(2);
        // return response(['all_posts'=>$result], 200 /*, if you need response with header*/);
        // return response([compact('result')]);
        // return of this function will be array with array_map(function($item){}, array $items);
        // return response()->json($array, 200);

        // the next functions is no longer be supported by any version greater than 4.2
        // return Response::json(['data'=>'string|json|collection'], 200 /*, if you need response with header*/);
        // $dbRes->getCurrentPage();      $dbRes->getPerPage();    $dbRes->getTotal();
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $val = validator::make($request->all(), ['title'=>'required','body'=>'required', 'image_name'=>'image|max:1999']);
        if ($val->fails())
            return response($val->messages(), 422);
        else{
            $post = new post();
            $post->title = $request->title;
            $post->body = $request->body;
            $post->image_name = 'noImage.jpg';
            $post->user_id = auth()->user()->id;
            $post->save();
            return response('successfully created', Response::HTTP_CREATED);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $one = Post::find($id);
        // check if id is not found
        if (!$one) {
            return response(['messages'=>'id is wrong'], 422);
        }
        $one->usr;
        return compact('one');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $val = validator::make(request()->all(), ['title'=>'required', 'body'=>'required']);
        if ($val->fails())
            return $val->messages();

        $post = post::find($id);
        if (! $post)
            return response()->json('there is no such id', 404);
        
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();
        return response('updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = post::find($id);
        if (empty($result)) {
            return response(['this id not existing'], 422);
        }
        $result->delete();
        return response('this post deleted successfully', 200);
    }
}
