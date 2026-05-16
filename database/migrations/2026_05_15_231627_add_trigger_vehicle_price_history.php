<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER after_vehicle_price_update
            AFTER UPDATE ON vehicles
            FOR EACH ROW
            BEGIN
                IF OLD.daily_rate <> NEW.daily_rate THEN
                    INSERT INTO vehicle_price_histories (vehicle_id, old_price, new_price, changed_at)
                    VALUES (OLD.id, OLD.daily_rate, NEW.daily_rate, NOW());
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_vehicle_price_update');
    }
};
