<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'information';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Ambil satu nilai information berdasarkan key.
     * Contoh: Information::getValue('jam_operasional');
     */
    public static function getValue(string $key, $default = null)
    {
        $item = static::where('key', $key)->first();

        return $item ? $item->value : $default;
    }

    /**
     * Set atau update nilai information berdasarkan key.
     * Contoh: Information::setValue('jam_operasional', '07.00 - 16.00');
     */
    public static function setValue(string $key, $value): self
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}