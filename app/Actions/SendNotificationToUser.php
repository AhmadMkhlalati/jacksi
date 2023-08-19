<?php

namespace App\Actions;

use App\Helpers\Notification;
use LaravelViews\Actions\Action;
use LaravelViews\Views\View;
use LaravelViews\Views\Traits\WithAlerts;


class SendNotificationToUser extends Action
{
    use WithAlerts;
    /**
     * Any title you want to be displayed
     * @var String
     * */
    public $title = "send notification";

    /**
     * This should be a valid Feather icon string
     * @var String
     */
    public $icon = "bell";

    /**
     * Execute the action when the user clicked on the button
     *
     * @param $model Model object of the list where the user has clicked
     * @param $view Current view where the action was executed from
     */
    public function handle($model, View $view)
    {

        if($model->fcm == null){
            $this->error('you cant send notification to this user');

        }
        else{
            redirect()->route('send.user.notification',$model->id);
        }


    }
}
