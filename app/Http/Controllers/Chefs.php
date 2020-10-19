<?php

namespace App\Http\Controllers;

use App\Models\Dishes;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Chefs extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return User::where('user_type', 'chef')
            ->where('available', true)
            ->with('dish')
            ->get();

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function randomDish()
    {
        //
        $dis = User::where('user_type', 'chef')
            ->where('available', true)
            ->whereNotNull('active_dish_id')
            ->with('dish')
            ->inRandomOrder()
            ->first();

        if (!empty($dis->dish->description)) {
            $dis->dish->description = nl2br($dis->dish->description);
        }
        if (empty($dis->dish->image1)) {
            $dis->dish->image1 = '/images/bori-250.png';
        }
        if (empty($dis->dish->image2)) {
            $dis->dish->image2 = '/images/bori-250.png';
        }
        if (empty($dis->dish->image3)) {
            $dis->dish->image3 = '/images/bori-250.png';
        }
        return $dis;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function me()
    {
        return Auth::user()->toArray();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dish()
    {
        $user = Auth::user();
        $dish = Dishes::where('user_id', $user->id)->orderBy('id', 'desc')->first();
        if (!$dish) {
            //create default dish
            $dish = new Dishes();
            $dish->user_id = $user->id;
            $dish->save();

            $user->active_dish_id = $dish->id;
            $user->save();
        }
        return $dish;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveDish($id)
    {
        $user = Auth::user();
        $putData = request()->all();
        $putData = $putData['data'];

        if (empty($id)) {
            if (empty($dish)) {
                return response()->json(['status' => 'error', 'msg' => 'not allowed, no dish'], 400);
            }
        } else {
            $dish = Dishes::where('user_id', $user->id)
                ->where('id', $id)
                ->first();
            if (empty($dish)) {
                return response()->json(['status' => 'error', 'msg' => 'not allowed'], 400);
            }
        }

        if (isset($putData['price'])) {
            $putData['price'] = trim(str_replace(',', '.', $putData['price']));
        }
        foreach ($putData as $key => $val) {
            $dish->{$key} = $val;
        }
        $dish->save();
        $user->active_dish_id = $dish->id;
        $user->save();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveProfile()
    {
        $user = Auth::user();

        $putData = request()->all();
        $putData = $putData['data'];
        unset($putData['id']);
        unset($putData['created_at']);
        $dish = isset($putData['dish']) ? $putData['dish'] : null;
        unset($putData['dish']);
        foreach ($putData as $key => $val) {
            $user->{$key} = $val;
        }
        $user->save();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function image($path)
    {
        //
        return response()->file(storage_path('avatar/' . $path));


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function dishImage($path)
    {
        //
        return response()->file(storage_path('dishes/' . $path));


    }
}
