<h1>Order from PayPal</h1>

<h2>Get</h2>
<?php var_dump($input); ?>

<h2>Model</h2>
<?php var_dump($model->attributes);?>

<h2>Curl errors</h2>
<?php var_dump($error); ?>

<h2>Result of auth on paypal</h2>
<?php var_dump($response); ?>

<h2>Result of open transaction on paypal</h2>
<?php var_dump($transaction); ?>

<h2>Approval url</h2>
<?php var_dump($approval); ?>

<h2>ec_token_pos url</h2>
<?php var_dump($ec); ?>



<a href="<?=$approval?>" target="_blank">Confirm Pay</a>
