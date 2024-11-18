<?php
    session_start();

    include("include/label.php");
    include("include/functions.php");
    include("include/validation.php"); 
    
    $obj = new Core_Functions();
    $valid = new validation();

    $project_title = "";
    $project_title = $obj->getProjectTitle();

    $view_action = $obj->encode_decode('encrypt', 'View'); $add_action = $obj->encode_decode('encrypt', 'Add');
    $edit_action = $obj->encode_decode('encrypt', 'Edit'); $delete_action = $obj->encode_decode('encrypt', 'Delete');
?>