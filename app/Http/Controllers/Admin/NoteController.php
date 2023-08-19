<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoteRequest;
use App\Repositories\NoteRepository;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    private $noteRepo;

    public function __construct(NoteRepository $noteRepo)
    {
        $this->noteRepo = $noteRepo;

    }
    public function index(){
        return view('admin.notes.index');
    }
    public function create(){
        return view('admin.notes.create');
    }
    public function store(Request $request){
        try{
            $this->noteRepo->create_record($request->input('content'),$request->file('image'),1);
            return redirect()->back()->with(['status'=>'notification has been send successfully']);
        }
        catch (\Exception $e){
            return redirect()->back()->with(['error'=>$e->getMessage()]);
        }
    }

}
