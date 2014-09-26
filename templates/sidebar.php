<?php
    if(is_front_page()){
        dynamic_sidebar('sidebar-primary');
    }else{
        dynamic_sidebar('sidebar-secondary');
    }
?>