<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Encryption\DecryptException;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('podaci')->orderBy('id')->chunkById(100, function ($rows) {
            foreach ($rows as $row) {
                DB::table('podaci')
                    ->where('id', $row->id)
                    ->update([
                        'value' => $this->encryptIfNeeded($row->value),
                    ]);
            }
        });

        DB::table('isprave')->orderBy('id')->chunkById(100, function ($rows) {
            foreach ($rows as $row) {
                DB::table('isprave')
                    ->where('id', $row->id)
                    ->update([
                        'name' => $this->encryptIfNeeded($row->name),
                        'document_number' => $this->encryptIfNeeded($row->document_number),
                        'issuer' => $this->encryptIfNeeded($row->issuer),
                        'note' => $this->encryptIfNeeded($row->note),
                    ]);
            }
        });

        DB::table('dokumenti')->orderBy('id')->chunkById(100, function ($rows) {
            foreach ($rows as $row) {
                DB::table('dokumenti')
                    ->where('id', $row->id)
                    ->update([
                        'name' => $this->encryptIfNeeded($row->name),
                        'original_name' => $this->encryptIfNeeded($row->original_name),
                    ]);
            }
        });
    }

    public function down(): void
    {
        DB::table('podaci')->orderBy('id')->chunkById(100, function ($rows) {
            foreach ($rows as $row) {
                DB::table('podaci')
                    ->where('id', $row->id)
                    ->update([
                        'value' => $this->decryptIfPossible($row->value),
                    ]);
            }
        });

        DB::table('isprave')->orderBy('id')->chunkById(100, function ($rows) {
            foreach ($rows as $row) {
                DB::table('isprave')
                    ->where('id', $row->id)
                    ->update([
                        'name' => $this->decryptIfPossible($row->name),
                        'document_number' => $this->decryptIfPossible($row->document_number),
                        'issuer' => $this->decryptIfPossible($row->issuer),
                        'note' => $this->decryptIfPossible($row->note),
                    ]);
            }
        });

        DB::table('dokumenti')->orderBy('id')->chunkById(100, function ($rows) {
            foreach ($rows as $row) {
                DB::table('dokumenti')
                    ->where('id', $row->id)
                    ->update([
                        'name' => $this->decryptIfPossible($row->name),
                        'original_name' => $this->decryptIfPossible($row->original_name),
                    ]);
            }
        });
    }

    private function encryptIfNeeded(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        try {
            Crypt::decryptString($value);

            return $value;
        } catch (DecryptException) {
            return Crypt::encryptString($value);
        }
    }

    private function decryptIfPossible(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        try {
            return Crypt::decryptString($value);
        } catch (DecryptException) {
            return $value;
        }
    }
};
