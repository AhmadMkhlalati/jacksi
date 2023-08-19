<?php

namespace App\Http\Livewire;

use LaravelViews\Actions\Action;
use \LaravelViews\Facades\Header;
use LaravelViews\Views\TableView;
use App\Models\Note;
class NotesTableView extends TableView
{
    /**
     * Sets a model class to get the initial data
     */
    protected $model = Note::class;
    protected $paginate = 10;
    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */

    public function headers(): array
    {
        return [
            Header::title('#')->sortBy('id'),
            Header::title('content')->sortBy('content'),
            Header::title('Image'),
            Header::title('Created')->sortBy('created_at'),
        ];
    }
    protected function actionsByRow()
    {
        return [
//            new SendNotificationToUser,

        ];
    }
    /**
     * Sets the data to every cell of a single row
     *
     * @param $model Current model for each row
     */
    public function row($model): array
    {
        return [
            $model->id,
            $model->content,
            '<image src="'.$model->image.'" style="max-width:250px"/>',
            $model->created_at,
        ];
    }
}
