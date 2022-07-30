<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CardController extends Controller
{
    protected Card $card;
    protected User $user;

    public function __construct(User $user, Card $card)
    {
        $this->card = $card;
        $this->user = $user;
    }

    public function index(Request $request)
    {
        $this->authorize('interact', Card::class);

        $name = $request->name;

        return $this->card->index($name);
    }

    public function remove($id)
    {
        $this->authorize('interact', Card::class);

        $card = $this->card->find($id);

        if(!$card) {
            return response()->json("Card not found.", Response::HTTP_BAD_REQUEST);
        }

        $this->card->remove($id);
    }

    public function store(Request $request)
    {
        $this->authorize('interact', Card::class);
        
        $request->validate([
            'name' => ['required', 'unique:cards', 'max:80'],
            'slug' => ['required', 'unique:cards'],
            'image' => ['required'],
            'brand_id' => ['required', 'integer', 'exists:brands,id'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ]);
        
        $this->card->register($request->all());
    }

    public function show(int $id)
    {
        $this->authorize('interact', Card::class);

        $card = $this->card->find($id);

        if(!$card) {
            return response()->json("Card not found.", Response::HTTP_BAD_REQUEST);
        }

        return $this->card->show($card->id);
    }

    public function update(int $id, Request $request)
    {
        $this->authorize('interact', Card::class);

        $request->validate([
            'name' => ['required', 'unique:cards', 'max:80'],
            'slug' => ['required', 'unique:cards'],
            'image' => ['required'],
            'brand_id' => ['required', 'integer', 'exists:brands,id'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ]);

        $card = $this->card->find($id);

        if(!$card) {
            return response()->json("Card not found.", Response::HTTP_BAD_REQUEST);
        }

        return $this->card->updateCard($card, $request->all());
    }
}