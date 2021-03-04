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
            if ($item['content'] != "") {
                    echo $item['content'];
            }
        ?>
    </td>


    <td><?= $item['create_date'] ?></td>
    <td>
        <button onclick="location.href='<?= base_url() . "mgr/home/down/edit/" . $item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw ti-pencil"></span></button>

        <button id="del_<?= $item['id'] ?>" class="btn btn-danger btn-xs del-btn"><span class="fa fa-fw fa-minus-square-o"></span></button>
    </td>
</tr>