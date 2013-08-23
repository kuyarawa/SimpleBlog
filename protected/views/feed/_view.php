<?php
/* @var $this FeedController */
/* @var $data Posts */
?>
<div class="post">
	<div class="view">
		<div class="row-fluid">
	    	<div class="span3" style = "line-height: 30px;">Product : <b><?php echo CHtml::encode($data->title); ?></b></div>
	    	<div class="span3" style = "line-height: 30px;">Description : <b><?php echo CHtml::encode($data->text); ?></b></div>
	    	<div class="span3" style = "line-height: 30px;">Price : <b><?php echo CHtml::encode($data->price); ?> USD</b></div>
	    	<div class="span3"><a href="/feed/order/id/<?php echo $data->id; ?>"><button class="btn btn-success">Order</button></a></div>
	    </div>
	</div>
</div>