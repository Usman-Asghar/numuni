<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="row">

                <h5><?php echo $this->lang->line('Add New Customer') ?></h5>
                <hr>
                <div class="col-md-6">
                    <h5><?php echo $this->lang->line('Billing Address') ?></h5>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="name"><?php echo $this->lang->line('Name') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="Name"
                                   class="form-control margin-bottom  required" name="name" id="mcustomer_name">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="name"><?php echo $this->lang->line('Company') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="Company"
                                   class="form-control margin-bottom " name="company">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="phone"><?php echo $this->lang->line('Phone') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="phone"
                                   class="form-control margin-bottom required" name="phone" id="mcustomer_phone">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="email">Email</label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="email"
                                   class="form-control margin-bottom required" name="email" id="mcustomer_email">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="address"><?php echo $this->lang->line('Address') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="address"
                                   class="form-control margin-bottom required" name="address" id="mcustomer_address1">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="city"><?php echo $this->lang->line('City') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="city"
                                   class="form-control margin-bottom" name="city" id="mcustomer_city">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="region"><?php echo $this->lang->line('Region') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="Region"
                                   class="form-control margin-bottom" name="region" id="region">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="country"><?php echo $this->lang->line('Country') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="Country"
                                   class="form-control margin-bottom" name="country" id="mcustomer_country">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

                        <div class="col-sm-6">
                            <input type="text" placeholder="PostBox"
                                   class="form-control margin-bottom" name="postbox" id="postbox">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="postbox"><?php echo $this->lang->line('TAX') ?> ID</label>

                        <div class="col-sm-6">
                            <input type="text" placeholder="TAX ID"
                                   class="form-control margin-bottom" name="taxid">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="customergroup"><?php echo $this->lang->line('Customer group') ?></label>

                        <div class="col-sm-10">
                            <select name="customergroup" class="form-control">
                                <?php

                                foreach ($customergrouplist as $row) {
                                    $cid = $row['id'];
                                    $title = $row['title'];
                                    echo "<option value='$cid'>$title</option>";
                                }
                                ?>
                            </select>


                        </div>
                    </div>


                </div>

                <!--ship-->

                <div class="col-md-6">
                    <h5><?php echo $this->lang->line('Shipping Address') ?></h5>
                    <div class="form-group row">

                        <div class="input-group">
                            <label class="display-inline-block custom-control custom-radio ml-1">
                                <input type="checkbox" name="customer1" class="custom-control-input" id="copy_address">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description ml-0"><?php echo $this->lang->line('Same As Billing') ?></span>
                            </label>

                        </div>

                        <div class="col-sm-10">
                            <?php echo $this->lang->line("leave Shipping Address") ?>
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="name_s"><?php echo $this->lang->line('Name') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="Name"
                                   class="form-control margin-bottom" name="name_s" id="mcustomer_name_s">
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="phone_s"><?php echo $this->lang->line('Phone') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="phone"
                                   class="form-control margin-bottom" name="phone_s" id="mcustomer_phone_s">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="email_s">Email</label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="email"
                                   class="form-control margin-bottom" name="email_s" id="mcustomer_email_s">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="address"><?php echo $this->lang->line('Address') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="address_s"
                                   class="form-control margin-bottom" name="address_s"
                                   id="mcustomer_address1_s">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="city_s"><?php echo $this->lang->line('City') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="city"
                                   class="form-control margin-bottom" name="city_s" id="mcustomer_city_s">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="region_s"><?php echo $this->lang->line('Region') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="Region"
                                   class="form-control margin-bottom" name="region_s" id="region_s">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="country_s"><?php echo $this->lang->line('Country') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="Country"
                                   class="form-control margin-bottom" name="country_s" id="mcustomer_country_s">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

                        <div class="col-sm-6">
                            <input type="text" placeholder="PostBox"
                                   class="form-control margin-bottom" name="postbox_s" id="postbox_s">
                        </div>
                    </div>


                </div>
            </div>
            <div class="form-group row">

                <label class="col-sm-2 col-form-label"></label>

                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="<?php echo $this->lang->line('Add customer') ?>" data-loading-text="Adding...">
                    <input type="hidden" value="customers/addcustomer" id="action-url">
                </div>
            </div>


    </div>
    </form>
    </div>
</article>

