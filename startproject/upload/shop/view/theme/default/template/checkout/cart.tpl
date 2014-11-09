	<?php echo $header; ?><?php echo $column_left; ?>
	<div id="content">
		<div class="page-header">
			<div class="container-fluid">
				<h1><?php echo $heading_title; ?></h1>
				  <?php if ($attention) { ?>
					  <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $attention; ?>
					    <button type="button" class="close" data-dismiss="alert">&times;</button>
					  </div>
					  <?php } ?>
					  <?php if ($success) { ?>
					  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
					    <button type="button" class="close" data-dismiss="alert">&times;</button>
					  </div>
					  <?php } ?>
					  <?php if ($error_warning) { ?>
					  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
					    <button type="button" class="close" data-dismiss="alert">&times;</button>
					  </div>
					  <?php } ?>
			</div>
		</div>
	
	  <div class="container-fluid">
	    <div class="">
	
	      <div class="panel-body">
	          <div class="row">
			      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
			        <div class="table-responsive">
			          <table class="table table-bordered">
			            <thead>
			              <tr>
			                <td class="text-center"><?php echo $column_image; ?></td>
			                <td class="text-left"><?php echo $column_name; ?></td>
			                <td class="text-left"><?php echo $column_quantity; ?></td>
			                <td class="text-right"><?php echo $column_price; ?></td>
			                <td class="text-right"><?php echo $column_total; ?></td>
			              </tr>
			            </thead>
			            <tbody>
			              <?php foreach ($cards as $card) { ?>
			              <tr>
			                <td class="text-center"><?php if ($card['thumb']) { ?>
			                  <a href="<?php echo $card['href']; ?>"><img src="<?php echo $card['thumb']; ?>" alt="<?php echo $card['name']; ?>" title="<?php echo $card['name']; ?>" class="img-thumbnail" /></a>
			                  <?php } ?></td>
			                <td class="text-left"><a href="<?php echo $card['href']; ?>"><?php echo $card['name']; ?></a>
			                  <?php if (!$card['stock']) { ?>
			                  <span class="text-danger">***</span>
			                  <?php } ?></td>
			                <td class="text-left"><div class="input-group btn-block" style="max-width: 200px;">
			                    <input type="text" name="quantity[<?php echo $card['key']; ?>]" value="<?php echo $card['quantity']; ?>" size="1" class="form-control" />
			                    <span class="input-group-btn">
			                    <button type="submit" data-toggle="tooltip" title="<?php echo $button_update; ?>" class="btn btn-primary"><i class="fa fa-refresh"></i></button>
			                    <button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger" onclick="cart.remove('<?php echo $card['key']; ?>');"><i class="fa fa-times-circle"></i></button></span></div></td>
			                <td class="text-right"><?php echo $card['price']; ?></td>
			                <td class="text-right"><?php echo $card['total']; ?></td>
			              </tr>
			              <?php } ?>
			            </tbody>
			          </table>
			        </div>
			      </form>
			</div>
			<div class="row">
		        <div class="col-sm-4 col-sm-offset-8">
		          <table class="table table-bordered">
		            <?php foreach ($totals as $total) { ?>
		            <tr>
		              <td class="text-right"><strong><?php echo $total['title']; ?>:</strong></td>
		              <td class="text-right"><?php echo $total['text']; ?></td>
		            </tr>
		            <?php } ?>
		          </table>
		        </div>
		      </div>
	        <div class="row">
	
		      <div class="buttons">
		        <div class="pull-left"><a href="<?php echo $continue; ?>" class="btn btn-default"><?php echo $button_shopping; ?></a></div>
		        <div class="pull-right"><a href="<?php echo $checkout; ?>" class="btn btn-primary"><?php echo $button_checkout; ?></a></div>
		      </div>
	        </div>
	      </div>
	    </div>
	  </div>
	  </div>