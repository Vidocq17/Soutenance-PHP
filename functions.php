<?php



// Creation fonction not_empty pour vérifier le formulaire 
if(!defined('not_empty')){
    function not_empty($fields = []) {
        if(count($fields) != 0) {
            foreach($fields as $field) {
                if(empty($_POST[$field])){
                    return false;
                }
            }
            return true;
        }
    }
}

if(!defined('is_already_in_use')){
    function is_already_in_use($field,$value,$table) {
        global $connection;

        $query = $connection->prepare("SELECT user_id FROM $table WHERE $field = ?");
        $query -> execute($value);

       // $count = $query->rowCount();

        //$query -> closeCursor();

        // return $count;
    } 
}


?>