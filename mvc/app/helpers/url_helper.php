<?php
    // redirecionamento
    function redirect($location){
        header('location: ' . URLROOT . '/' . $location);
    }
?>