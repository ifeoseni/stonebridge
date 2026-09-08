<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->string('group')->default('general');
            $table->string('label');
            $table->string('type')->default('text'); // text, textarea, image, richtext
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('approach_pillars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('icon_svg')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('clientele_criteria', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('retainer_engagements', function (Blueprint $table) {
            $table->id();
            $table->string('column_side')->default('left'); // left or right
            $table->string('title');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('private_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('circumstances');
            $table->text('motivation')->nullable();
            $table->string('status')->default('new'); // new, in_review, contacted, archived
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('sub_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->longText('content');
            $table->text('meta_description')->nullable();
            $table->boolean('is_published')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_pages');
        Schema::dropIfExists('private_inquiries');
        Schema::dropIfExists('retainer_engagements');
        Schema::dropIfExists('clientele_criteria');
        Schema::dropIfExists('approach_pillars');
        Schema::dropIfExists('site_settings');
    }
};
