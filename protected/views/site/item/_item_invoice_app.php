<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-app<?php echo $data->bon_ID;?>">
                <?php echo $data->bon_ID; ?>
                <span style="margin-left: 20px;"><b><?php echo $data->getCustomerName($data->bon_ID); ?></b></span>
                <span style="margin-left: 20px;"><b>&#8364;<?php echo $data->price_total; ?></b></span>

                <?php if ($data->is_factuur == TYPE_YES): ?>
                <span style="margin-left: 20px;" class="btn btn-info" title="Factuur">F</span>
                <?php endif; ?>

                <?php if ($data->is_magento == TYPE_YES): ?>
                <span style="margin-left: 20px;" class="btn btn-warning" title="Magento">M</span>
                <?php endif; ?>

                <span class="pull-right"><?php echo !empty($data->bon_datum) ? 'Created: <b>' . date("d M y",strtotime($data->bon_datum)) . '</b>': ''; ?></span>
            </a>
        </h4>
    </div>
    <div id="collapse-app<?php echo $data->bon_ID;?>" class="panel-collapse collapse">
        <div class="panel-body">
            <a class="btn btn-primary" href="<?php echo url('invoices/create', ['id' => $data->bon_ID, 'type' => Invoices::TYPE_INVOICE_APP ]); ?>"><i class="glyphicon glyphicon-plus"></i> Create Invoice</a>
        </div>
    </div>
</div>