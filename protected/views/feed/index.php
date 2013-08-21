<?php
/* @var $this FeedController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Posts',
);

$this->menu=array(
	array('label'=>'Create Posts', 'url'=>array('create')),
	array('label'=>'Manage Posts', 'url'=>array('admin')),
);
?>

<h1>Posts</h1>

<?php $this->renderPartial('_loop', array('dataProvider'=>$dataProvider)); ?>
