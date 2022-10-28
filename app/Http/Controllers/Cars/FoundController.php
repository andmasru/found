<?php

namespace App\Http\Controllers\Cars;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\FoundResource;
use App\Http\Resources\FoundCollection;
use Illuminate\Support\Facades\Cache;


use App\Http\Resources\CarsResource;
use App\Http\Resources\CarsCollection;


use App\Http\Resources\DriversResource;
use App\Http\Resources\DriversCollection;

use Illuminate\Http\Request;

use App\Models\Cars;

use App\Models\Drivers;

 /**

     * @OA\Get(
     * path="/laravel/public/found/",
     * summary="index",
     * description="index",
     * operationId="index",
     * tags={"index"},
 
     * @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ), 
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

class FoundController extends Controller
{

    public function index()
    {

        return new CarsCollection(Cars::all());
    }


    /**

     * @OA\Get(
     * path="/laravel/public/found/cars",
     * summary="cars",
     * description="cars",
     * operationId="cars",
     * tags={"cars"},
 
     * @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ), 
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

    public function cars() // Все автомобили
    {

        return new CarsCollection(Cars::all());
    }

     /**

     * @OA\Get(
     * path="/laravel/public/found/drivers",
     * summary="drivers",
     * description="drivers",
     * operationId="drivers",
     * tags={"drivers"},
 
     * @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ), 
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

    public function drivers() // Все водители
    {

        return new DriversCollection(Drivers::all());
    }

    /**

     * @OA\Get(
     * path="/laravel/public/found/free",
     * summary="free",
     * description="free",
     * operationId="free",
     * tags={"free"},
 
     * @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ), 
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

    public function free() // Свободные автомобили
    {

        return new CarsCollection(Cars::where('driver', '=', 0)->get());
    }


    /**

     * @OA\Get(
     * path="/laravel/public/found/busy",
     * summary="busy",
     * description="busy",
     * operationId="busy",
     * tags={"busy"},
 
     * @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ), 
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

    public function busy() // Забронированные автомобили
    {

        return new CarsCollection(Cars::where('driver', '!=', 0)->get());
    }

    /**

     * @OA\Get(
     * path="/laravel/public/found/start/{idcar}/{iddriver}",
     * summary="start",
     * description="start",
     * operationId="start",
     * tags={"start"},
     * 
     * @OA\Parameter(
     *          name="idcar",
     *          description="idcar",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *  @OA\Parameter(
     *          name="iddriver",
     *          description="iddriver",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * 
     *   @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ), 
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

    public function start($idcar, $iddriver) // 
    {
        if (Cars::where('id', '=', $idcar)->count()) { // Проверяем, существует ли автомобиль с данным   id

            if (Cars::where('id', '=', $idcar)->first('driver')['driver']) // Проверяем, есть ли бронь у данного автомобиля  

                return 'Отказ! Автомобиль уже забронирован.';

            else {

                if (Cars::where('driver', '=', $iddriver)->count()) // Проверяем количество забронированных авто данным пользователем

                    return 'Отказ! У данного пользователя уже есть забронированный автомобиль.';

                else {

                    if (Drivers::where('id', '=', $iddriver)->count()) { // Проверяем, существует ли данный пользователь

                        Cars::orderByDesc('id')
                            ->where('id', $idcar)
                            ->update(['driver' => $iddriver]);

                        // return 'Успешно! Автомобиль забронирован.';                        
                        return new CarsResource(Cars::where('id', '=', $idcar)->first());

                    } else

                        return 'Отказ! Пользователя с таким id не существует.';
                }
            }
        } else

            return 'Отказ! Автомобиль с данным id не найден.';
    }

   /**

     * @OA\Get(
     * path="/laravel/public/found/stop/{idcar}/{iddriver}",
     * summary="stop",
     * description="stop",
     * operationId="stop",
     * tags={"stop"},
     * 
     * @OA\Parameter(
     *          name="idcar",
     *          description="idcar",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *  @OA\Parameter(
     *          name="iddriver",
     *          description="iddriver",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * 
     *   @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ), 
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function stop($idcar, $iddriver)
    {
        if (Cars::where('id', '=', $idcar)->count()) { // Проверяем, существует ли автомобиль с данным id

            if (Cars::where('id', '=', $idcar)->first('driver')['driver'] == $iddriver) { // Проверяем, что данный автомобиль забронировал данный пользователь

                Cars::orderByDesc('id')
                    ->where('id', $idcar)
                    ->update(['driver' => 0]);

                //return 'Успешно! Бронь завершена';
                return new CarsResource(Cars::where('id', '=', $idcar)->first());

            } else

                return 'Отказ. Данный пользователь не бронировал данный автомобиль.';
        } else

            return 'Отказ! Автомобиль с данным id не найден.';
    }
}
