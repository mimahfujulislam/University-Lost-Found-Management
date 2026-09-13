<?php
require '../model/Item.php';
require '../model/Claim.php';

function getModeratorDashboardData(){
    $itemModel = new Item();
    $claimModel = new Claim();

    $data = [
        "pending_items" => $itemModel->countByStatus("Pending"),
        "pending_claims" => $claimModel->countByStatus("Pending"),
        "total_items" => $itemModel->countAll(),
        "recently_reviewed" => $itemModel->getRecentlyReviewed(5)
    ];

    return $data;
}
?>

