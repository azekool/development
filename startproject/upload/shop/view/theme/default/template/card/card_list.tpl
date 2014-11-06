<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<h1><?php echo $heading_title; ?></h1>
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
            <?php foreach (array_chunk($cards, 4) as $card) { ?>
				
		        <?php foreach ($card as $card) { ?>
		        	
		       		 <div class="col-sm-2 text-center">
		       		 <div class="thumbnail">
		       		
		          		 <a href="<?php echo $card['href']; ?>" class="thumbnail1"><img src="<?php echo $card['image']; ?>" alt="<?php echo $card['name']; ?>" title="<?php echo $card['name']; ?>" /></a>
		         		 <label>
		         			 <!--   <input type="checkbox" name="path[]" value="<?php echo $image['path']; ?>" /> -->
		            		<?php echo $card['name']. ' <br> ' .$card['price']; ?></label>
		         		</div> 
		             </div>
		     
		    <?php }?>
		    
		  <?php }?>
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