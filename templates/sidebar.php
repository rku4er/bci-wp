<?php
    if( $post->post_type === 'case_study' ) dynamic_sidebar('sidebar-case-study');
    elseif( $post->post_type === 'job_opportunity' ) dynamic_sidebar('sidebar-job-opportunity');
    else dynamic_sidebar('sidebar-primary');
?>