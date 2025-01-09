<?php

namespace App\Services\Setting;

use App\Http\Requests\Dashboard\General\FetchRequest;
use App\Http\Requests\Dashboard\Setting\SettingRequest;
use App\Http\Requests\Dashboard\Setting\StoreSettingRequest;
use App\Http\Requests\Dashboard\Setting\UpdateSettingRequest;
use App\Http\Resources\Dashboard\Setting\SettingResource;
use App\Models\Setting;
use App\Traits\ResponseTrait;

class SettingService
{
    use ResponseTrait;
    public function fetch()
    {
        try {
            $settings = Setting::paginate(15);
            if($settings){
                $message = "Setting data has been successfully retrieved.";
                return self::dataSuccess(SettingResource::collection($settings), $message);
            } else{
                return self::dataFail("Setting data could not be retrieved.");
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function store(StoreSettingRequest $request)
    {
        $data = $request->validated();
        $Setting = Setting::create($data);
        try {
            if ($Setting) {
                $message = "The Setting has been successfully stored.";
                return self::dataSuccess(new SettingResource($Setting), $message);
            } else {
                return self::dataFail("The Setting could not be stored.");
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function show(SettingRequest $request)
    {
        $data = $request->validated();
        $setting = Setting::find($data["setting_id"]);
        try {
            if ($setting) {
                $message = "Setting data has been successfully retrieved.";
                return self::dataSuccess(new SettingResource($setting), $message);
            } else {
                return self::dataFail("Setting data could not be retrieved.");
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function update(UpdateSettingRequest $request)
    {
        $data = $request->validated();
        try {
            $setting = Setting::find($data["setting_id"]);
            $setting->update([
                "delivery" => $data["delivery"],
                "setting_id" => $data["setting_id"]
            ]);
            if ($setting) {
                $message = "The Setting data has been successfully updated.";
                return self::dataSuccess(new SettingResource($setting), $message);
            } else {
                return self::dataFail("The Setting data could not be updated.");
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function delete(SettingRequest $request)
    {
        $data = $request->validated();
        try {
            $setting = Setting::find($data["setting_id"]);
            $setting->delete();
            if ($setting){
                $message = "The Setting has been successfully deleted.";
                return self::dataSuccess(new SettingResource($setting), $message);
            }else{
                return self::dataFail("The Setting could not be deleted.");
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
}
