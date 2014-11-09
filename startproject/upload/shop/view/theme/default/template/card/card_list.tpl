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
    <div class="panel panel-default">

      <div class="panel-body">
        <div class="well">
          <div class="row">
			<div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
                
              </div>  
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
                
              </div>  
            </div>
            <div class="col-sm-3">
             <span class="input-group-btn">
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button> 
              </span>
            </div>
          </div>
          </div>
          <div class="row">
           <?php if ($cards) { ?>
          <div class="table-responsive">
            <table class="table cards">
             <?php foreach (array_chunk($cards, 5) as $card) { ?>
				<tr>
		        <?php foreach ($card as $card) { ?>
		        	<td>
		       		 <div class="text-center">
		       		 <div class="card">
		       		
		          		 <a href="<?php echo $card['href']; ?>" class="thumbnail1"><img src="<?php echo $card['image']; ?>" alt="<?php echo $card['name']; ?>" title="<?php echo $card['name']; ?>" /></a>
		         		 <label>
		         			 <!--   <input type="checkbox" name="path[]" value="<?php echo $image['path']; ?>" /> -->
		            		<?php echo $card['name']. '  ' .$card['price']; ?></label>
		            		<button type="button" onclick="cart.add('<?php echo $card['card_id']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo 'kaufen'; ?></span></button>
		         		</div> 
		             </div>
		     </td>
		    <?php }?>
		    </tr>
		  <?php }?>
            </table>
          </div>
           <?php }?>
		</div>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
  </div>