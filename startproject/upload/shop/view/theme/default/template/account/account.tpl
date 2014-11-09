<?php echo $header; ?>
 <div ><?php echo $column_left; ?>
    <div id="content" class="col-sm-9">
        <div class="page-header">
		    <div class="container-fluid">
		      <h1><?php echo $heading_title; ?></h1>
		      <ul class="breadcrumb">
		        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
		        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		        <?php } ?>
		      </ul>
		    </div>
  	</div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
  </div>
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_account; ?></h3>
      </div>
      <div class="panel-body">
            <ul class="list-unstyled">
        <li><a href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a></li>
        <li><a href="<?php echo $password; ?>"><?php echo $text_password; ?></a></li>
        <li><a href="<?php echo $address; ?>"><?php echo $text_address; ?></a></li>
        <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
      </ul>
      <h2><?php echo $text_my_orders; ?></h2>
      <ul class="list-unstyled">
        <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
        <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
        <?php if ($reward) { ?>
        <li><a href="<?php echo $reward; ?>"><?php echo $text_reward; ?></a></li>
        <?php } ?>
        <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
        <li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
        <li><a href="<?php echo $recurring; ?>"><?php echo $text_recurring; ?></a></li>
      </ul>
      <h2><?php echo $text_my_newsletter; ?></h2>
      <ul class="list-unstyled">
        <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
      </ul>
      </div>

      </div>
   </div>
</div>
