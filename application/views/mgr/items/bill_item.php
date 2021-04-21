<tr data-id="<?= $item['id'] ?>">
    <td><?= $item['order_no'] ?></td>

    <td><?= $item['username'] . "<br>" . $item['email'] . "<br>" . $item['phone'] ?></td>
    <td>
        <? foreach($products as $p){
            echo "#".$p['name']." x ".$p['quantity']." $".$p['sale_price']*$p['quantity']."<br>";
        }?>
    </td>
    <td>
        <?if( $item['payment']=='credit'){?>
        <span class="label" style="background-color: #75A8FE">信用卡一次付清</span>
        <?}elseif( $item['payment'] =='credit_3'){?>
        <span class="label" style="background-color: green">信用卡分三期</span>
        <?}elseif( $item['payment'] =='atm'){?>
        <span class="label" style="background-color: brown">銀行轉帳</span>
        <?}?>
    </td>
    <td>
        <?if( $item['status']=='paid'){?>
        <span class="label" style="background-color: #75A8FE">已付款</span>
        <?}elseif( $item['status'] =='pending'){?>
        <span class="label" style="background-color: #F29191">處理中</span>
        <?}elseif( $item['status'] =='cancel'){?>
        <span class="label" style="background-color: brown">已取消</span>
        <?}?>
    </td>

    <td>
        <?if( $item['delivery_status']==0){?>
        宅配
        <?}elseif( $item['delivery_status']==1){?>
        超取
        <?}?>
    </td>

    <td><?= $item['amount'] ?></td>
    <td>
        <?if( $item['delivery_success']==0){?>
        未出貨
        <?}else{?>
        已出貨
        <?}?>
    </td>

    <td><?= $item['create_date'] ?></td>
    <td>

        <button class="btn btn-primary btn-xs edit-btn" data-toggle="tooltip" data-original-title="編輯"><span class="fa fa-fw ti-pencil"></span></button>

        <button class="btn btn-danger btn-xs del-btn" data-toggle="tooltip" data-original-title="刪除"><span class="fa fa-fw fa-minus-square-o"></span></button>
    </td>
</tr>