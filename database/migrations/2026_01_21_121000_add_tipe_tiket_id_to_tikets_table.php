<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // add tipe_tiket_id column
        Schema::table('tikets', function (Blueprint $table) {
            $table->foreignId('tipe_tiket_id')->nullable()->after('event_id')->constrained('tipe_tikets')->nullOnDelete();
        });

        // map existing enum values to tipe_tikets entries
        $mapping = [
            'reguler' => 'Reguler',
            'premium' => 'Premium',
        ];

        foreach ($mapping as $old => $name) {
            $tipe = DB::table('tipe_tikets')->where('nama', $name)->first();
            if (!$tipe) {
                $id = DB::table('tipe_tikets')->insertGetId(['nama' => $name, 'created_at' => now(), 'updated_at' => now()]);
                $tipe = (object)['id' => $id];
            }

            DB::table('tikets')->where('tipe', $old)->update(['tipe_tiket_id' => $tipe->id]);
        }

        // drop old enum column
        Schema::table('tikets', function (Blueprint $table) {
            if (Schema::hasColumn('tikets', 'tipe')) {
                $table->dropColumn('tipe');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tikets', function (Blueprint $table) {
            $table->enum('tipe', ['reguler', 'premium'])->after('event_id')->nullable();
        });

        // attempt to restore tipe from tipe_tikets (best-effort)
        $types = DB::table('tipe_tikets')->pluck('nama', 'id');
        foreach ($types as $id => $name) {
            $key = strtolower($name);
            DB::table('tikets')->where('tipe_tiket_id', $id)->update(['tipe' => $key]);
        }

        Schema::table('tikets', function (Blueprint $table) {
            $table->dropForeign(['tipe_tiket_id']);
            $table->dropColumn('tipe_tiket_id');
        });
    }
};
