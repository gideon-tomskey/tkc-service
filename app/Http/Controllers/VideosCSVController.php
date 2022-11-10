<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideosCSVController extends Controller
{
    public function convert()
    {
        $cars = [];

        //Get the latest CSV File
        $files = scandir(storage_path() . "/app/videos/", SCANDIR_SORT_DESCENDING);

        $videos = [];
        $videos["brands"] = [];

        foreach ($files as $key => $file) {
            if(!str_contains($file, ':Zone.Identifier')
                && '.' !== $file
                && '..' !== $file
                && '.gitignore' !== $file){
                if (($open = fopen(storage_path() . "/app/videos/" . $file, "r")) !== FALSE) {
                    $row = 0;
                    $make = null;
                    $model = null;
                    $brand = [];
                    while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                        if( $row == 0 ) {
                            $make = strtolower($data[0]);
                            $brand[$make] = [];
                            $brand[$make]["brand"] = strtolower($make);
                        }
                        if( $row == 3 ) {
                            $brand[$make]["video_title"] = $data[0];
                            $brand[$make]["video_url"] = $data[2];
                            $brand[$make]["instructions"] = [];
                            $brand[$make]["models"] = [];
                        }
                        if( $row > 5 && $data[1] !== "" ) {

                            if( $model !== $data[0] && $data[0] !== "" )
                            {
                                $model = $data[0];
                                $brand[$make]["models"][$model] = [];
                                $brand[$make]["models"][$model]["model"] = $model;
                                $brand[$make]["models"][$model]["instructions"] = [];
                                $brand[$make]["models"][$model]["collections"] = [];
                            }

                            if( $model == $data )
                            
                            $new_model = [];
                            $new_model["collection"] = $data[1];
                            $new_model["url"] = $data[3];
                            $new_model["title"] = $data[2];

                            $brand[$make]["models"][$model]["collections"][] = $new_model;
                        }

                        $row++;
                    }

                    $videos["brands"][] = $brand[$make];

                    fclose($open);
                }
            }
        }

        foreach ($videos["brands"] as $key => $brand) {
            $videos["brands"][$key]["models"] = array_values($videos["brands"][$key]["models"]);
        }

        //Check if File Exists
        

        // $brands = [];
        
        // //Loop through rows
        // for ($i=1; $i < count($cars); $i++) {

        //     //Getting Vehicle Make
        //     $brandname = trim(strtolower($cars[$i][0]));

        //     //Check if Brand Name Exists
        //     if( !array_key_exists($brandname, $brands) ) {
        //         $brands[$brandname] = [];
        //         $brands[$brandname]["value"] = $brandname;
        //         $brands[$brandname]["label"] = $cars[$i][0];
        //         $brands[$brandname]["models"] = [];
        //     }

        //     $modelname = trim(strtolower($cars[$i][1]));

        //     //Check if Model Name Exists
        //     if( !array_key_exists($modelname, $brands[$brandname]["models"]) ) {
        //         $brands[$brandname]["models"][$modelname] = [];
        //         $brands[$brandname]["models"][$modelname]["value"] = $modelname;
        //         $brands[$brandname]["models"][$modelname]["label"] = $cars[$i][1];
        //         $brands[$brandname]["models"][$modelname]["years"] = [];
        //     }

        //     $label = "";

        //     if ($cars[$i][4] !== "")
        //     {
        //         $label = "-" . str_replace(" ", "-", strtolower($cars[$i][4]));
        //     }

        //     $year_assoc = strtolower($cars[$i][2]) . "-" . strtolower($cars[$i][3]) . $label;

        //     $brands[$brandname]["models"][$modelname]["years"][$year_assoc] = [];

        //     $brands[$brandname]["models"][$modelname]["years"][$year_assoc]["name"] = $cars[$i][2] . "-" . $cars[$i][3] . ($cars[$i][4] == "" ? "" : " <b>" . $cars[$i][4] . "</b>");
        //     $brands[$brandname]["models"][$modelname]["years"][$year_assoc]["url"] = $cars[$i][5];
        // }
        // $brands = array_values($brands);

        // foreach ($brands as $key1 => $brand) {
        //     $brands[$key1]["models"] = array_values($brands[$key1]["models"]);

        //     foreach ($brands[$key1]["models"] as $key2 => $model) {
        //         $brands[$key1]["models"][$key2]["years"] = array_values($brands[$key1]["models"][$key2]["years"]);
        //     }
        // }

        return response()->json($videos, 200, [], JSON_PRETTY_PRINT);
    }
}
