<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLendingFieldsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Assuming 'users' table exists and 'id' is the primary key
            $table->unsignedBigInteger('borrower_id')->nullable()->after('owner_id');
            $table->foreign('borrower_id')->references('id')->on('users')->onDelete('set null');
            $table->dateTime('lend_date')->nullable()->after('borrower_id');
            $table->dateTime('return_date')->nullable()->after('lend_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['borrower_id']);
            $table->dropColumn(['borrower_id', 'lend_date', 'return_date']);
        });
    }
}