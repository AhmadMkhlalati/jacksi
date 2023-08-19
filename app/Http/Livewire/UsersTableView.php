<?php

namespace App\Http\Livewire;

use App\Actions\SendNotificationToUser;
use LaravelViews\Actions\Action;
use \LaravelViews\Facades\Header;
use LaravelViews\Views\TableView;
use App\Models\User;
class UsersTableView extends TableView
{
    /**
     * Sets a model class to get the initial data
     */
    protected $model = User::class;
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
            Header::title('Name')->sortBy('name'),
            Header::title('Email')->sortBy('email'),
            Header::title('Mobile Type')->sortBy('mobile_type'),
            Header::title('Created')->sortBy('created_at'),
        ];
    }
    protected function actionsByRow()
    {
        return [
            new SendNotificationToUser,

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
            $model->name,
            $model->email,
            $model->mobile_type,
            $model->created_at,
        ];
    }
}
