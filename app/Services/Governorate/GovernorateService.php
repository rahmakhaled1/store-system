<?php

namespace App\Services\Governorate;

use App\Http\Requests\Dashboard\Governorate\GovernorateRequest;
use App\Http\Requests\Dashboard\Governorate\StoreGovernorateRequest;
use App\Http\Requests\Dashboard\Governorate\UpdateGovernorateRequest;
use App\Http\Requests\General\FetchRequest;
use App\Http\Resources\Dashboard\Governorate\GovernorateResource;
use App\Models\Governorate;
use App\Traits\ResponseTrait;

class GovernorateService
{
    use ResponseTrait;
    public function fetch(FetchRequest $request)
    {
        $data = $request->validated();
        try {
            $governorates = Governorate::search($data)->paginate(15);
            if($governorates){
                $message = "Governorate data has been successfully retrieved.";
                return self::dataSuccess(GovernorateResource::collection($governorates), $message);
            } else{
                return self::dataFail("Governorate data could not be retrieved.");
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function store(StoreGovernorateRequest $request)
    {
        $data = $request->validated();
        $governorate = Governorate::create($data);
        try {
            if ($governorate) {
                $message = "The governorate has been successfully stored.";
                return self::dataSuccess(new GovernorateResource($governorate), $message);
            } else {
                return self::dataFail("The governorate could not be stored.");
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function show(GovernorateRequest $request)
    {
        $data = $request->validated();
        $governorate = Governorate::find($data["governorate_id"]);
        try {
            if ($governorate) {
                $message = "Governorate data has been successfully retrieved.";
                return self::dataSuccess(new GovernorateResource($governorate), $message);
            } else {
                return self::dataFail("Governorate data could not be retrieved.");
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function update(UpdateGovernorateRequest $request)
    {
        $data = $request->validated();
        try {
            $governorate = Governorate::find($data["governorate_id"]);
            $governorate->update([
                "name" => $data["name"]
            ]);
            if ($governorate) {
                $message = "The governorate data has been successfully updated.";
                return self::dataSuccess(new GovernorateResource($governorate), $message);
            } else {
                return self::dataFail("The governorate data could not be updated.");
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function delete(GovernorateRequest $request)
    {
        $data = $request->validated();
        try {
            $governorate = Governorate::find($data["governorate_id"]);
            $governorate->delete();
            if ($governorate){
                $message = "The governorate has been successfully deleted.";
                return self::dataSuccess(new GovernorateResource($governorate), $message);
            }else{
                return self::dataFail("The governorate could not be deleted.");
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
}
