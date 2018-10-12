<?php
// it is important note just in laravel >>>> the name of 
// the class inside the file must and must be the same name of the file name because if you noticed that at each file in laravel 
// you are type {{ use App\lolo\soso; }} and that must happen only if
// you include or include_once its filename or require or require_once
// so laravel need the name of the file be the exact same of the class name inside the file to make this operation automatically
// and that is happen buy native php function called spl_autoload_register() and there is another magic method called __autoload($class)
// which will be called automatically when use statement gets executed with the class to be used as an argument and this can help you to load the class at run-time on the fly as and when needed.
/*spl_autoload_register(function ($class_name) {
    require $class_name . '.php';
});*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\post;
use DB;

class PostsController extends Controller
{
    /**
     * 
     * create a new controller instance
     * @return void
     */
    public function __construct()
    {
        // you must know that the next statement in the comment mean that this middleware will be applied on nothing because you say only nothing 
        // so you must remove the seconde argument
        // and by the way i you say except nothing it will not ignore any action because
        // you didn't mention anyone and in this case the middleware will be applied on the all action in this controller
        // $this->middleware('auth', ['only'=>['']]);

        // $this->middleware('auth', ['only'=>'create']);
        // $this->middleware('auth', ['except' => 'index']);
        
        // the next two lines will give you the same result
        // $this->middleware('auth', ['only' => ['create','store','edit' ,'update', 'destroy'] ]);
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $p = new post();
        // $posts = post::all(); // eloquent method (ORM) object-relational mapping
        // $posts = post::orderBy('title','desc')->take(1)->get();
        // return $posts = post::where('title','post two')->get();
        // $posts = DB::select('select * from posts'); // Fluent query-builder
        // $posts = post::orderBy('title','desc')->paginate(1);  /*{{$posts->links()}}*/
        $posts = post::orderBy('created_at','desc')->get();
        // return view('posts/index')->with('posts' , $posts);
        return view('posts.index')->with('posts' , $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   /* 
        * if you specified the type of the field in the validator [image or date etc..] and sent empty field 
        * the validator will consider it will be null and raise up error message , so you can also put
        * >>>>>>>>>>> nullable <<<<<<<<
        */
        $this->validate($request , ['title'=>'required' ,'body'=>'required', 'image_name'=>'image|max:1999|nullable']);

        // Handle File Upload
        if ($request->hasFile('image_name')) {
           /*

            // Get File name with extension
            $fileWithExt = $request->file('image_name')->getClientOriginalName();
            // Get File name without extension by native php function
            $filename = pathinfo($fileWithExt, PATHINFO_FILENAME);
            // Get just File extension 
            $extension = $request->file('image_name')->getClientOriginalExtension();
            // filename to store in DB
            $fileToStore = $filename.'_'.time().'.'.$extension;
            // upload image content to host
            $request->file('image_name')->storeAs('public/posts_images', $fileToStore);

            */

// you can replace all of the above this this two lines ^_^
            $path = $request->file('image_name')->store('public/posts_images');
            
            $fileToStore = $this->getUrl($path);
        }
        else {
            $fileToStore = '/storage/posts_images/noImage.jpg';
        }

        // submit data into DB
        $post = new post();
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->image_name = $fileToStore;
        $post->save();
        return redirect('/posts')->with('success','post has been created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = post::find($id);
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = post::find($id);
        // i will  check authintication before show edit view
        // in the next line i have option to use $post->usr->id
        // instead of using $post->user_id but here i prefered use the second one 
        // becase it faster than another one because the first one will invoke _get
        // which is will take time for searching about method with name usr and also 
        // it will take time for creating new property with new object .
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'you can not access this page');
        }
        return view('posts.edit')->with('post' , $post);
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
        $this->validate($request, ['title'=>'required', 'body'=>'required', 'image_name'=>'image|max:1999']);
        $post = post::find($id);
        // Handle File Upload
        if ($request->hasFile('image_name')) {
            /*// Get File name with EXTENSION
            $fileWithExt = $request->file('image_name')->getClientOriginalName();
            // Get File Name without any extension by using PHP native function 
            $filename = md5(pathinfo($fileWithExt, PATHINFO_FILENAME));
            // Get just File Extension
            $extension = $request->file('image_name')->getClientOriginalExtension();
            // intialize the final file name which will be updated
            $fileToStore = $filename.'_'.time().'.'.$extension;
            // delete the old image from the host to make some space for new one*/
            if ($post->image_name != '/storage/posts_images/noImage.jpg')
                // $this->getUrl($post->image_name) is equal to /public/posts_images/dsadad.jpg
                Storage::delete($this->getUrl($post->image_name));
            // upload image content to the host 
            $path = $request->file('image_name')->store('public/posts_images');
            // $this->getUrl($path) is equal to /storage/posts_images/dsadad.jpg
            $fileToStore = $this->getUrl($path);
        }
        elseif (!empty($post->image_name)) {
            $fileToStore = $post->image_name;
        }
        // update all data in DB
        
        $post->title = $request->title;
        $post->body = $request->body;
        $post->image_name = $fileToStore;
        $post->save();
        return redirect('/posts')->with('success','post number "'.$id.'" has updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = post::find($id);
        $post->delete();
        //untill the previouse line the recorde in the DB has removed but the $post object keep its property the same 
        // so we can use its property down here
        if ($post->image_name != '/storage/posts_images/noImage.jpg') {
            // $this->getUrl($post->image_name) is equal to /public/posts_images/dsadad.jpg
            Storage::delete($this->getUrl($post->image_name));
        }
        return redirect('/posts')->with('success' , 'post with name "'.$post->title.'" has deleted successfuly');
    }

    public function getUrl($path)
    {
        $arr =  explode('/' , $path);
        // the next check for storage/app/
        if ($arr[1] === 'storage') {
            $arr[1] = 'public';
        }
        // the next check for /storage/posts_images/
        elseif ($arr[0] == 'public') {
            $arr[0] = '/storage';
        }

        // $url = implode('/' , $arr);
        $url = join('/' , $arr);
        return $url;
    }
}
