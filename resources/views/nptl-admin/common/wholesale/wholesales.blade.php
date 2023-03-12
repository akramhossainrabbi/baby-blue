<?php
/**
 * Created by PhpStorm.
 * User: NPTL
 * Date: 1/3/18
 * Time: 6:17 PM
 */
if ($all_wholesale)
{
$edit_wholesale = SM::check_this_method_access('wholesales', 'edit') ? 1 : 0;
$wholesale_status_update = SM::check_this_method_access('wholesales', 'wholesale_status_update') ? 1 : 0;
$delete_wholesale = SM::check_this_method_access('wholesales', 'destroy') ? 1 : 0;
$per = $edit_wholesale + $delete_wholesale;
$sl = 1;
foreach ($all_wholesale as $wholesale)
{
?>
<tr id="tr_{{$wholesale->id}}">
    <td><label><input type="checkbox" class="smCheckbox wholesale wholesale{{$wholesale->id}}"
                      value="{{$wholesale->id}}"></label></td>
    <td><?php echo $wholesale->name; ?></td>
    <td class="subscriberemail{{$wholesale->id}}"><?php echo $wholesale->email; ?></td>
    <td><?php echo $wholesale->contact; ?></td>
    <td><?php echo $wholesale->location; ?></td>
    <td><?php echo $wholesale->business; ?></td>
    <td><?php echo $wholesale->business_type; ?></td>
    <td><?php echo $wholesale->category_id; ?></td>
    <?php if ($wholesale_status_update != 0): ?>
    <td class="text-center">
        <select class="form-control change_status"
                route="<?php echo config('constant.smAdminSlug'); ?>/wholesale_status_update"
                post_id="<?php echo $wholesale->id; ?>">
            <option value="1" <?php
                if ($wholesale->status == 1) {
                    echo 'Selected="Selected"';
                }
                ?>>Published
            </option>
            <option value="2" <?php
                if ($wholesale->status == 2) {
                    echo 'Selected="Selected"';
                }
                ?>>Pending
            </option>
            <option value="3" <?php
                if ($wholesale->status == 3) {
                    echo 'Selected="Selected"';
                }
                ?>>Canceled
            </option>
        </select>
    </td>
    <?php endif; ?>
    <?php if ($per != 0): ?>
    <td class="text-center">
        <a href="javascript:void(0)" row="{{$wholesale->id}}"
           title="Send Offer Mail" class="btn btn-xs btn-success showOfferMailPopUpForSingleSubscriber">
            <i class="fa fa-envelope"></i>
        </a>
        <?php if ($edit_wholesale != 0): ?>
        <a style="display: none;" href="<?php echo url(config('constant.smAdminSlug') . '/wholesale'); ?>/<?php echo $wholesale->id; ?>/edit"
           title="Edit" class="btn btn-xs btn-default" id="">
            <i class="fa fa-pencil"></i>
        </a>
        <?php endif; ?>
        <?php if ($delete_wholesale != 0): ?>
        <a href="<?php echo url(config('constant.smAdminSlug') . '/wholesale/destroy'); ?>/<?php echo $wholesale->id; ?>"
           title="Delete" class="btn btn-xs btn-default delete_data_row"
           delete_message="Are you sure to delete this Tag?"
           delete_row="tr_{{$wholesale->id}}">
            <i class="fa fa-times"></i>
        </a>
        <?php endif; ?>
    </td>
    <?php endif; ?>
</tr>
<?php
$sl++;
}
}
?>

