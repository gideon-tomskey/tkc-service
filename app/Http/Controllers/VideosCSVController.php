<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CarMakesImport;

class VideosCSVController extends Controller
{
    public function convert()
    {
        $cars = [];

        //Get the latest CSV File
        $files = [];//scandir(storage_path() . "/app/videos/", SCANDIR_SORT_DESCENDING);

        $videos = [];
        $videos["brands"] = [];

        $carMakeImport = Excel::toCollection(new CarMakesImport(), storage_path('/app/videos/make_model_videos.xls'));

        $make = null;
        $model = null;
        $brand = [];
        foreach ($carMakeImport as $key => $carMake) {
            $make = null;
            $model = null;

            $make = strtolower($carMake[0][0]);
            $brand[$make] = [];
            $brand[$make]["brand"] = strtolower($make);

            $brand[$make]["video_title"] = $carMake[3][0];
            $brand[$make]["video_url"] = $carMake[3][2];
            $brand[$make]["instructions"] = [];
            $brand[$make]["models"] = [];


            for ($row=6; $row < count($carMake); $row++) { 
                //start getting the model meta
                if( $carMake[$row][1] !== null && $carMake[$row][1] !== "" ) {

                    //check if there's no empty data and get model meta
                    if( $model !== $carMake[$row][0] && $carMake[$row][0] !== "" && $carMake[$row][0] !== null )
                    {
                        $model = $carMake[$row][0];
                        $brand[$make]["models"][$model] = [];
                        $brand[$make]["models"][$model]["model"] = $model;
                        $brand[$make]["models"][$model]["instructions"] = [];
                        $brand[$make]["models"][$model]["collections"] = [];
                    }
                    
                    $new_model = [];
                    $new_model["collection-name"] =  $carMake[$row][1];
                    $new_model["collection-url"] =  $carMake[$row][2];
                    $new_model["collection-id"] =  round(floatval($carMake[$row][3]),0);
                    $new_model["video-title"] =  $carMake[$row][4];
                    $new_model["video-url"] =  $carMake[$row][5];

                    $brand[$make]["models"][$model]["collections"][] = $new_model;
                }
            }
            $videos["brands"][] = $brand[$make];

        }


        foreach ($videos["brands"] as $key => $brand) {
            $videos["brands"][$key]["models"] = array_values($videos["brands"][$key]["models"]);
        }

        return response()->json($videos, 200, [], JSON_PRETTY_PRINT);
    }
}
