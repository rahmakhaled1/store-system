<?php

namespace App\Traits;

trait ResponseTrait
{
    public function dataSuccess($data, $message)
    {
        return response()->json([
            "status" => true,
            "message" => $message,
            "data" => $data
        ],200);
    }

    public function dataFail($message)
    {
        return response()->json([
            "status" => false,
            "message" => $message,
        ],401);
    }

}
