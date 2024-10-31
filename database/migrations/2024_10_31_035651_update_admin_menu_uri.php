<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function config($key)
    {
        return config('admin.'.$key);
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table($this->config('database.menu_table'), function (Blueprint $table) {
            //
            \App\Models\Admin\AdminMenu::where('uri', '/')->where('id', 1)
                ->update([
                    'uri' => '/index'
                ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table($this->config('database.menu_table'), function (Blueprint $table) {
            \App\Models\Admin\AdminMenu::where('uri', '/index')->where('id', 1)
                ->update([
                    'uri' => '/'
                ]);
        });
    }
};
