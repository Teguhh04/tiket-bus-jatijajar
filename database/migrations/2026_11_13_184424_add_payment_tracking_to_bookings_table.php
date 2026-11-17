
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE bookings
            ADD COLUMN IF NOT EXISTS payment_status VARCHAR(255) NULL
        ");

        DB::statement("
            ALTER TABLE bookings
            ADD COLUMN IF NOT EXISTS paid_at TIMESTAMP NULL
        ");

        DB::statement("
            ALTER TABLE bookings
            ADD COLUMN IF NOT EXISTS midtrans_transaction_id VARCHAR(255) NULL
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE bookings
            DROP COLUMN IF EXISTS midtrans_transaction_id
        ");

        DB::statement("
            ALTER TABLE bookings
            DROP COLUMN IF EXISTS paid_at
        ");

        DB::statement("
            ALTER TABLE bookings
            DROP COLUMN IF EXISTS payment_status
        ");
    }
};
