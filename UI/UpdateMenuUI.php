<?php
    class UpdateMenuUI{
    public function showUI() {
        include('../UI/UpdateMenu.php');
    }
    }

    $umui = new UpdateMenuUI();
    $umui->showUI();

?>