<?php if($student->num_rows() > 0): 
	$isData = $this->db->count_all("fee_deposit"); 
	
	if($isData > 0):
?>
		<br/><br/>
		<div class="row">
			<div class="col-md-12 space20">
				<div class="btn-group pull-right">
					<button data-toggle="dropdown" class="btn btn-green dropdown-toggle">
						Export <i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu dropdown-light pull-right">
						<li>
							<a href="#" class="export-excel" data-table="#sample-table-2" >
								Export to Excel
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="table-responsive">
            <div>
                <p class="alert alert-info"> Note : This is the area you can send Fee reminder to send click send sms button . If you send SMS change to Success Message send Successfuly . <br>
			</div>
			<table class="table table-striped table-hover" id="sample-table-2">
				<thead>
					<tr>
						<th>S.no.</th>
						<th>Student Name</th>
						<th>Father Mobile</th>
						<th>Student Id</th>
						<th>Father Name</th>
						<th>Fee line</th>
						<th>Total Paid(Adm+Regu.=Tot)</th>
						<th>Total Deu (Adm+Regu.=Tot)</th>
						<th>Full Detail</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				    $color = array(
					    "progress-bar-danger",
					    "progress-bar-success",
					    "progress-bar-warning",
					    "progress-partition-green",
					    "partition-azure",
					    "partition-blue",
					    "partition-orange",
					    "partition-purple",
					    "progress-bar-danger",
					    "progress-bar-success",
					    "progress-partition-green",
					    "partition-purple"
				    );
				    $count = 1;
				    $tot=0.00;
				    foreach($student->result() as $stuDetail):
				        $stu_id = $stuDetail->enroll_num;
				        $remain = $this->db->query("SELECT total_due from feedue WHERE student_id = '$stu_id'")->row();
				        $total = $this->db->query("SELECT SUM(diposit_month) as totalMonth, SUM(paid) as totalPaid from fee_deposit WHERE student_id = '$stu_id' AND finance_start_date='$fsd'")->row(); ?>
					    <tr>
			  			    <td><?php echo $count;?></td>
			  			    <td><?php echo $stuDetail->name;?>
			  			        <input type = "hidden" id="sname<?php echo $count;?>" value="<?php echo $stuDetail->name;?>"></td>
			  			    </td>
			  			    <td>
			  			        <?php echo $stuDetail->mobile;?>
			  			        <input type = "hidden" id="mnum<?php echo $count;?>" value="<?php echo $stuDetail->mobile;?>">
			  			    </td>
			  			    <td>
			  			        <?php echo $stu_id;?>
			  			    </td>
			  			    <td>
			  			        <?php echo $stuDetail->father_full_name;?>
			  			        <input type = "hidden" id="fname<?php echo $count;?>" value="<?php echo $stuDetail->father_full_name;?>"/>
			  			    </td>
			  			    <td>
							    <?php $month = $total->totalMonth;?>
							    <?php if($month > 12){$month = $month - 12;} ?>
			                    <?php for($i = 0; $i<$month; $i++):?>
				                    <span class="label label-success" style="line-height:20px;">
				               		    <?php echo date("M-y",strtotime("$fsd + $i month"));?>
				                    </span>
			                    <?php endfor; ?>
						    </td>
			  			    <td>
			  			        <?php 
			  			            $totPaid1=0;
			  			            $stamp1 = date("Y-m-d");
			  			            $stamp=strtotime($stamp1);
			  			            $dayy=date("Y", $stamp);
			  			            $dayc=date("d", $stamp);
			  			            $day1=date("m", $stamp);
			  			            $scr=0;
			  			            $padf = $this->db->query("SELECT Total_Admission_Fee from one_time_fee WHERE student_id = '$stu_id'")->row(); 
			  			
            			  			if(($padf)||($total)){
            			  				if($remain){
            			  				    if($padf){
            			  				        $totPaid1 = $padf->Total_Admission_Fee-$remain->total_due;
            			  				        $scr=$totPaid1;
            			  				        echo $totPaid1;
            			  				    }
            			  				    else{
            			  				        echo 0;
            			  				        $scr=0;
            			  				    }
            			  				    $pada = $this->db->query("SELECT Paid_Admission_Fee from one_time_fee WHERE student_id = '$stu_id'")->row();
            			  				    if($pada){
            			  				        $tpwm=$total->totalPaid;
            			  				        echo "+".$tpwm."=";
            			  				        echo $totPaid1+$tpwm;
            			  				    }
            			  				    else{
            			  					    $tpwm=$total->totalPaid - 0.00;
            			  					    echo "+".$tpwm."=";
            			  					    echo $totPaid1+$tpwm;
            			  				    }
            			  				}
            						}
            						else{
            							echo "Not Configure";
            						}?>
							</td>
			  			
			  			    <td>
            			  	    <?php 
            			  	        if(($remain)||($total)){ 
                                        $fsdy=date("Y",strtotime($fsd));
            			  				$fsdm=date("m",strtotime($fsd));
            			  				
            			  				if(($dayy-$fsdy)==0)
            			  				    $remainmonth = $day1-$fsdm;
            			  				    
            			  				if(($dayy-$fsdy)==1)
            			  					$remainmonth = ($day1+12)-$fsdm;
            			  					
            			  				if(($dayy-$fsdy)==2)
            			  					$remainmonth = ($day1+24)-$fsdm;
            			  					
            			  				$fc=0;
            			  				$pri=0;
            			  				$fd = $this->db->query("SELECT * from fee_shedule  WHERE student_id = '$stu_id' order by `id` desc limit 1 ")->row();
            			  				if($fd)	{
            			  					$fc = $fc + $fd->Tution_Fee;
            			  					$fc = $fc + $fd->Library_Fee;
            			  					$fc = $fc + $fd->Practical_Fee;
            			  					$fc = $fc + $fd->Examination_Fee;
            			  					$psv =	$this->db->query("SELECT previous_balance FROM fee_deposit WHERE student_id = '$stu_id' order by `id` desc limit 1")->row();
            			  					$pri = $pri  + $psv->previous_balance;
            			  				}
            			  				$remainmonth = $remainmonth - $total->totalMonth;
            			  				$remainAmount = $remainmonth * $fc + $pri;
            			  				if($remain){
            			  				    $totduef=$remain->total_due + $remainAmount;
            			  			        echo $remain->total_due."+".$remainAmount."=".$totduef;
            			  				}
            			  				else{
            			  					$totduef= 0.00 + $remainAmount;
            			  					echo "0.00 +".$remainAmount."=".$totduef;
            			  				}
            			  				
            			  			}
            			  		?>
                            </td>
			  			    <td>
			  			        <input type = "hidden" id="rem<?php echo $count;?>" value="<?php echo $totduef;?>"/>
							    <a href="<?php echo base_url()?>index.php/feeControllers/fullDetail/<?php echo $stu_id;?>" target="_blank" class="btn btn-blue">
								    View Detail
							    </a>
    							<button class="btn btn-yellow" id ="smstodew<?php echo $count;?>" >
    								Send SMS
    							</button>
    							<script>
    			  		
            			  			$("#smstodew<?php echo $count;?>").click(function(){
            			  				var smstodue = $("#rem<?php echo $count;?>").val();
            			  				var sname = $("#sname<?php echo $count;?>").val();
            			  				var fname = $("#fname<?php echo $count;?>").val();
            			  				var mnum = $("#mnum<?php echo $count;?>").val();
            					    
            					        $.post("<?php echo site_url("index.php/feeControllers/feeRemSms") ?>",{smstodue : smstodue,sname : sname,fname : fname,mnum : mnum}, function(data){
            						        $("#smstodew<?php echo $count;?>").html(data);
            					        });
            				
            				        });
    			  			    </script>
			  			    </td>
			  		    </tr>
			  		    <?php $count++; ?>
			  		<?php endforeach;?>
				</tbody>
			</table>
		</div>
		<?php else: ?>
		<br/><br/>
			<div class="alert alert-block alert-danger fade in">
				<button data-dismiss="alert" class="close" type="button">
					&times;
				</button>
				<h4 class="alert-heading"><i class="fa fa-times"></i> Error! <?php echo $student->num_rows();?></h4>
				<p>
					No record found from Fee database please submit fee first of this class &amp; section..1234. 
				</p>
			</div>
		<?php endif; ?>
        <?php else: // if student_info not return any value... ?>
        	<br/><br/>
        	<div class="alert alert-block alert-danger fade in">
        		<button data-dismiss="alert" class="close" type="button">
        			&times;
        		</button>
        		<h4 class="alert-heading"><i class="fa fa-times"></i> Error! <?php echo $student->num_rows();?></h4>
        		<p>
        			No record found from this class and section... 
        		</p>
        		<p>
        			Make sure students are avaliable in this class section... :123)
        		</p>
        	</div>
        <?php endif; ?>

        <script>
        	TableExport.init();
        </script>