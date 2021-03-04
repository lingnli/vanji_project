<!-- 文章總攬tmeplate -->

<tr data-id="<?= $item['id'] ?>">
    <td><?= $item['id'] ?></td>
    <td><?= $item['news_name'] ?></td>

    <td><?= $item['name'] ?><br><?= $item['email'] ?></td>

    <td>內容：
    
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

    <td>
        <?if($item['is_show']!=1){?>
        <span class="btn btn-warning">不顯示</span>
        <?}else{?>
        <span class="btn btn-success">顯示</span>
        <?}?>
    </td>

    <td><?= $item['create_date'] ?></td>
    <td>
        <button onclick="location.href='<?= base_url() . "mgr/comment/news/edit/" . $item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw ti-pencil"></span></button>

        <button id="del_<?= $item['id'] ?>" class="btn btn-danger btn-xs del-btn"><span class="fa fa-fw fa-minus-square-o"></span></button>
    </td>
</tr>