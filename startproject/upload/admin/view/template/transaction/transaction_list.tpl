<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $insert; ?>" data-toggle="tooltip" title="<?php echo $button_insert; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-card').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
          <div class="col-sm-6">
              <div class="form-group">
                <div class="input-group date">
                  <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" placeholder="<?php echo $entry_date_start; ?>" data-format="YYYY-MM-DD" id="input-date-start" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <div class="form-group">
                <div class="input-group date">
                  <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" placeholder="<?php echo $entry_date_end; ?>" data-format="YYYY-MM-DD" id="input-date-end" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
            </div>
            <div class="col-sm-4">
             <div class="form-group">
                <input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" id="input-customer" placeholder="<?php echo $entry_customer; ?>" class="form-control" />
              </div>
              <!-- 
              <div class="form-group">
                <label class="control-label" for="input-model"><?php echo $entry_model; ?></label>
                <input type="text" name="filter_model" value="<?php echo $filter_model; ?>" placeholder="<?php echo $entry_model; ?>" id="input-model" class="form-control" />
              </div>
               -->
            </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-card">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'c.customer_name') { ?>
                    <a href="<?php echo $sort_customer_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_customer_name; ?>"><?php echo $column_customer_name; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 't.amount') { ?>
                    <a href="<?php echo $sort_amount; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_amount; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_amount; ?>"><?php echo $column_amount; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'tt.transaction_type_name') { ?>
                    <a href="<?php echo $sort_type_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_type_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_type_name; ?>"><?php echo $column_type_name; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 't.comment') { ?>
                    <a href="<?php echo $sort_comment; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_comment; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_comment; ?>"><?php echo $column_comment; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'u.username') { ?>
                    <a href="<?php echo $sort_username; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_username; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_username; ?>"><?php echo $column_username; ?></a>
                    <?php } ?></td>
                  
                </tr>
              </thead>
              <tbody>
                <?php if ($transactions) { ?>
                <?php foreach ($transactions as $transaction) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($transaction['transaction_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $transaction['transaction_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $transaction['transaction_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $transaction['customer_name']; ?></td>
                  <td class="text-left"><?php echo $transaction['amount']; ?></td>
                  <td class="text-left">
                    <?php echo $transaction['type_name']; ?></td>
                  <td class="text-left"><?php echo $transaction['comment']; ?></td>
                  <td class="text-left"><?php echo $transaction['username']; ?></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	var url = 'index.php?route=transaction/transaction&token=<?php echo $token; ?>';

	var filter_name = $('input[name=\'filter_name\']').val();

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_customer = $('input[name=\'filter_customer\']').val();
	
	if (filter_customer) {
		url += '&filter_customer=' + encodeURIComponent(filter_customer);
	}

	var filter_date_start = $('input[name=\'filter_date_start\']').val();
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').val();
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}

	var filter_amount = $('input[name=\'filter_amount\']').val();

	if (filter_amount) {
		url += '&filter_amount=' + encodeURIComponent(filter_amount);
	}


	location = url;
});
//--></script> 
  <script type="text/javascript"><!--

  
$('input[name=\'filter_name\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=card/card/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['card_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_name\']').val(item['label']);
	}
});

$('input[name=\'filter_model\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=card/card/autocomplete&token=<?php echo $token; ?>&filter_model=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['model'],
						value: item['card_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_model\']').val(item['label']);
	}
});
//--></script>
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script></div>
<?php echo $footer; ?>