<style type="text/css">
  h1{  font-family: Calibri;
    font-size: 32px;
    color: #c01111;
    margin-bottom: 10px;
    margin-left: 5px;
    text-transform: uppercase;}
    .contact_box_right {
    
    background: #ececec;
    border-left: 1px solid #ccc;
    float: right;
    padding: 25px 20px 20px;
    min-height: 525px;
}
.vendor_box_head h4 {
    font-family: Calibri;
    font-size: 46px;
    color: #c01111;
    text-align: center;
    margin-top: 22px;
}
.vendor_box_head h5 {
    font-family: Calibri;
    font-size: 22px;
    font-weight: 400;
    color: #000;
    text-transform: uppercase;
    text-align: center;
}
h2 {
    color: #333;
    text-transform: uppercase;
    font-size: 15px;
    margin-top: 0;
    margin-bottom: 5px;
}
</style>
<?php if (!isset($is_j2_popup)): ?>
<?php echo $header; ?>
<div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
</div>

<div class="vendor_box_head">
          <h4>LOVE US? HATE US? TELL US.</h4>
          <h5>For any query Contact Us</h5>
      </div>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content" class="contact-page" style="box-shadow: 0 0 3px 0 rgba(50,50,50,.25);
    margin-top: 40px;
    min-height: 525px;
    border: 1px solid #CCC; margin-bottom:20px;"><?php echo $content_top; ?>
<?php endif; ?>
   <div class="column  menu xs-100 sm-100 md-100 lg-50 xl-50 " style="padding:20px;">
    <h1>We are happy to know your query.</h1><br/>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <?php if (isset($product_id) && $product_id): ?>
    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
    <?php endif; ?>
   
    <div class="content">
    <b><?php echo $entry_name; ?></b><br />
    <input type="text" name="name" value="<?php echo $name; ?>" />
    <br />
    <?php if ($error_name) { ?>
    <span class="error"><?php echo $error_name; ?></span>
    <?php } ?>
    <br />
    <b><?php echo $entry_email; ?></b><br />
    <input type="text" name="email" value="<?php echo $email; ?>" />
    <br />
    <?php if ($error_email) { ?>
    <span class="error"><?php echo $error_email; ?></span>
    <?php } ?>
    <br />
    <b><?php echo $entry_enquiry; ?></b><br />
    <textarea name="enquiry" cols="40" rows="10"><?php echo $enquiry; ?></textarea>
    <br />
    <?php if ($error_enquiry) { ?>
    <span class="error"><?php echo $error_enquiry; ?></span>
    <?php } ?>
    <br />
    <b><?php echo $entry_captcha; ?></b><br />
    <input type="text" name="captcha" value="<?php echo $captcha; ?>" />
    <br />
    <img src="index.php?route=information/contact/captcha" alt="" />
    <?php if ($error_captcha) { ?>
    <span class="error"><?php echo $error_captcha; ?></span>
    <?php } ?>
    </div>
    <?php if (!isset($is_j2_popup)): ?>
    <div class="buttons">
        <div class="right"><input type="submit" value="<?php echo $button_continue; ?>" class="button" /></div>
    </div>
    <?php endif; ?>
  </form></div>

<div class="column  menu xs-100 sm-100 md-100 lg-50 xl-50 contact_box_right">
            <h2>Corporate Office:</h2>
            <p>Accord Retail E-Infra Pvt. Ltd. Office No. 602, Pride Purple Accord, Baner Road, Baner, Pune-411045</p><br /> 
            <h2>Customer Support:</h2>
            <p>Please call us at <b>(020) 27290704</b> any day of the week between <b>9.30 AM and 6.30 PM</b> or mail us at <a href="#">support@furnideals.com</a></p><br /> 
            <h2>Complaint:</h2>
            <p>If you are not happy with our services call the number above and ask for a Complaint to be raised. Our customer service desk will attend to your issue straightaway.<br>If your concern still remains unresolved, please drop an email to: <a href="#">care@furnideals.com</a></p> <br />
            <h2>Other Enquiries:</h2>
            <table>
                <tbody><tr>
                    <td>Corporate Sales</td><td><a href="#">corporate.sales@furnideals.com</a></td>
                </tr>
                <tr>
                    <td>Business Development &amp; Partnerships</td><td><a href="#">partners@furnideals.com</a></td>
                </tr>
                <tr>
                    <td>Careers</td><td><a href="#">careers@furnideals.com</a></td>
                </tr>
                <tr>
                    <td>Press Relations</td><td><a href="#">mediarelations@furnideals.com</a></td>
                </tr>
            </tbody></table>
         </div>
         <div class="column  menu xs-100 sm-100 md-100 lg-50 xl-50" style="margin-top:5px;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15129.723399875096!2d73.79954093787791!3d18.554604624577486!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xf054e00ab2474840!2sAccord+Retail+E-Infra+Pvt.+Ltd.!5e0!3m2!1sen!2sin!4v1433748145257" width="100%" height="200" frameborder="0" style="border:0"></iframe></div>

<?php if (!isset($is_j2_popup)): ?>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>
<?php endif; ?>

