<?php
if (!empty($model)) {

?>
<table class="table table-striped  table-condensed table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Task</th>
            <th>Task Status</th>
            <th>Reason for Incomplete task </th>
            <th>Status comments</th>
         
        </tr>
    </thead>
    <?php
        $srno = 1;

        foreach ($model as $mod) {
            ?>


            <tbody>
                <tr data-key="106">
                    <td data-title="#" style="width: 5%;"><?= $srno ?></td>
                    <td data-title="Task"><?= isset($mod->task)?$mod->task->task_type_name:$mod->task_code ?></td>
                    <td data-title="Task Status"><?= isset($mod->cstatus)?$mod->cstatus->task_status_name:$mod->currernt_status ?></td>
                    <td data-title="Reason for Incomplete task"><?= isset($mod->reasonfit)?$mod->reasonfit->reason_for_Incomplete_task:$mod->reason_for_Incomplete_task ?></td>
                    <td data-title="Status comments" ><?= isset($mod->status_comments)?$mod->status_comments:'' ?></td>
                   

                </tr>

            </tbody>

            <?php
            $srno++;
        }
    
    ?>
</table>
<?php } ?>