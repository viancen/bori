<?php

namespace App\Http\Controllers;

use App\Mail\DefaultMail;
use App\Models\Dishes;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;


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


    /*
     *
     */
    public function placeOrder()
    {

        $data = request()->all();

        $client = new Client();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify',
            [
                'form_params' => [
                    'secret' => env('RECAPTCHA_SECRET_KEY', false),
                    'remoteip' => request()->getClientIp(),
                    'response' => $data['recaptcha']
                ]
            ]
        );
        $body = json_decode((string)$response->getBody());
        if ($body->success) {

            $user = User::find($data['user_id']);
            $dish = Dishes::find($data['dish_id']);

            $msg = 'Nieuwe bestelling!<Br/><Br/>';
            $tot = $data['amount'] * $dish['price'];
            $msg .= 'Je hebt besteld: <strong>' . $dish['name'] . '</strong> (' . $data['amount'] . ' porties, &euro; ' . $tot . '). Chef ' . $user['name'] . ' neemt snel contact met je op!<br/>';
            foreach ($data as $key => $value) {
                if (in_array($key, ['csrf', 'token', 'dish_id', 'recaptcha', 'user_id'])) continue;

                $msg .= '<p><strong>' . ucfirst(Str::camel($key)) . '</strong><br/>' . $value . '</p>';
            }
            $dataMail = [
                'order' => $data,
                'dish' => $dish,
                'msg' => $msg
            ];
            Mail::send(new DefaultMail($dataMail));
            return [true];
        } else {
            return [false];
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function randomDish()
    {
        //
        $dis = Dishes::select()
            ->where('active', true)
            ->inRandomOrder()
            ->first();

        $return = [];
        if (!empty($dis)) {
            $return = User::find($dis->user_id);
            $return['dish'] = $dis;
        }

        return $return;

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
            $dish->active = true;
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
    public function storeDish()
    {
        $user = Auth::user();

        //create default dish
        $dish = new Dishes();
        $dish->user_id = $user->id;
        $dish->price = 2.50;
        $dish->active = false;
        $dish->save();

        return $dish;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showDish($id)
    {
        $user = Auth::user();
        $dish = Dishes::where('user_id', $user->id)->where('id', $id)->first();
        return $dish;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myDishes()
    {
        $user = Auth::user();
        $dishes = Dishes::where('user_id', $user->id)->orderBy('id', 'desc')->get();

        return $dishes;
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
            $putData['price'] = round($putData['price'], 2);
        }

        if (isset($putData['toggle_state'])) {

            unset($putData['toggle_state']);
            if ($dish->active) {
                $dish->active = false;
                $user->active_dish_id = null;
            } else {
                Dishes::where('user_id', $user->id)
                    ->update(['active' => false]);

                $dish->active = true;
                $user->active_dish_id = $dish->id;
            }

        }

        foreach ($putData as $key => $val) {
            $dish->{$key} = $val;
        }


        $dish->save();
        $user->save();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveDishImage($id, $imagenr, Request $request)
    {
        $user = Auth::user();

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

        $this->validate($request, [
            'file' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        // Get file from request
        $file = $request->file('file');

        // Get filename with extension
        $filenameWithExt = $file->getClientOriginalName();

        // Get file path
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        // Remove unwanted characters
        $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
        $filename = preg_replace("/\s+/", '-', $filename);

        // Get the original image extension
        $extension = $file->getClientOriginalExtension();

        // Create unique file name
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;

        // Refer image to method resizeImage
        $image = $this->resizeImage($file, $fileNameToStore, 'dishes');

        $imagerec = 'image' . $imagenr;
        $dish->{$imagerec} = asset('images/dishes/' . $fileNameToStore);
        $dish->save();

        return asset('images/dishes/' . $fileNameToStore);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveAvatarImage(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'file' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        // Get file from request
        $file = $request->file('file');

        // Get filename with extension
        $filenameWithExt = $file->getClientOriginalName();

        // Get file path
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        // Remove unwanted characters
        $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
        $filename = preg_replace("/\s+/", '-', $filename);

        // Get the original image extension
        $extension = $file->getClientOriginalExtension();

        // Create unique file name
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;

        // Refer image to method resizeImage
        $image = $this->resizeImage($file, $fileNameToStore, 'chefs');

        $user->avatar = asset('images/chefs/' . $fileNameToStore);
        $user->save();

        return asset('images/chefs/' . $fileNameToStore);

    }

    /**
     * Resizes a image using the InterventionImage package.
     *
     * @param object $file
     * @param string $fileNameToStore
     * @return bool
     * @author Niklas Fandrich
     */
    public function resizeImage($file, $fileNameToStore, $dir)
    {
        // Resize image
        $resize = Image::make($file)->fit(400, 400, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg');

        // Create hash value
        $hash = md5($resize->__toString());

        // Prepare qualified image name
        $image = $hash . "jpg";

        if (!is_dir(storage_path("app/public/{$dir}"))) {
            mkdir(storage_path("app/public/{$dir}"));
        }

        // Put image to storage
        $save = file_put_contents(storage_path("app/public/{$dir}/{$fileNameToStore}"), $resize->__toString());

        if ($save) {
            return $image;
        }
        return false;
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
