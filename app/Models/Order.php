<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $casts = [
        'approver' => 'array'
    ];

    protected $guarded = ['id'];

    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function vehicle(){
        return $this->belongsTo(Employee::class, 'vehicle_id');
    }
}
