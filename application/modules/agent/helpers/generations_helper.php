<?php
if(!function_exists("getGenerationList")){
    function getGenerationList($params = array()){
        $generaciones = array(
            "generacion_1" => array(
                "title" => getGeneracionTitleByID("generacion_1"),
            ),
            "generacion_2" => array(
                "title" => getGeneracionTitleByID("generacion_2"),
            ),
            "generacion_3" => array(
                "title" => getGeneracionTitleByID("generacion_3"),
            ),
            "generacion_4" => array(
                "title" => getGeneracionTitleByID("generacion_4"),
            ),
            "consolidado" => array(
                "title" => getGeneracionTitleByID("consolidado"),
            )
        );

        foreach ($params as $param) {
            foreach ($generaciones as $key => $generacion) {
                $generaciones[$key][$param] = 0;
            }
        }

        return $generaciones;
    }
}

if(!function_exists("getGenerationDropDown")){
    function getGenerationDropDown($label = "Todas las Generaciones"){
        $list = getGenerationList();
        $dropdown = array(
            "" => $label,
        );
        foreach ($list as $key => $value) {
            if(isset($value["title"]))
                $dropdown[$key] = $value["title"];
        }

        return $dropdown;
    }
}

if(!function_exists("getGeneracionByConnection")){
    function getGeneracionByConnection($connection_date, $comparation_date = ""){
        //Set comparation date
        if(empty($comparation_date))
            $comparation_date = new Datetime();
        else
            $comparation_date = date_create($comparation_date);

        //Validation of connection date
        if(empty($connection_date) || $connection_date == "0000-00-00")
            $connection_date = date("Y-m-d");

        $CI =& get_instance();
        $CI->load->helper('date');

        $connection = date_create($connection_date);
        $connection = lastDayOf("quarter", $connection);
        $connection->modify("+1 day");
        $connection_years = $comparation_date->diff($connection)->y;
        switch ($connection_years) {
            case 0:
                $index = "generacion_1";
                break;
            case 1:
                $index = "generacion_2";
                break;
            case 2:
                $index = "generacion_3";
                break;
            case 3:
                $index = "generacion_4";
                break;
            default:
                $index = "consolidado";
                break;
        }
        return $index;
    }
}

if(!function_exists("getGeneracionTitleByID")){
    function getGeneracionTitleByID($generation_id){
        switch ($generation_id) {
            case "generacion_2":
                $title = "Generación 2";
                break;
            case "generacion_3":
                $title = "Generación 3";
                break;
            case "generacion_4":
                $title = "Generación 4";
                break;
            case "consolidado":
                $title = "Consolidado";
                break;
            default:
                $title = "Generación 1";
                break;
        }
        return $title;
    }
}

if(!function_exists("getGeneracionDateRange")){
    /**
     * @param string $generation_id El id de la generacion
     * @param string $comparation_date Una fecha de comparacion
     * @param bool $is_vida Saber si se trata de vida o de GMM
     * @return array
     */
    function getGeneracionDateRange($generation_id, $comparation_date = "", $is_vida){
        //Set comparation date
        if(empty($comparation_date))
            $comparation_date = new Datetime();
        else
            $comparation_date = date_create($comparation_date);

        $CI =& get_instance();
        $CI->load->helper('date');

        $comparation_date = firstDayOf("month", $comparation_date);
        log_message('debug', 'comparition_date of quarter: ' . $comparation_date->format('Y-m-d'));

        // $init_date  and $end_date are going to be the first day of the current date's month
        $init_date = clone $comparation_date;
        $end_date = clone $comparation_date;

        if ($is_vida) {
            switch ($generation_id) {
                case 'generacion_1':
                    $init_date->modify("-3 month");
                    break;
                case 'generacion_2':
                    $init_date->modify("-6 month");
                    $end_date->modify("-3 month");
                    break;
                case 'generacion_3':
                    $init_date->modify("-9 month");
                    $end_date->modify("-6 month");
                    break;
                case 'generacion_4':
                    $init_date->modify("-12 month");
                    $end_date->modify("-9 month");
                    break;
                case 'consolidado':
                    $today = new Datetime();
                    $init_date = $today->modify("-1 year");
                    break;
                default:
                    $init_date = NULL;
                    $end_date->modify("-12 month");
                    break;
            }
        } else { //Se trata de GMM
            switch ($generation_id) {
                case 'generacion_1':
                    $init_date->modify("-4 month");
                    break;
                case 'generacion_2':
                    $init_date->modify("-8 month");
                    $end_date->modify("-4 month");
                    break;
                case 'generacion_3':
                    $init_date->modify("-12 month");
                    $end_date->modify("-8 month");
                    break;
                case 'consolidado':
                    $today = new Datetime();
                    $init_date = $today->modify("-1 year");
                    break;
                default:
                    $init_date = NULL;
                    $end_date->modify("-12 month");
                    break;
            }
        }
        $return = array(
            "generation" => $generation_id
        );
        if(!is_null($init_date))
            $return["init"] = $init_date->format("Y-m-d");
        $return["end"] = $end_date->format("Y-m-d");
        return $return;
    }
}