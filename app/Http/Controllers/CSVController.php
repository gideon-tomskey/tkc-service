<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CSVController extends Controller
{
    public function make_csv_form() {
        return view('make-csv-form');
    }

    public function convert(Request $request)
    {
        $file = $request->file('file');

        $cars = [];

        //Get the latest CSV File
        $files = scandir(storage_path() . "/app/public/", SCANDIR_SORT_DESCENDING);
        $recent_file = null;
        $cnt =  count($files) - 1;

        while ($recent_file === null) {
            $ext = pathinfo($files[$cnt], PATHINFO_EXTENSION);
            if(!str_contains($files[$cnt], ':Zone.Identifier')
                && '.' !== $files[$cnt]
                && '..' !== $files[$cnt]
                && '.gitignore' !== $files[$cnt]){
                $recent_file = $files[$cnt];
            }
            $cnt--;
        }


        //Check if File Exists
        if (($open = fopen($file, "r")) !== FALSE) {

            while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                $cars[] = $data;
            }

            fclose($open);
        }

        // while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
        //     $cars[] = $data;
        // }

        $brands = [];
        
        //Loop through rows
        for ($i=1; $i < count($cars); $i++) {

            //Getting Vehicle Make
            $brandname = trim(strtolower($cars[$i][0]));

            //Check if Brand Name Exists
            if( !array_key_exists($brandname, $brands) ) {
                $brands[$brandname] = [];
                $brands[$brandname]["value"] = $brandname;
                $brands[$brandname]["label"] = $cars[$i][0];
                $brands[$brandname]["models"] = [];
            }

            $modelname = trim(strtolower($cars[$i][1]));

            //Check if Model Name Exists
            if( !array_key_exists($modelname, $brands[$brandname]["models"]) ) {
                $brands[$brandname]["models"][$modelname] = [];
                $brands[$brandname]["models"][$modelname]["value"] = $modelname;
                $brands[$brandname]["models"][$modelname]["label"] = $cars[$i][1];
                $brands[$brandname]["models"][$modelname]["years"] = [];
            }

            $label = "";

            if ($cars[$i][4] !== "")
            {
                $label = "-" . str_replace(" ", "-", strtolower($cars[$i][4]));
            }

            $year_assoc = strtolower($cars[$i][2]) . "-" . strtolower($cars[$i][3]) . $label;

            $brands[$brandname]["models"][$modelname]["years"][$year_assoc] = [];

            $brands[$brandname]["models"][$modelname]["years"][$year_assoc]["name"] = $cars[$i][2] . "-" . $cars[$i][3] . ($cars[$i][4] == "" ? "" : " <b>" . $cars[$i][4] . "</b>");
            $brands[$brandname]["models"][$modelname]["years"][$year_assoc]["url"] = $cars[$i][5];
            $brands[$brandname]["models"][$modelname]["years"][$year_assoc]["is_redirect"] = $cars[$i][6] == "Redirect";
        }
        $brands = array_values($brands);

        foreach ($brands as $key1 => $brand) {
            $brands[$key1]["models"] = array_values($brands[$key1]["models"]);

            foreach ($brands[$key1]["models"] as $key2 => $model) {
                $brands[$key1]["models"][$key2]["years"] = array_values($brands[$key1]["models"][$key2]["years"]);
            }
        }

        return response()->json($brands, 200, [], JSON_PRETTY_PRINT);
    }
}
