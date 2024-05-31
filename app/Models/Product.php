<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\New_;

class Product extends Model
{
    use HasFactory;
    protected $fillable=['name', 'description', 'image', 'price'];

    public function url (): Attribute{
        return new Attribute(get: fn()=>route('products.image', $this));
    }

    protected $appends=['url'];
}
