<tr data-id="<?= $item['id'] ?>">
    <td><?= $item['id'] ?></td>
    <td>
        <?
            if ($item['email'] != "") {
                    echo $item['email'];
            }
        ?>
    </td>

    <td><?= $item['name'] ?><br>
        <?= $item['phone'] ?><br>
        <?= $item['birthday'] ?><br>
    </td>


    <td>
        <?if( $item['status']=='normal'){?>
        <span class="label" style="background-color: #75A8FE">正常</span>
        <?}elseif( $item['status'] =='closed'){?>
        <span class="label" style="background-color: #F29191">封鎖</span>
        <?}?>
    </td>

    <td><?= $item['register_date'] ?></td>
    <td>
        <button onclick="location.href='<?= base_url() . "mgr/user/edit/" . $item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw ti-pencil"></span></button>


        <button id="del_<?= $item['id'] ?>" class="btn btn-danger btn-xs del-btn"><span class="fa fa-fw fa-minus-square-o"></span></button>

    </td>
</tr>