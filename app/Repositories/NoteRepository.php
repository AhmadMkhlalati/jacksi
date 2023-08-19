<?php

namespace App\Repositories;

use App\Models\Note;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\Image;

class NoteRepository
{
    public function create_record($content,$image = null,$type=0)
    {
        try{

        $imagePath = null;
        if ($image) {
            $fileName = time() . '.' . $image->getClientOriginalExtension();

            $imagePath = Storage::disk('local')->put('public/images/notes', $image, 'public');
        }
        $note = Note::create([
            'user_id' => $type == 0 ? Auth::guard('api')->id() : null,
            'content' => $content,
            'image'=> basename($imagePath) ? 'images/notes/'.basename($imagePath) : null,
            'type'=>$type
        ]);
        return $note;
        }catch (\Exception $e){
           abort(430,$e->getMessage());
        }
    }

    public function user_notes()
    {
        $user_id = Auth::guard('api')->id();
        return Note::where('user_id',$user_id)->paginate();
    }

    public function get_single_note_record($id)
    {
        $note = Note::findOrFail($id);
        if(Auth::guard('api')->id() == $note->user_id){
            return $note;
        }
        else{
            abort(430,'note is not belong to you');
        }

    }

    public function admin_notes()
    {
        return Note::where('type',1)->paginate();
    }

    public function delete_record($id){
        $note = Note::findOrFail($id);
        if(Auth::guard('api')->id() == $note->user_id){
            $image__old = storage_path().'/app/public/'.$note->getAttributes()['image'];
            unlink($image__old);
            Note::find($id)->delete();
        }
        else{
            abort(430,'note is not belong to you');
        }
    }

    public function update_record($data){
        if(Auth::guard('api')->id() == Note::findOrFail($data->id)->user_id){
            $note = Note::find($data->id);

            if ($data->file('image')) {
                $fileName = time() . '.' . $data->file('image')->getClientOriginalExtension();
                $image__old = storage_path().'/app/public/'.$note->getAttributes()['image'];
                unlink($image__old);
                $imagePath = Storage::disk('local')->put('public/images/notes', $data->file('image'), 'public');
                $note->image = 'images/notes/'.basename($imagePath);
            }
            if($data->content){
                $note->content = $data->content;
            }
            $note->save();
            return $note;
        }
        else{
            abort(430,'note is not belong to you');
        }
    }

}
