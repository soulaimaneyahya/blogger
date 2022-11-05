<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog_post_tag', function (Blueprint $table) {
            $table->dropForeign(['blog_post_id']);
            $table->dropColumn(['blog_post_id']);
        });
        Schema::rename('blog_post_tag', 'taggables');
        Schema::table('taggables', function (Blueprint $table) {
            $table->morphs('taggable');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taggables', function (Blueprint $table) {
            $table->dropMorphs('taggable');
        });
        Schema::rename('taggables', 'blog_post_tag');

        // disable fk checks
        Schema::disableForeignKeyConstraints();

        Schema::table('blog_post_tag', function (Blueprint $table) {
            $table->foreignId('blog_post_id')->constrained()->onDelete('cascade');
        });

        Schema::enableForeignKeyConstraints();
    }
};
