<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Bookmark;
use App\Models\User;
use App\Http\Requests\StoreBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BoardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->only(['bookmark', 'unbookmark']); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $query = Board::latest()->search($search);

        $boards = $query->select('id', 'title', 'url', 'img_path', 'user_id')->paginate(6);

        return view('boards.index', compact('boards')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('boards.create'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBoardRequest $request)
    {
        if (app()->isLocal()) {
            $img = $request->file('img_path')->store('img','public');
        } else {
            $image = $request->file('img_path');
            $img = Storage::disk('s3')->putFile('/', $image); 
        }

        Board::create([
            'title' => $request->title,
            'url' => $request->url,
            'description' => $request->description,
            'img_path' => $img,
        ]); 

        return redirect()->route('boards.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $board = Board::find($id); 

        return view('boards.show', compact('board'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $board = Board::find($id);

        return view('boards.edit', ['board' => $board]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBoardRequest $request, $id)
    {
        $board = Board::find($id); 
        $image = $request->file('img_path');
        $path = $board->img_path;
        if (isset($image)) {
            if (app()->isLocal()) {
                Storage::delete('public/image/', $board->img_path); 
                $path = $request->file('img_path')->store('img', 'public');
            } else {
                Storage::disk('s3')->delete($image);
                $path = Storage::disk('s3')->putFile('/', $image, 'public');    
            }
        }

        $board->update([
            'title' => $request->title,
            'url' => $request->url,
            'img_path' => $path,
            'description' => $request->description,
        ]);

        return redirect()->route('boards.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $board = Board::find($id);
        $board->delete();

        return redirect()->route('boards.index');
    }

    public function bookmark($id)
    {
        Bookmark::create([
            'board_id' => $id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back();
    }

    public function unbookmark($id)
    {
        $bookmark = Bookmark::where('board_id', $id)->where('user_id', Auth::id())->first();
        $bookmark->delete();

        return redirect()->back();
    }

    public function bookmark_boards()
    {
        $boards = \Auth::user()->bookmark_boards()->paginate(6); 

        return view('boards.bookmarks', compact('boards'));
    }
}
