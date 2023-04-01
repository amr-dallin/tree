<?php
$this->layout = 'ajax';
if (!empty($items)) {
    echo $this->Item->itemsPrevious($items);
}
?>