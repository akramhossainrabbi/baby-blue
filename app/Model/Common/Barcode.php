<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    protected $fillable = [
        "invoice_no",
        "create_date",
        "name",
        "mobile",
        "email",
        "address",
        "sub_total",
        "discount",
        "tax",
        "grand_total",
        "paid",
        "delivery",
        "order_note",
         "created_by",
        "modified_by",
        "status"
    ];
    protected $table = "barcodes";

}
