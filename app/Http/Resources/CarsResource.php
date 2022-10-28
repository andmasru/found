<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return [
            'id' => $this->id,
            'model' => $this->model,
            'driver' => $this->driver,
            'status' => $this->when($this->driver == '0', function () {
                return 'Автомобиль свободен';
            }, function () {
                return 'Автомобиль   забронирован';
            })
        ];
    }
}
