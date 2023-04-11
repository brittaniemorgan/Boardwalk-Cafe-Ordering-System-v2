<?php
    class UpdateMenuUI{
    public function showUI() {
        include('UpdateMenu.php');
    }
    }

    $umui = new UpdateMenuUI();
    $umui->showUI();

?>