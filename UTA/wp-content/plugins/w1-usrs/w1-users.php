<?php

/** Plugin Name: Custom User ...*/

add_action( 'rest_api_init',function(){
    register_rest_route( 'wl/v1', 'users', array(
        'methods' => 'GET',
        'callback' => 'get_user_info',
    ));
    register_rest_route( 'wl/v1', 'users/(?P<role>[a-zA-Z0-9-]+)', array(
        'methods' => 'GET',
        'callback' => 'get_user_info_by_role',
    ));
});

function get_user_info(){
    $users = get_users(array(
        'orderby' => 'nicename',
        'order' => 'ASC',
    ));
    $data = array();
    foreach($users as $user){
        $data[] = array(
            'id' => $user->ID,
            'name' => $user->display_name,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->user_email,
            'role' => $user->roles[0],
            'dob' => $user->acf['dob'],
            'address' => $user->acf['address'],
        );
        
    }
    return $data;
}
function get_user_info_by_role($slug){
    $users = get_users(array(
        'orderby' => 'nicename',
        'order' => 'ASC',
    ));
    $data = array();
    foreach($users as $user){
        if($user->roles[0] == $slug['role']){
            $data[] = array(
                'id' => $user->ID,
                'name' => $user->display_name,
                'email' => $user->user_email,
                'role' => $user->roles[0],
                'dob' => $user->acf['dob'],
                'address' => $user->acf['address']
            );
        }
    }
    return $data;
}