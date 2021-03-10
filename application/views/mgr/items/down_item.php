<tr data-id="<?= $item['id'] ?>">
    <td>
        <?
            if ($item['speaker'] != "") {
                    echo $item['speaker'];
            }
        ?>
    </td>

    <td>
        <?
            if ($item['cover'] != "") {
                echo '<a data-fancybox="cover_'.$item['id'].'" href="'.base_url().$item['cover'].'"><img src="'.base_url().$item['cover'].'" style="width:300px"></a>';
            }
        ?>
    </td>
    <td>
        <?
            if ($item['content'] != "") {
                    echo $item['content'];
            }
        ?>
    </td>


    <td><?= $item['create_date'] ?></td>
    <td>
        <button onclick="location.href='<?= base_url() . "mgr/home/down/edit/" . $item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw ti-pencil"></span></button>

<?if($item['id']!=1):?>     
        <button id="del_<?= $item['id'] ?>" class="btn btn-danger btn-xs del-btn"><span class="fa fa-fw fa-minus-square-o"></span></button>
        <?endif;?>
    </td>
</tr>