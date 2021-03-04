<tr data-id="<?= $item['id'] ?>">

    <td><?= $item['id'] ?></td>
    <td><?= $item['title'] ?></td>
    <td><?= $item['classify'] ?></td>

    <td>
        <?
            if ($item['cover'] != "") {
                echo '<a data-fancybox="cover_'.$item['id'].'" href="'.base_url().$item['cover'].'"><img src="'.base_url().$item['cover'].'" style="width:150px;"></a>';
            }
        ?>
    </td>




    <td>
        <?
            if (strpos($item['content'], "<img") !== FALSE) {
                echo "<span class='label label-info'>(圖片)</span>";
            }
            if (mb_strlen(strip_tags($item['content'])) > 100) {
                echo mb_substr(strip_tags($item['content']), 0, 100)."...";
            }else{
                echo strip_tags($item['content']);
            }
        ?>
    </td>


    <td><?= $item['date'] ?></td>
    <td>

        <button class="btn btn-primary btn-xs edit-btn" data-toggle="tooltip" data-original-title="編輯"><span class="fa fa-fw ti-pencil"></span></button>

        <button class="btn btn-danger btn-xs del-btn" data-toggle="tooltip" data-original-title="刪除"><span class="fa fa-fw fa-minus-square-o"></span></button>
    </td>
</tr>