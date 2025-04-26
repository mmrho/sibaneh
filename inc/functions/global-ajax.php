<?php
function getAllGradesCallback()
{
    check_ajax_referer('wbs_check_nonce', 'security');
    $s = sanitize_text_field(esc_sql($_POST['q']));

    $academicGrade = new AcademicGrade();
    $data = [
        'where' => 'title LIKE "%' . $s . '%"'
    ];
    $getResult = $academicGrade->getRows($data);

    $items = [];
    if (!empty($getResult)) {
        foreach ($getResult as $row) {
            $items[] = [$row->id, $row->title];
        }
    }
    wp_die(json_encode($items));
}

add_action('wp_ajax_getAllGrades', 'getAllGradesCallback');
add_action('wp_ajax_nopriv_getAllGrades', 'getAllGradesCallback');

function getAllBranchesCallback()
{
    check_ajax_referer('wbs_check_nonce', 'security');
    $s = sanitize_text_field(esc_sql($_POST['q']));

    $wbsBranch = new Branch();
    $data = [
        'where' => 'title LIKE "%' . $s . '%"'
    ];
    $getResult = $wbsBranch->getRows($data);

    $items = [];
    if (!empty($getResult)) {
        foreach ($getResult as $row) {
            $items[] = [$row->id, $row->title];
        }
    }
    wp_die(json_encode($items));
}

add_action('wp_ajax_getAllBranches', 'getAllBranchesCallback');
add_action('wp_ajax_nopriv_getAllBranches', 'getAllBranchesCallback');

function getAllFOSCallback()
{
    check_ajax_referer('wbs_check_nonce', 'security');
    $gradeID = (int)sanitize_text_field(esc_sql($_POST['customParams']['grade_id']));
    $s = sanitize_text_field(esc_sql($_POST['q']));

    $academicFOS = new AcademicFOS();
    $data = [
        'where' => 'grade_id = ' . $gradeID . ' AND title LIKE "%' . $s . '%"'
    ];
    $getResult = $academicFOS->getRows($data);

    $items = [];
    if (!empty($getResult)) {
        foreach ($getResult as $row) {
            $items[] = [$row->id, $row->title];
        }
    }
    wp_die(json_encode($items));
}

add_action('wp_ajax_getAllFOS', 'getAllFOSCallback');
add_action('wp_ajax_nopriv_getAllFOS', 'getAllFOSCallback');
