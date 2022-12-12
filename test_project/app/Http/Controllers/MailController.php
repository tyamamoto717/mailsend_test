<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mail;

class MailController extends Controller
{
    /**
     * メールアドレス一覧画面表示
     */
    public function mailList() {
        try {
            // メールアドレス一覧を取得する
            $mailList = DB::table('mails')
                ->select( 'id'
                    , 'email')
                ->orderByDesc('created_at')
                ->paginate(config('app.PAGE_MAX_LIMIT'));
            return view('mail-list')->with([
                'mailList' => $mailList,
            ]);

        } catch (\Exception $exception) {

            // エラーログ出力する。
            Log::error("Error : , error_message=" . $exception->getMessage());
            return view('mail-list');
        }
    }
    /**
     * メールアドレス新規作成画面表示
     */
    public function mailNew() {
        try {
            // 画面遷移
            return view('mail-new');

        } catch (\Exception $exception) {

            // エラーログ出力する。
            Log::error("Error : , error_message=" . $exception->getMessage());
            return redirect('/');
        }
    }

    /**
     * メールアドレス編集画面表示
     */
    public function mailShow($id) {
        try {
            $mail = DB::table('mails')
                ->select('id'
                    , 'email')
                ->where('id', $id)
                ->first();
            return view('mail-new')
                ->with([
                    'mail' => $mail,
                ]);

        } catch (\Exception $exception) {

            // エラーログ出力する。
            Log::error("Error : , error_message=" . $exception->getMessage());
            return redirect('/');
        }
    }

    /**
     * メールアドレス登録処理
     */
    public function mailResist(Request $request) {
        // バリデーションチェック
        $request->validate([
            'email' => 'required|email:filter,dns|unique:mails,email',
        ]);
        try {
            DB::beginTransaction();
            DB::table('mails')->insert([
                'email' => $request->email,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::commit();
            return redirect('/');

        } catch (\Exception $exception) {
            DB::rollBack();

            // エラーログ出力する。
            Log::error("Error : , error_message=" . $exception->getMessage());
            return redirect('/');
        }
    }

    /**
     * メールアドレス編集処理
     */
    public function mailEdit(Request $request, $id) {
        // バリデーションチェック
        $request->validate([
            'email' => 'required|email:filter,dns|unique:mails,email,'. $id. ',id',
        ]);
        try {
            DB::beginTransaction();
            DB::table('mails')->where('id', $id)->update([
                'email' => $request->email,
                'updated_at' => now(),
            ]);
            DB::commit();
            return redirect('/');

        } catch (\Exception $exception) {
            DB::rollBack();

            // エラーログ出力する。
            Log::error("Error : , error_message=" . $exception->getMessage());
            return redirect('/');
        }
    }

    /**
     * メールアドレス削除処理
     */
    public function mailDelete($id) {
        try {
            DB::beginTransaction();
            DB::table('mails')->where('id', $id)->delete();
            DB::commit();
            return redirect('/');

        } catch (\Exception $exception) {
            DB::rollBack();

            // エラーログ出力する。
            Log::error("Error : , error_message=" . $exception->getMessage());
            return redirect('/');
        }
    }

    /**
     * メールアドレス削除処理
     */
    public function mailSend() {
        if(isset($_POST['check'])) {
            $data = [];
            Mail::send('mail', $data, function($message){
                $checks = $_POST['check'];
                foreach($checks as $check){
                    $mail = DB::table('mails')
                        ->select('email')
                        ->where('id', (Integer) $check)
                        ->first();
                    $message->to($mail->email, 'Test')
                        ->subject('テスト');
                }
            });
        }
        return redirect('/');
    }
}
