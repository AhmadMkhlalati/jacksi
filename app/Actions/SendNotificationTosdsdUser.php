<?php

namespace App\Actions;

use App\Helpers\FriendsHelper;
use App\Models\FriendsIssue;
use App\Models\UniteOrder;
use LaravelViews\Actions\Action;
use LaravelViews\Views\View;
use LaravelViews\Actions\Confirmable;
use LaravelViews\Views\Traits\WithAlerts;



class SendNotificationToUser extends Action
{
    use Confirmable,WithAlerts;

    /**
     * Any title you want to be displayed
     * @var String
     * */
    public $title = "أعادة أرسال";


    /**
     * This should be a valid Feather icon string
     * @var String
     */
    public $icon = "repeat";

    /**
     * Execute the action when the user clicked on the button
     *
     * @param $model Model object of the list where the user has clicked
     * @param $view Current view where the action was executed from
     */
    public function handle($model, View $view)
    {

        $model->payment_result = 'Success';
        $number = '09' . substr($model->number, -8, 8);
        $friend_responce = FriendsIssue::where('units_order_id', $model->id)->first();
        $rest = $model->rest;
        foreach ( $model->rest as $key=> $unit) {

            $response = FriendsHelper::send_units((int)$unit, $number,$model->type);

            if ($response->ok() && $response->json()['PayResult']['status'] == 1) {
                $rest = array_splice($rest, $key, 1);
                $model->status = 'Done';
                if ($friend_responce != null) {
                    FriendsIssue::where('units_order_id', $model->id)->delete();
                }
            }
            else {
                FriendsIssue::updateOrCreate(
                    ['units_order_id'=> $model->id],
                    ['units_order_id'=> $model->id,'error_response'=>$response->json()['PayResult']['ErrorMessage']]
                );

                $model->status = 'Pending';
                $model->rest = json_encode($rest);
                $model->save();
                \App\Helpers\Whatsapp::sendMessageWhatsapp('me',$model->id . ' صار في خطأ بتحويل الوحدات ' .$response->json()['PayResult']['ErrorMessage']);
                $this->error($response->json()['PayResult']['ErrorMessage']);

            }
        }
        $model->save();
        $this->success('تمت عملية التحويل بنجاح');



        // Your code here
    }
}
