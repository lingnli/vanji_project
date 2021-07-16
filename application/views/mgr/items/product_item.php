<tr data-id="<?= $item['id'] ?>">
    <!-- <td><?= $item['id'] ?></td> -->
    <td>
        <div class="input-group" id="sortarea_<?= $item['id'] ?>">
            <? if ($item['sort'] == 1) : ?>
                <span class="input-group-addon" style="color: #CCC; cursor: not-allowed;">▲</span>
            <? else : ?>
                <span class="input-group-addon sort_up">▲</span>
            <? endif; ?>
            <input type="hidden" id="sort_<?= $item['id'] ?>" value="<?= $item['sort'] ?>">
            <!-- <select class="form-control select2">
                <?
                for ($index = 1; $index <= $total; $index++) {
                    echo '<option value="' . $index . '"';
                    if ($index == $item['sort']) {
                        echo ' selected';
                    }
                    echo '>' . $index . '</option>';
                }
                ?>
            </select> -->
            <input class="form-control" disabled type="text" value="<?= $item['sort'] ?>">
            <? if ($item['sort'] == $total) : ?>
                <span class="input-group-addon" style="color: #CCC; cursor: not-allowed;">▼</span>
            <? else : ?>
                <span class="input-group-addon sort_down">▼</span>
            <? endif; ?>
        </div>
    </td>

    <td>
        <!-- 多張照片上傳 -->
        <?
        if ($item['images'] != "") {
            $images = unserialize($item['images']);
            foreach ($images as $c) {
                echo '<img src="' . base_url() . $c . '" style="width:100px; margin:2px 0; display:inline;" class="thumbnail"><br>';
                break; //只上傳第一張後打斷
            }
        }
        ?>
    </td>

    <td>
        <?
        if ($item['name'] != "") {
            echo $item['name'];
        }
        ?>
    </td>

    <td>
        <?
        if ($item['classify'] != "") {
            echo $item['classify'];
        }
        ?>
    </td>

    <td>
        <?
        if ($item['price'] != "") {
            echo '$' . $item['price'] . ' / $' . $item['sale_price'];
        }
        ?>
    </td>


    <td>
        <?
        if ($item['is_index'] == 0) {
            echo '無';
        } elseif ($item['is_index'] == 1) {
            echo '精選商品';
        } elseif ($item['is_index'] == 2) {
            echo '主打商品';
        }
        ?>
    </td>

    <td>
        <?
        if ($item['number'] != "") {
            echo $item['number'];
        }
        ?>
    </td>

    <td><?= $item['create_date'] ?></td>
    <td>
        <button onclick="location.href='<?= base_url() . "mgr/product/edit/" . $item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw ti-pencil"></span></button>

        <button id="del_<?= $item['id'] ?>" class="btn btn-danger btn-xs del-btn"><span class="fa fa-fw fa-minus-square-o"></span></button>

    </td>
</tr>