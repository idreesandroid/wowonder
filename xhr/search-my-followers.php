<?php 
if ($f == "search-my-followers") {
    $html   = "";
    $data   = array(
        "status" => 404,
        "html" => $wo['lang']['no_result']
    );
    $filter = (isset($_GET['filter'])) ? Wo_Secure($_GET["filter"]) : false;
    if ($filter) {
        $users = Wo_SearchFollowers($wo['user']['id'], $filter, 10, $_GET['event_id']);
        if (count($users) > 0) {
            foreach ($users as $wo['user']) {
                $html .= Wo_LoadPage('events/includes/invitation-users-list');
            }
            $data = array(
                "status" => 200,
                "html" => $html
            );
        }
    }
    header("Content-type: application/json");
    echo json_encode($data);
    exit();
}
