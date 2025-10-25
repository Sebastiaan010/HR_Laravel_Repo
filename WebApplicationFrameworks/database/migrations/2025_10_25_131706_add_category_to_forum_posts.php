<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void {
    Schema::table('forum_posts', function (Blueprint $t) {
        $t->string('category')->nullable()->after('title');
    });
}
public function down(): void {
    Schema::table('forum_posts', fn($t) => $t->dropColumn('category'));
}

};
