<?php

namespace App\Mailer;
use Mail;
use Naux\Mail\SendCloudTemplate;

/**
 * 重构邮件类
 * Class Mailer
 *
 * @package \App\Mailer
 */
class Mailer
{
    public function sendTo($template, $email, array $data)
    {
        // 模板变量
        // $data = ['url' => 'http://zhihu.app', 'name' => Auth::guard('api')->user()->name];
        $content = new SendCloudTemplate($template, $data);

        Mail::raw($content, function ($message) use ($email)
        {
            $message->from('corwien@qq.com', 'Zhihu');
            $message->to($email);
        });


    }

}
