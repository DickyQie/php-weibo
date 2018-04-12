<div class="showPage">
    <?php
        $page = new page($total, $showrow, $curpage, $url, 2);
        echo $page->myde_write();
    ?>
    <div class="cl"></div>
</div>
