<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mails', function (Blueprint $table) {
            $table->id();
            $table->text('email')->comment('メールアドレス');
            $table->timestamp('created_at')->nullable()->comment('作成日時');
            $table->unsignedBigInteger('created_by')->nullable()->comment('作成者ID');
            $table->timestamp('updated_at')->nullable()->comment('更新日付');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('更新者ID');
            $table->boolean('delete_flag')->default(false)->comment('削除フラグ(1: 削除済, 0:未削除)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mails');
    }
}
