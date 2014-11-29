<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-user" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_customer; ?></label>
            <div class="col-sm-10">
               <select name="customer_id" id="input-customer" class="form-control">
                <?php foreach ($customers as $customer) { ?>
                <?php if ($customer['customer_id'] == $customer_id) { ?>
                <option value="<?php echo $customer['customer_id']; ?>" selected="selected"><?php echo $customer['customer_name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['customer_name'];  ?></option>
                <?php } ?>
                <?php } ?>
              </select>
              
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-user-group"><?php echo $entry_transaction_type; ?></label>
            <div class="col-sm-10">
              <select name="transaction_type_id" id="input-transaction_type" class="form-control">
                <?php foreach ($transaction_types as $transaction_type) { ?>
                <?php if ($transaction_type['transaction_type_id'] == $transaction_type_id) { ?>
                <option value="<?php echo $transaction_type['transaction_type_id']; ?>" selected="selected"><?php echo $transaction_type['type_name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $transaction_type['transaction_type_id']; ?>"><?php echo $transaction_type['type_name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-firstname"><?php echo $entry_amount; ?></label>
            <div class="col-sm-10">
              <input type="text" name="amount" value="<?php echo $amount; ?>" placeholder="<?php echo $entry_amount; ?>" id="input-amount" class="form-control" />
              <?php if ($error_amount) { ?>
              <div class="text-danger"><?php echo $error_amount; ?></div>
              <?php } ?>
            </div>
          </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-comment"><?php echo $entry_comment; ?></label>
                    <div class="col-sm-10">
                      <textarea name="comment" rows="5" placeholder="<?php echo $entry_comment; ?>" id="comment" class="form-control"><?php echo $comment?></textarea>
                    </div>
                  </div>          
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 