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

        return redirect()->route('boards.index')->with('flash_message', '投稿が完了しました');
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
        $user = Auth::user();
        $board = Board::find($id);
        
        if ($user->can('edit', $board)) {
            return view('boards.edit', ['board' => $board]);
        } else {
            return redirect()->route('boards.index')->with('error_message', '編集権限がありません');
        }
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
                $path = Storage::disk('s3')->putFile('/', $image);    
            }
        }

        $board->update([
            'title' => $request->title,
            'url' => $request->url,
            'img_path' => $path,
            'description' => $request->description,
        ]);

        return redirect()->route('boards.index')->with('flash_message', '更新が完了しました');
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

        return redirect()->route('boards.index')->with('flash_message', '削除が完了しました');
    }

    public function bookmark(Request $request)
    {
        $user_id = Auth::user()->id;
        $board_id = $request->board_id;
        $already_bookmarked = Bookmark::where('user_id', $user_id)->where('board_id', $board_id)->first();

        if (!$already_bookmarked) {
            Bookmark::create([
                'user_id' => $user_id,
                'board_id' => $board_id]);
        } else {
                Bookmark::where('board_id', $board_id)->where('user_id', $user_id)->delete(); 
        }

        return redirect()->back();
    }

    public function bookmark_boards()
    {
        $boards = \Auth::user()->bookmark_boards()->paginate(6); 

        return view('boards.bookmarks', compact('boards'));
    }
}
