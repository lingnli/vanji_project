<tr data-id="<?= $item['id'] ?>">

    <td><?= $item['client_name'] ?></td>
    <td><?= $item['client_birth_date'] ?></td>

    <td>
        <?if( $item['client_gender']=='MALE'){?>
        <span class="label" style="background-color: #75A8FE">男</span>
        <?}elseif( $item['client_gender'] =='FEMALE'){?>
        <span class="label" style="background-color: #F29191">女</span>
        <?}?>
    </td>

    <td><?= $item['client_address'] ?></td>
    <td><?= $item['created_at'] ?></td>
    <td>

        <button class="btn btn-primary btn-xs edit-btn" data-toggle="tooltip" data-original-title="編輯"><span class="fa fa-fw ti-pencil"></span></button>

        <button class="btn btn-danger btn-xs del-btn" data-toggle="tooltip" data-original-title="刪除"><span class="fa fa-fw fa-minus-square-o"></span></button>
    </td>
</tr>