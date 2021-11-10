<?php
    $columns_counter = $status_order = 0;
    $columns = [];
?>

<table width="100%">
    <thead>
        <tr>
            <?php foreach($cfg as $section): ?>
            <th  bgcolor="<?php echo $section->color ?>">
                <h3><?php echo $section->label ?></h3>
            </th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
    <?php foreach($evaluations as $evaluation){ 
        foreach ($cfg as $section){ ?>-
        <td>
            <?php echo $section->getValue($evaluation) ?>
        </td>
        <?php }} ?>
    </tbody>
</table>