<tr data-id="<?= $item['id'] ?>">

    <td><?= $item['id'] ?></td>
    <td><?= $item['title'] ?></td>
    <td>
        <?if($item['classify']==1){
            echo '常見問題';
        }elseif($item['classify']==2){
            echo '付款方式';
        }elseif($item['classify']==3){
            echo '退換貨';
        }elseif($item['classify']==4){
            echo '其他';
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


    <td><?= $item['create_date'] ?></td>
    <td>

        <button class="btn btn-primary btn-xs edit-btn" data-toggle="tooltip" data-original-title="編輯"><span class="fa fa-fw ti-pencil"></span></button>

        <button class="btn btn-danger btn-xs del-btn" data-toggle="tooltip" data-original-title="刪除"><span class="fa fa-fw fa-minus-square-o"></span></button>
    </td>
</tr>