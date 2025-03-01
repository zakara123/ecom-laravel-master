<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        #payment-form {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            height: 700px;
            /* Set a fixed height */
        }

        /* Media query for screens smaller than 768px (typical mobile screens) */
        @media (max-width: 768px) {
            #payment-form {
                width: 350px;
                margin: 0 auto;
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <div id="payment-form"></div>
    <script src="https://sandbox-checkout.peachpayments.com/js/checkout.js"></script>

    <script>
        (async () => {
            try {
                var data = {!! $data !!};
                const checkout = Checkout.initiate(data);
                checkout.render("#payment-form");
            } catch (error) {
                console.error('Error during fetch:', error);
            }
        })();
    </script>

</body>

</html>
