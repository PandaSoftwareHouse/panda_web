<form method='POST' action="<?php echo site_url('sub_attendance_controller/generate_report')?>">
	<select class="form-control" name="supplier[]" multiple class="chosen-select">
	<option value="Others">Others</option>

	<?php foreach ($supp_array->result() as $row) { ?>

	<option value="<?php echo $row->Name?>"><?php echo $row->Name?></option>

	<?php } ?>

	</select>
	<br>
	<input type="number" name="code">
	<br><br>
	<input type="submit" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
</form>