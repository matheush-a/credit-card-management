<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\User;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /*
    The features must be covered by unit tests;
        ● The list must be paginated on the backend and contain a maximum of 10 items per
        page; OK
        ● The list can be filtered on the backend by name; OK
        ● The list must contain the name of the card, brand [Visa, Mastercard, Elo] and category OK
        [Silver, Gold, Platinum, Black]; OK
        ● The list must be ordered by the name of the card; OK
        ● Only administrators can access the functionality. X
    */
    protected Card $card;
    protected User $user;

    public function __construct(User $user, Card $card)
    {
        $this->card = $card;
        $this->user = $user;
    }

    public function index(Request $request)
    {
        $name = $request->name;
        $builder = $this->card;

        $select = [
            'cards.name',
            'cards.brand_id',
            'cards.category_id',
        ];

        if($name) {
            $builder = $builder->where('name', 'like', '%'.$name.'%');
        }
        
        return $builder
            ->with('brand:id,name', 'category:id,name')
            ->select($select)
            ->paginate(10)
            ->sortBy('name');
    }
}