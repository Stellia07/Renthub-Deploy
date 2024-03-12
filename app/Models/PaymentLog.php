<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    // Make sure the table name and attributes are correctly set
    protected $table = 'payment_logs';
    protected $fillable = ['user_id', 'amount', 'recipient_email', 'sender_email', 'description', 'receipt_image_path, created_at', 'updated_at'];

    // other configurations...
}
