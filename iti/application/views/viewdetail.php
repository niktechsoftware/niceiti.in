<div class="row">
	
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-heading panel-blue border-light">
				<h4 class="panel-title">Day Book Account</h4>
			</div>
			<div class="panel-body">
				<?php $dt1=date("d-m-Y",strtotime($dt1));?>
				<?php $dt2=date("d-m-Y",strtotime($dt2));
				$fields1 = $this->db->list_fields('one_time_fee');
				$fields = $this->db->list_fields('fee_deposit');
				
				?>
           <div class="row">
           	<div class="col-md-12"> 
           	<?php $start_date = date('Y-m-d', strtotime($dt1));
			$end_date =  date('Y-m-d', strtotime($dt2));
			$fieldName= array();
			$fieldAmount= array();
			$arc=1;?>
           	<div class = "center"><strong><h2 style="color: green"> Record From Date <?php echo $dt1;?> to <?php echo $dt2;?></h2></strong></div>
            	<table class="table table-striped table-hover" id="sample-table-2">
						<thead>
		                	<tr>
		                    	<th>#</th>
		                    	<th>Date</th>
		                    	<?php foreach($fields1 as $field):
                                                    if($field != "id" && $field != "student_id" && $field != "diposit_date" && $field != "finance_start_date" && $field != "Total_Admission_Fee" && $field != "Admission_Form_Fee"):
                                                    ?>
                                                       <?php  $fieldName[$arc]= $field;    ?>
                                                    <?php
                                                 $arc++;   endif;
                                                endforeach;
?>
<?php foreach($fields as $field):
if($field != "id" && $field != "student_id" && $field != "diposit_date" && $field != "finance_start_date" && $field != "Others_Fee" && $field != "other_fee_reason" && $field != "payment_mode"  && $field != "previous_balance"  && $field != "total"  && $field != "paid"  && $field != "current_balance" && $field != "sub_total"  && $field != "diposit_month"  && $field != "till_diposit" && $field != "invoice_no"):
                                                    ?>
                                                      <?php $fieldName[$arc]= $field;  ?>
                                                    <?php
                                                    $arc++; endif;
                                                endforeach;
                                                for($cp=1;$cp<$arc;$cp++){
                                                    ?><td><?php echo $fieldName[$cp];?></td>
                                                <?php }?>
                                          <th>Total</th>
		                    </tr>
                                   </thead>  
									<tbody>
<?php 

$day = 86400; // Day in seconds
$format = 'Y-m-d'; // Output format (see PHP date funciton)
$sTime = strtotime($start_date); // Start as time
$eTime = strtotime($end_date); // End as time
$numDays = round(($eTime - $sTime) / $day) + 1;
$days = array();


for ($d = 0; $d < $numDays; $d++) {
    $cuDate =  date($format, ($sTime + ($d * $day)));
    $hy=$d+1;
    ?><tr>
    <td><?php echo $hy;?></td>
    <td>
	<?php echo $cuDate;?> 
	</td>
    <?php 
    $tot=0;
    for($jt=1;$jt<$arc;$jt++){
        if($jt<4){?>
            <td><?php $query = $this->db->query("select SUM(`".$fieldName[$jt]."`) as row from one_time_fee WHERE diposit_date = '".$cuDate."'")->row();
            if($query->row!=NULL){$tot = $tot +$query->row; echo $query->row; }else{echo "0";}?></td>
      <?php   }else{?>
          <td><?php 
          $queryString = "select SUM(`".$fieldName[$jt]."`) as row1 from fee_deposit WHERE diposit_date = '".$cuDate."'";
         
          $query = $this->db->query($queryString)->row();
          if($query->row1!=NULL){$tot = $tot +$query->row1; echo $query->row1; }else{echo "0";}?></td>
   <?php    }
?>

<?php }?>
<td><?php echo $tot;?></td>
</tr>
<?php 
}
?>
									</tbody>
							</table>
            	</div>
            	</div>
           	</div>
      	</div>
  	</div>
</div>
      
     


			