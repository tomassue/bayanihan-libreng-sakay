<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ 'MY QR'. $clientID }}</title>
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

    img {
        padding-left: 25px;
        padding-right: 25px;
        padding-top: 10px;
    }

    .rise {
        float: right;
    }

    .title {
        padding-top: 3px;
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
    }

    .client-name {
        padding-top: 10px;
        text-align: center;
    }

    .tag {
        text-align: center;
    }
</style>

<body>
    <div class="outer-border">
        <div class="logos">
            <img src="{{ asset('assets/img/cdo-seal.png') }}" style="height: 40px;" alt="logo">
            <img class="rise" src="{{ asset('assets/img/rise.png') }}" style="height: 40px;" alt="logo">
        </div>

        <div class="title">
            <span class="first-title">KANUNAY NAG-ALAGAD VOLUNTEER INITIATIVES</span>
            <span class="second-title">BAYANIHAN LIBRENG SAKAY</span>
        </div>

        <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">

        <div class="client-name">
            <span>{{ $full_name }}</span>
        </div>

        <div class="tag">
            <span>CLIENT</span>
        </div>
    </div>
</body>

</html>