<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoteDeleteRequest;
use App\Http\Requests\NoteRequest;
use App\Models\Note;
use App\Repositories\NoteRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    private $noteRepo;

    public function __construct(NoteRepository $noteRepo)
    {
        $this->noteRepo = $noteRepo;

    }
    public function index()
    {
        $notes = $this->noteRepo->user_notes();
        return response()->json([
            'message'=>'all user notes',
            'status'=>true,
            'notes'=> $notes,
        ]);
    }
    public function index_admin()
    {
        $notes = $this->noteRepo->admin_notes();
        return response()->json([
            'message'=>'all admin notes',
            'status'=>true,
            'notes'=> $notes,
        ]);
    }

    public function edit($id)
    {
        try {
            $note = $this->noteRepo->get_single_note_record($id);

            return response()->json([
                'message' => 'user note',
                'note' => $note,
                'status'=>true
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message'=>$e->getMessage(),
                'status'=>false,
            ],420);
        }

    }
    public function store(NoteRequest $request)
    {

        try {
            $note = $this->noteRepo->create_record($request->input('content'), $request->file('image'));

            return response()->json([
                'message' => 'Note stored successfully',
                'note' => $note,
                'status'=>true
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message'=>$e->getMessage(),
                'status'=>false,
            ],420);
        }
    }

    public function delete(NoteDeleteRequest $request){
        try{
             $this->noteRepo->delete_record($request->id);

            return response()->json([
                'message'=>'note has been deleted',
                'status'=>true,
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message'=>$e->getMessage(),
                'status'=>false,
            ],420);
        }
    }

    public function update(NoteDeleteRequest $request){
        try{
            $note = $this->noteRepo->update_record($request);
            return response()->json([
                'status'=>true,
                'note'=>$note,
                'message'=>'note has been updated'
            ]);
        }
        catch (\Exception $e){
            return response()->json([
                'status'=>false,
                'note'=>null,
                'message'=>$e->getMessage()
            ]);
        }

    }


}
