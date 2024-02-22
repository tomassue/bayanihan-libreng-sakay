<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ 'MY QR CODE' }}</title>
    <link rel="stylesheet" href="https://use.typekit.net/oov2wcw.css">
</head>

<style>
    html {
        font-family: century-gothic, sans-serif;
        font-weight: 400;
        font-style: normal;
    }

    .outer-border {
        width: 245.67px;
        height: 359.06px;
        border: 3px solid gray;
    }

    .column {
        float: left;
        width: auto;
        /* padding: 10px; */
        padding-top: 10px;
    }

    /* Clearfix (clear floats) */
    .row::after {
        content: "";
        clear: both;
        display: table;
    }

    .qr {
        padding-left: 25px;
        padding-right: 25px;
        padding-top: 10px;
    }

    .title {
        /* padding-top: 3px; */
        font-weight: bold;
    }

    .first-title {
        font-size: 7.9px;
        padding-left: 25px;
        padding-right: 25px;
    }

    .second-title {
        font-size: 13.3px;
        padding-left: 25px;
        padding-right: 25px;
        color: #008000;
    }

    .client-name {
        /* font-size: 13.3px;
        padding-top: 10px;
        text-align: center; */
        font-size: calc(3vw + 10px);
        /* Example dynamic font size calculation */
        padding-top: 2%;
        /* Adjust padding as needed */
        text-align: center;
    }

    .tag {
        font-size: 13.3px;
        text-align: center;
    }
</style>

<body>
    <div class="outer-border">
        <!-- <div class="logos">
            <img src="{{ asset('assets/img/cdo-seal.png') }}" style="height: 40px;" alt="logo">
            <img src="{{ asset('assets/img/MAYOR.png') }}" style="height: 40px;" alt="logo">
            <img class="rise" src="{{ asset('assets/img/rise.png') }}" style="height: 40px;" alt="logo">
        </div> -->

        <div class="row">
            <div class="column">
                <img src="{{ asset('assets/img/cdo-seal.png') }}" style="height: 40px; padding-left: 25px;" alt="logo">
            </div>
            <div class="column">
                <img src="{{ asset('assets/img/MAYOR.png') }}" style="height: 40px; padding-left: 11.4px;" alt="logo">
            </div>
            <div class="column">
                <img src="{{ asset('assets/img/rise.png') }}" style="height: 40px; padding-left: 11.4px;" alt="logo">
            </div>
        </div>

        <div class="title">
            <span class="first-title">KANUNAY NAG-ALAGAD VOLUNTEER INITIATIVES</span>
            <span class="second-title">BAYANIHAN LIBRENG SAKAY</span>
        </div>

        <img class="qr" src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">

        <div class="client-name">
            <span style="text-transform: uppercase; color: #ff0000; font-weight: bold;">{{ $full_name }}</span>
        </div>

        <div class="tag">
            <span style="font-weight: bold;">CLIENT</span>
        </div>
    </div>
</body>

</html>