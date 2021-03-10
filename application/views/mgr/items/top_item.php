<tr data-id="<?= $item['id'] ?>">
    <td>
        <?
            if ($item['title'] != "") {
                    echo $item['title'];
            }
        ?>
    </td>


    <td>
        <?
            if ($item['cover'] != "") {
                echo '<a data-fancybox="cover_'.$item['id'].'" href="'.base_url().$item['cover'].'"><img src="'.base_url().$item['cover'].'" style="width:150px;"></a>';
            }
        ?>
    </td>



    <td><?= $item['edit_date'] ?></td>
    <td>
        <button onclick="location.href='<?= base_url() . "mgr/top/edit/" . $item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw ti-pencil"></span></button>


        <!-- <button id="del_<?= $item['id'] ?>" class="btn btn-danger btn-xs del-btn"><span class="fa fa-fw fa-minus-square-o"></span></button> -->

    </td>
</tr>