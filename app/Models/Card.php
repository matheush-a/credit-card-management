<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'limit',
        'annual_fee'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function register($data)
    {
        $instance = $this->newInstance($data);
        $instance->brand_id = $data['brand_id'];
        $instance->category_id = $data['category_id'];
        $instance->save();
        
        return $instance;
    }

    public function remove($id)
    {
        $softDeletedCard = $this->find($id)->delete();

        return $softDeletedCard;
    }

    public function show($id)
    {
        return $this->where('id', $id)
            ->with('brand:id,name', 'category:id,name')
            ->select('cards.name', 'cards.image', 'cards.limit', 'cards.annual_fee', 'cards.brand_id', 'cards.category_id')
            ->get();
    }

    public function updateCard($card, $data) {
        $card->fill($data);
        $card->save();
        
        return $card;
    }
}
