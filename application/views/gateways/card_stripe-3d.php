<link rel="stylesheet" type="text/css"
      href="https://cdnjs.cloudflare.com/ajax/libs/featherlight/1.7.6/featherlight.min.css">
<style>
    #processing {
        display: none;
    }

    #result {
        padding: 15px;
        display: none;
    }

    #iframe-container iframe {
        width: 100%;
        height: 400px;
    }

</style>


<?php
$rming = $invoice['total'] - $invoice['pamnt'];
if ($itype == 'rinv' && $invoice['status'] == 'due') {
    $rming = $invoice['total'];
}
$surcharge_t = false;

$row = $gateway;

$cid = $row['id'];
$title = $row['name'];
if ($row['surcharge'] > 0) {
    $surcharge_t = true;
    $fee = '( ' . amountExchange($rming, $invoice['multi']) . '+' . amountFormat_s($row['surcharge']) . ' %)';
} else {
    $fee = '';


}
?><div class="app-content content container-fluid">  <div class="content-wrapper">
<div class="card">

    <div class="card-header">
        <h1>Stripe Payment Page (3D Secure optional)</h1>

    </div>
    <div class="card-body">
        <p id="result" class="bg-info"></p>

        <form class="form-horizontal" id="charge-form">
            <div class="form-group">
                <div class="col-sm-offset-6 col-sm-6">
     <button id="customButton" class="btn btn-success"><i class="fa fa-arrow-circle-right"></i> Pay With Stripe Secure</button>
                </div>
            </div>
        </form>

        <div id="processing">
            <p class="text-center">Processing...</p>
        </div>

        <div id="modal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body" id="iframe-container">
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
</div></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/featherlight/1.7.6/featherlight.min.js"></script>
<script src="https://js.stripe.com/v2/"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>
<script>
    var stripePublishableKey = '<?=$row['key2']; ?>';
    var amount = <?php if ($rming > 0) echo $rming * 100; else echo '0'; ?>;
    var currency = '<?=$row['currency']; ?>';

    Stripe.setPublishableKey(stripePublishableKey);

    // Create Checkout's handler
    var handler = StripeCheckout.configure({
        key: stripePublishableKey,
        image: '<?= base_url('userfiles/company/' . $this->config->item('logo')) ?>',
        locale: 'auto',
        allowRememberMe: false,
        token: function (token) {
            // use Checkout's card token to create a card source
            Stripe.source.create({
                type: 'card',
                token: token.id
            }, stripeCardResponseHandler);

            displayProcessing();
        }
    });

    $('#customButton').on('click', function (e) {
        // Open Checkout with further options:
        handler.open({
            name: '<?=$this->config->item('ctitle')?>',
            description: '<?=$this->config->item('city')?>',
            amount: amount,
            currency: currency
        });
        e.preventDefault();
    });

    // Close Checkout on page navigation:
    $(window).on('popstate', function () {
        handler.close();
    });

    function displayProcessing() {
        document.getElementById("processing").style.display = 'block';

        document.getElementById("charge-form").style.display = 'none';
        document.getElementById("result").style.display = 'none';
    }

    function displayResult(resultText) {
        document.getElementById("processing").style.display = 'none';

        document.getElementById("charge-form").style.display = 'block';
        document.getElementById("result").style.display = 'block';
        document.getElementById("result").innerText = resultText;
    }

    function stripeCardResponseHandler(status, response) {
        if (response.error) {
            var message = response.error.message;
            displayResult("Unexpected card source creation response status: " + status + ". Error: " + message);
            return;
        }

        // check if the card supports 3DS
        if (response.card.three_d_secure == 'not_supported') {
            displayResult("This card does not support 3D Secure.");
            return;
        }

        // since we're going to use an iframe in this example, the
        // return URL will only be displayed briefly before the iframe
        // is closed. Set it to a static page on your site that says
        // something like "Please wait while your transaction is processed"
        var returnURL = "<?php echo base_url('billing/process_stripe') ?>";

        // create the 3DS source from the card source
        Stripe.source.create({
            type: 'three_d_secure',
            amount: amount,
            currency: currency,
            three_d_secure: {
                card: response.id
            },
            redirect: {
                return_url: returnURL
            }
        }, stripe3DSecureResponseHandler);
    }

    function stripe3DSecureResponseHandler(status, response) {
        if (response.error) {
            var message = response.error.message;
            displayResult("Unexpected 3DS source creation response status: " + status + ". Error: " + message);
            return;
        }

        // check the 3DS source's status
        if (response.status == 'chargeable') {
            // displayResult("This card does not support 3D Secure authentication, but liability will be shifted to the card issuer.");
            // return;

        } else if (response.status != 'pending') {
            displayResult("Unexpected 3D Secure status: " + response.status);
            return;
        }

        // start polling the source (to detect the change from pending
        // to either chargeable or failed)
        Stripe.source.poll(
            response.id,
            response.client_secret,
            stripe3DSStatusChangedHandler
        );

        // open the redirect URL in an iframe
        // (in this example we're using Featherlight for convenience,
        // but this is of course not a requirement)
        $.featherlight({
            iframe: response.redirect.url,
            iframeWidth: '800',
            iframeHeight: '600'
        });

        console.log(response);
    }

    function stripe3DSStatusChangedHandler(status, source) {
        if (source.status == 'chargeable') {
            $.featherlight.current().close();
            var msg = 'Secure authentication succeeded.';
            displayResult(msg);
            jQuery.ajax({

                url: '<?php echo base_url('billing/process_card') ?>',
                type: 'POST',
                data: 'token_s=' + source.id + '&s_amount=' + source.amount + '&amount=' + source.amount + '&currency=' + source.currency + '&id=<?= $invoice['tid']; ?>&token=<?= $token ?>&itype=<?= $itype ?>&gateway=<?= $gid ?>&<?=$this->security->get_csrf_token_name(); ?>=<?=$this->security->get_csrf_hash(); ?>',
                success: function (data) {
                    if (data.status == 'Success')
                        window.location.replace('<?=base_url('billing/view?id=' . $invoice['tid'] . '&token=' . $token)?>');
                }
            });


        } else if (source.status == 'failed') {
            $.featherlight.current().close();
            var msg = '3D Secure authentication failed.';
            displayResult(msg);
        } else if (source.status != 'pending') {
            $.featherlight.current().close();
            var msg = "Unexpected 3D Secure status: " + source.status;
            displayResult(msg);

        }
    }

</script>

