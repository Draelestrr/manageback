<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    /**
     * Atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'amount',
        'date',
        'user_id',
        'receipt_image_path',
    ];

    /**
     * Relación con el usuario que registró el gasto.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con los cargos adicionales (gastos generales no registrados como productos).
     */
    public function extraCharges()
    {
        return $this->hasMany(ExtraCharge::class);
    }

    /**
     * Relación con los productos asociados al gasto (traspasos internos).
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'expense_product')
            ->withPivot('quantity', 'purchase_price', 'subtotal')
            ->withTimestamps();
    }
}
