<?php

namespace App\Actions;

use LaravelViews\Actions\Action;
use LaravelViews\Actions\Confirmable;
use LaravelViews\Views\Traits\WithAlerts;
use LaravelViews\Views\View;

class InternetSuccessAction extends Action
{
    use Confirmable,WithAlerts;

    /**
     * Any title you want to be displayed
     * @var String
     * */
    public $title = "تم الارسال";

    /**
     * This should be a valid Feather icon string
     * @var String
     */
    public $icon = "check";

    /**
     * Execute the action when the user clicked on the button
     *
     * @param $model Model object of the list where the user has clicked
     * @param $view Current view where the action was executed from
     */
    public function handle($model, View $view)
    {
        if($model->status != 'Failed'){
            $model->status = 'Done';
            $model->save();
            $this->success('تمت عملية التحويل بنجاح');
        }else{
            $this->error('  لم يقم المستخدم بعملية الدفع');

        }

    }
}
