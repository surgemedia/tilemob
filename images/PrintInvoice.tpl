<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<title>Editable Invoice</title>
	<link rel="stylesheet" type="text/css" href="{$common_css}/style.css"/>
        <link rel="stylesheet" type="text/css" href="{$common_css}/print.css"/>
        {*<link rel="stylesheet" type="text/css" href="{$view_styles}/popup.css"/>*}
        <script type='text/javascript' src='{$common_js}/jquery-1.3.2.min.js'></script>
	<script type='text/javascript' src='{$common_js}/example.js'></script>

</head>

<body>
    <input type="hidden" name="css_path" id="css_path" value="{$common_css}">
    <div id="print_data">
	<div id="page-wrap">
            <textarea id="header">INVOICE</textarea>
            <div id="identity">
<textarea id="address">
{$companyName}
{$companyCity}
{$companyState}, {$companyCountry}

Phone: {$companyPhone}
</textarea>
                <div id="logo">
                    {*<div id="logoctr">
                        <a href="javascript:;" id="change-logo" title="Change logo">Change Logo</a>
                        <a href="javascript:;" id="save-logo" title="Save changes">Save</a>
                        |
                        <a href="javascript:;" id="delete-logo" title="Delete logo">Delete Logo</a>
                        <a href="javascript:;" id="cancel-logo" title="Cancel changes">Cancel</a>
                    </div>*}

                    {*<div id="logohelp">
                        <input id="imageloc" type="text" size="50" value="" /><br />
                        (max width: 540px, max height: 100px)
                    </div>*}
                    <img src="{$siteUrl}/public/uploads/settings/zoominLogoPrint.png" alt="logo"/>
                    {*<img id="image" src="images/logo.png" alt="logo" />*}
                </div>
            </div>
            <div style="clear:both"></div>
                <div id="customer">

<textarea id="customer-title">
{$bookingDetails.userFirstName} {$bookingDetails.userLastName}
{$bookingDetails.userAdress1},
{if $bookingDetails.userAdress2}
    {$bookingDetails.userAdress2}
{/if}
{if $bookingDetails.buildingName}
    {$bookingDetails.buildingName}
{/if}
{if $bookingDetails.apartmentNumber}
    {$bookingDetails.apartmentNumber}
{/if}
{$bookingDetails.user_stateName}
{$bookingDetails.user_countryName}
</textarea>

            <table id="meta">
                <tr>
                    <td class="meta-head">Invoice #</td>
                    <td><textarea>{"%08d"|sprintf:$bookingDetails.bookingID}</textarea></td>
                </tr>
                <tr>

                    <td class="meta-head">Date</td>
                    <td><textarea id="date">December 15, 2009</textarea></td>
                </tr>
                <tr>
                    <td class="meta-head">Amount Due</td>
                    <td><div class="due">{$totalInvoice[0]['totalInvoiceAmount']}</div></td>
                </tr>

            </table>
		
		</div>
		
		<table id="items">
		
		  <tr>
		      <th>Item</th>
		      <th>Description</th>
		      <th>Unit Cost</th>
		      <th>Quantity</th>
		      <th>Price</th>
		  </tr>
		  {foreach from=$invoiceDetails item="invoice"}
		  <tr class="item-row">
		      <td class="item-name"><div class="delete-wpr"><textarea>{$invoice.itemName}</textarea></div></td>
                        <td class="description"><textarea>{$invoice.itemName}</textarea></td>
		      <td><textarea class="cost">{$invoice.amount}</textarea></td>
		      <td><textarea class="qty">1</textarea></td>
		      <td><span class="price">{$invoice.amount}</span></td>
		  </tr>
		  {/foreach}
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Subtotal</td>
		      <td class="total-value"><div id="subtotal">{$totalInvoice[0]['totalInvoiceAmount']}</div></td>
		  </tr>
		  <tr>

		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Total</td>
		      <td class="total-value"><div id="total">{$totalInvoice[0]['totalInvoiceAmount']}</div></td>
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Amount Paid</td>

		      <td class="total-value"><textarea id="paid">$0.00</textarea></td>
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line balance">Balance Due</td>
		      <td class="total-value balance"><div class="due">{$totalInvoice[0]['totalInvoiceAmount']}</div></td>
		  </tr>
		
		</table>
		
		<div id="terms">
		  <h5>Terms</h5>
		  <textarea>NET 30 Days. Finance Charge of 1.5% will be made on unpaid balances after 30 days.</textarea>
		</div>
	
	</div>
    </div>
    <div class="print_invoice">
        <ul>
            <li>
                <div class="submit-block textto_center">
                    <input type="button" name="printInvoice" id="printInvoice" class="curve-3 submitBtn" value="{$language.lblPrintInvoice}">
                    {html->anchor onclick="parent.$.colorbox.close();" id="cancel" name="cancel" tabindex="1" caption="{$language.lblCancel}"} 
                </div>
            </li>
        </ul>          
    </div>
</body>
<script type="text/javascript" src="{$common_js}/PrintInvoice.page.js"></script>
</html>