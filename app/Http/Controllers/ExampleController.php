public function __construct()
    {
        $this->middleware('auth')->except(['index', 'detail']);
    }

    public function index()
    {
        $data = Article::latest()->paginate(5);
        return view('articles.index', ['articles' => $data]);
    }
    public function detail($id)
    {
        $data = Article::find($id);

        return view('articles.detail', [
            'article' => $data
        ]);
    }

    public function add()
    {
       $categories = Category::all();
        return view('articles.add', ['categories' => $categories]);
    }

    public function create()
    {
        $validator = validator(request()->all(), [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
            // 'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        $article = new Article;
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->user_id = Auth::id();
        $article->save();

        return redirect('/articles');
    }

    public function delete($id)
    {
        $article = Article::find($id);
        if (Gate::allows('delete-article', $article)) {
            $article->delete();
            return redirect('/articles')->with('info', 'Article deleted');
        }
        return back()->with('info', 'Unauthorize to delete.');
    }

    public function edit($id)
    {
        $article = Article::find($id);

        return view("articles.edit", [
            "categories" => Category::all(),
            "article" => $article,
        ]);
    }

    public function update($id)
    {
        $validator = validator(request()->all(), [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
            // 'user_id' => 'required', No need
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $article = Article::find($id);
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->user_id = Auth::id();
        // $article->user_id = request()->user_id;
        $article->save();

        return redirect("/articles/detail/$id"); //need to use " " code for $id 
    } 
    