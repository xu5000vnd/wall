<aside>
  <div id="sidebar"  class="nav-collapse ">
      <!-- sidebar menu start-->
      <ul class="sidebar-menu">                
          <li class="active">
              <a class="" href="<?php echo Yii::app()->request->getBaseUrl(true);; ?>">
                  <i class="icon_house_alt"></i>
                  <span>Dashboard</span>
              </a>
          </li>
          <li class="sub-menu">
              <a href="javascript:;" class="">
                  <i class="icon_document_alt"></i>
                  <span>Invoices</span>
                  <span class="menu-arrow arrow_carrot-right"></span>
              </a>
              <ul class="sub">
                  <li><a class="" href="<?php echo Yii::app()->createAbsoluteUrl('invoices/index'); ?>"><i class="icon_document_alt"></i>Invoices</a></li>                          
                  <li><a class="" href="<?php echo Yii::app()->createAbsoluteUrl('invoices/create'); ?>"><i class="icon_document_alt"></i>Create Invoice</a></li>
                  <li><a class="" href="<?php echo Yii::app()->createAbsoluteUrl('invoices/indexraw'); ?>"><i class="icon_document_alt"></i>Proforma Invoice</a></li>
                  <li><a class="" href="<?php echo Yii::app()->createAbsoluteUrl('invoices/createraw'); ?>"><i class="icon_document_alt"></i>Create Proforma</a></li>
              </ul>
          </li>       
          <li class="sub-menu">
              <a href="<?php echo url('setting/index'); ?>" class="">
                  <i class="icon_cogs"></i>
                  <span>Setting</span>
                  <span class="menu-arrow arrow_carrot-right"></span>
              </a>
          </li>

          <li class="sub-menu">
              <a href="<?php echo url('customer/index'); ?>" class="">
                  <i class="icon_profile"></i>
                  <span>Customer</span>
                  <span class="menu-arrow arrow_carrot-right"></span>
              </a>
          </li>

          <li class="sub-menu">
              <a href="<?php echo url('user/index'); ?>" class="">
                  <i class="icon_group"></i>
                  <span>Members</span>
                  <span class="menu-arrow arrow_carrot-right"></span>
              </a>
          </li>

          <li class="sub-menu">
              <a href="<?php echo url('reminder/index'); ?>" class="">
                  <i class="icon_mail"></i>
                  <span>Reminder</span>
                  <span class="menu-arrow arrow_carrot-right"></span>
              </a>
          </li>

          <li class="sub-menu">
              <a href="<?php echo url('roles/index'); ?>" class="">
                  <i class="icon_profile"></i>
                  <span>Role</span>
                  <span class="menu-arrow arrow_carrot-right"></span>
              </a>
          </li>

          <li class="sub-menu">
              <a href="<?php echo url('actionsRole/index'); ?>" class="">
                  <i class="icon_profile"></i>
                  <span>Access Role</span>
                  <span class="menu-arrow arrow_carrot-right"></span>
              </a>
          </li>

          <li class="sub-menu">
              <a href="<?php echo url('site/logActive'); ?>" class="">
                  <i class="icon_document_alt"></i>
                  <span>Log Active</span>
                  <span class="menu-arrow arrow_carrot-right"></span>
              </a>
          </li>

      </ul>
      <!-- sidebar menu end-->
  </div>
</aside>
<!--sidebar end-->