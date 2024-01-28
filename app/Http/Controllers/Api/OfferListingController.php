<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OfferListing;
use Illuminate\Http\Request;

class OfferListingController extends Controller
{
    public function index(): \Illuminate\Database\Eloquent\Collection|array
    {
        return OfferListing::with(['user' => function ($query) {
            $query->withCount(['ratings as positive' => function ($query) {
                $query->where('rating', '+');
            }, 'ratings as negative' => function ($query) {
                $query->where('rating', '-');
            }]);
        }])->get();
    }
}
