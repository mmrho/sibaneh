<?php
function ui_new_role()
{
    add_role(
        'teacher',
        'مدرس',
        array(
            'read' => true,
            'delete_posts' => false
        )
    );

    add_role(
        'student',
        'دانش آموز',
        array(
            'read' => true,
            'delete_posts' => false
        )
    );

    add_role(
        'counseling',
        'مشاور',
        array(
            'read' => true,
            'delete_posts' => false
        )
    );
}

add_action('admin_init', 'ui_new_role');
