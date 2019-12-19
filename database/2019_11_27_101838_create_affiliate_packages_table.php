<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_partners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->boolean('email_notifications')->default(0); // For notification purposes (not managed by this package)
            $table->string('country')->nullable();
            $table->string('royalty_type')->default('percent');
            $table->decimal('royalty_amount')->default(0);
            $table->boolean('active')->default(1);
            $table->json('options')->nullable();
            $table->timestamps();
        });

        Schema::create('affiliate_trackings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('partner_id');
            $table->string('code');
            $table->string('origin')->nullable();
            $table->string('destination')->nullable();
            $table->string('country')->nullable(); // This package does not handle this, you can do it yourself using cloudflare or other ip based
            $table->string('ip')->nullable();
            $table->json('tracking')->nullable();
            $table->json('extra')->nullable();
            $table->timestamps();
        });

        Schema::create('affiliate_referrals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tracking_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });

        Schema::create('affiliate_conversion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('referral_id');
            $table->decimal('amount', 13, 2);
            $table->string('status')->default('pending'); // Pending // Approved // Rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('affiliate_partners');
        Schema::dropIfExists('affiliate_trackings');
        Schema::dropIfExists('affiliate_referrals');
        Schema::dropIfExists('affiliate_conversions');
    }
}
