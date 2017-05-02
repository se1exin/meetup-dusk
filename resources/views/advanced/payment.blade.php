@extends('master')

@section('html_title', 'Payment')
@section('register_nav_stage_2_class', 'active')

@section('extra_css')
<link href="/css/advanced.css" rel="stylesheet" type="text/css">
@endsection
@section('extra_js')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>Stripe.setPublishableKey('{{ env('STRIPE_KEY') }}');</script>
<script src="/js/payment.js"></script>
@endsection

@section('content')
<section id="banner" class="payment-banner">
    <div class="container no-flex pad-left pad-right">
        <h2 class="title txt-shark-a">Payment</h2>
        <p class="subtitle">
            A Subscription only costs $9.99 a month. Wow that's cheap!
        </p>
    </div>
</section>
@include('advanced/partials/register-nav')
<section id="payment" class="auth-page container no-flex pad-left pad-right bg-grey">
    <form class="auth-form" id="payment-form" action="/payment" method="POST" autocomplete="on">
        <section class="container no-flex">
            <p class="error-message {{ (!$error_bag['success']) ? 'show' : '' }}">
                @if(!$error_bag['success'])
                {!! $error_bag['error'] !!}
                @endif
            </p>
        </section>
        <section class="container no-flex">
            <h2 class="title">Payment Amount <span class="price">$9.99</span></h2>
            <div class="input-wrap card-icons last">
                <div class="card-icon visa">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 732 224.43"><defs><style>.via{fill:#004686;}.vib{fill:#ef9b11;}</style></defs><title>Visa Logo</title><polygon class="via" points="257.87 221.21 294.93 3.77 354.19 3.77 317.11 221.21 257.87 221.21"/><path class="via" d="M532.06,9.41A152.88,152.88,0,0,0,478.94.28C420.38.28,379.13,29.77,378.78,72c-.33,31.24,29.45,48.67,51.93,59.07,23.07,10.65,30.82,17.45,30.71,27-.15,14.57-18.42,21.23-35.46,21.23-23.72,0-36.32-3.29-55.79-11.41l-7.64-3.46-8.32,48.67c13.84,6.07,39.44,11.33,66,11.61,62.3,0,102.74-29.15,103.2-74.28.22-24.74-15.57-43.56-49.76-59.08-20.71-10.06-33.4-16.77-33.27-27,0-9,10.74-18.7,33.94-18.7A109.19,109.19,0,0,1,518.71,54l5.31,2.5,8-47.12Z" transform="translate(0 -0.28)"/><path class="via" d="M684,4.26h-45.8c-14.19,0-24.8,3.88-31,18l-88,199.25h62.23s10.18-26.79,12.48-32.67c6.8,0,67.26.09,75.9.09,1.78,7.61,7.21,32.58,7.21,32.58h55L684,4.26M611,144.41c4.9-12.53,23.61-60.78,23.61-60.78-.35.57,4.86-12.59,7.86-20.75l4,18.74s11.34,51.91,13.72,62.79H611Z" transform="translate(0 -0.28)"/><path class="via" d="M208.17,4.21l-58,148.27L144,122.36C133.16,87.62,99.51,50,61.88,31.15L114.94,221.3l62.7-.07,93.3-217H208.17Z" transform="translate(0 -0.28)"/><path class="vib" d="M96.32,4.08H.76L0,8.61c74.35,18,123.54,61.49,144,113.75L123.18,22.44c-3.59-13.77-14-17.87-26.86-18.36Z" transform="translate(0 -0.28)"/></svg>
                </div>
                <div class="card-icon mastercard"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000.01 775.97"><defs><style>.mca{fill:#ff5f00;}.mcb{fill:#eb001b;}.mcc{fill:#f79e1b;}</style></defs><title>Mastercard Logo</title><path d="M182,774.26v-51.5c0-19.74-12-32.62-32.62-32.62-10.3,0-21.46,3.43-29.18,14.59-6-9.44-14.59-14.59-27.47-14.59-8.58,0-17.17,2.58-24,12v-10.3h-18v82.4h18V728.76c0-14.59,7.73-21.46,19.74-21.46s18,7.73,18,21.46v45.49h18V728.76c0-14.59,8.58-21.46,19.74-21.46,12,0,18,7.73,18,21.46v45.49Zm267-82.4H419.75V667h-18v24.89H385.41v16.31h16.31v37.77c0,18.88,7.73,30,28.33,30a48,48,0,0,0,22.32-6l-5.15-15.45a28.24,28.24,0,0,1-15.45,4.29c-8.58,0-12-5.15-12-13.73V708.16h29.18Zm152.79-1.72c-10.3,0-17.17,5.15-21.46,12v-10.3h-18v82.4h18V727.9c0-13.73,6-21.46,17.17-21.46a50.23,50.23,0,0,1,11.16,1.72L613.74,691c-3.43-.86-8.58-.86-12-.86Zm-230.9,8.58c-8.58-6-20.6-8.58-33.48-8.58-20.6,0-34.34,10.3-34.34,26.61,0,13.73,10.3,21.46,28.33,24l8.58.86c9.44,1.72,14.59,4.29,14.59,8.58,0,6-6.87,10.3-18.88,10.3a47.38,47.38,0,0,1-27.47-8.58l-8.58,13.73c9.44,6.87,22.32,10.3,35.19,10.3,24,0,37.77-11.16,37.77-26.61,0-14.59-11.16-22.32-28.33-24.89l-8.58-.86c-7.73-.86-13.73-2.58-13.73-7.73,0-6,6-9.44,15.45-9.44,10.3,0,20.6,4.29,25.75,6.87l7.73-14.59Zm479-8.58c-10.3,0-17.17,5.15-21.46,12v-10.3h-18v82.4h18V727.9c0-13.73,6-21.46,17.17-21.46a50.23,50.23,0,0,1,11.16,1.72L861.81,691c-3.43-.86-8.58-.86-12-.86Zm-230,42.92c0,24.89,17.17,42.92,43.78,42.92,12,0,20.6-2.58,29.18-9.44l-8.58-14.59c-6.87,5.15-13.73,7.73-21.46,7.73-14.59,0-24.89-10.3-24.89-26.61,0-15.45,10.3-25.75,24.89-26.61,7.73,0,14.59,2.58,21.46,7.73l8.58-14.59c-8.58-6.87-17.17-9.44-29.18-9.44-26.61,0-43.78,18-43.78,42.92h0Zm166.52,0v-41.2h-18v10.3c-6-7.73-14.59-12-25.75-12-23.18,0-41.2,18-41.2,42.92s18,42.92,41.2,42.92c12,0,20.6-4.29,25.75-12v10.3h18v-41.2Zm-66.1,0c0-14.59,9.44-26.61,24.89-26.61,14.59,0,24.89,11.16,24.89,26.61,0,14.59-10.3,26.61-24.89,26.61-15.45-.86-24.89-12-24.89-26.61ZM504.72,690.13c-24,0-41.2,17.17-41.2,42.92S480.69,776,505.58,776c12,0,24-3.43,33.48-11.16l-8.58-12.88c-6.87,5.15-15.45,8.58-24,8.58-11.16,0-22.32-5.15-24.89-19.74h60.94v-6.87c.86-26.61-14.59-43.78-37.77-43.78h0Zm0,15.45c11.16,0,18.88,6.87,20.6,19.74H482.41c1.72-11.16,9.44-19.74,22.32-19.74Zm447.21,27.47V659.23h-18v42.92c-6-7.73-14.59-12-25.75-12-23.18,0-41.2,18-41.2,42.92S885,776,908.16,776c12,0,20.6-4.29,25.75-12v10.3h18v-41.2Zm-66.1,0c0-14.59,9.44-26.61,24.89-26.61,14.59,0,24.89,11.16,24.89,26.61,0,14.59-10.3,26.61-24.89,26.61-15.45-.86-24.89-12-24.89-26.61Zm-602.58,0v-41.2h-18v10.3c-6-7.73-14.59-12-25.75-12-23.18,0-41.2,18-41.2,42.92s18,42.92,41.2,42.92c12,0,20.6-4.29,25.75-12v10.3h18v-41.2Zm-67,0c0-14.59,9.44-26.61,24.89-26.61,14.59,0,24.89,11.16,24.89,26.61,0,14.59-10.3,26.61-24.89,26.61C225.75,758.8,216.31,747.65,216.31,733.05Z" transform="translate(0 0)"/><rect class="mca" x="364.81" y="66.1" width="270.39" height="485.84"/><path class="mcb" d="M382,309c0-98.71,46.35-186.27,117.6-242.92A307.12,307.12,0,0,0,309,0C138.2,0,0,138.2,0,309S138.2,618,309,618a307.12,307.12,0,0,0,190.56-66.1C428.33,496.14,382,407.73,382,309Z" transform="translate(0 0)"/><path class="mcc" d="M1000,309c0,170.82-138.2,309-309,309a307.12,307.12,0,0,1-190.56-66.1C572.54,495.28,618,407.73,618,309S571.68,122.75,500.43,66.1A307.12,307.12,0,0,1,691,0C861.81,0,1000,139.06,1000,309Z" transform="translate(0 0)"/></svg></div>
                <div class="card-icon amex">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 480 300"><defs><style>.ama{fill:url(#ama);}.amb,.amd{opacity:0.5;}.amc{fill:#369;}.amd,.amf{fill:#fff;}.amd{isolation:isolate;}.ame{fill:#2e77bc;}</style><linearGradient id="ama" x1="149" y1="96.01" x2="149" y2="416.59" gradientTransform="translate(91 -112.5)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#2e77bc"/><stop offset="0.88" stop-color="#0da6e0"/></linearGradient></defs><title>Amex Logo</title><path class="ama" d="M480,270a30.09,30.09,0,0,1-30,30H30A30.09,30.09,0,0,1,0,270V30A30.09,30.09,0,0,1,30,0H450a30.09,30.09,0,0,1,30,30Z"/><g class="amb"><path class="amc" d="M450,1a29,29,0,0,1,29,29V270a29,29,0,0,1-29,29H30A29,29,0,0,1,1,270V30A29,29,0,0,1,30,1H450m0-1H30A30.09,30.09,0,0,0,0,30V270a30.09,30.09,0,0,0,30,30H450a30.09,30.09,0,0,0,30-30V30A30.09,30.09,0,0,0,450,0Z"/></g><path class="amd" d="M31,2H449a30.09,30.09,0,0,1,30,30V31A30.09,30.09,0,0,0,449,1H31A30.09,30.09,0,0,0,1,31v1A30.09,30.09,0,0,1,31,2Z"/><path class="amd" d="M449,298H31A30.09,30.09,0,0,1,1,268v1a30.09,30.09,0,0,0,30,30H449a30.09,30.09,0,0,0,30-30v-1A30.09,30.09,0,0,1,449,298Z"/><path class="ame" d="M88.6,119.47l-6.94-17.14-6.9,17.14m166.71-6.83c-1.39.86-3,.89-5,.89H224.14V104h12.48a10.3,10.3,0,0,1,4.81.77,4,4,0,0,1,2.13,3.8,4.4,4.4,0,0,1-2.09,4.09m87.86,6.83-7-17.14-7,17.14ZM165.55,138h-10.4l0-33.68L140.41,138h-8.9l-14.74-33.71V138H96.15l-3.9-9.59H71.15L67.21,138h-11L74.36,95H89.42l17.24,40.71V95h16.55l13.27,29.17L148.67,95h16.88v43ZM207,138H173.1V95H207v9H183.24v7.75H206.4v8.82H183.24v8.59H207Zm47.76-31.42a12.11,12.11,0,0,1-7.15,11.46,11.79,11.79,0,0,1,5,3.62c1.43,2.14,1.68,4,1.68,7.89V138H244l0-5.42c0-2.59.24-6.31-1.6-8.38-1.48-1.51-3.74-1.84-7.39-1.84H224.14V138H214V95h23.32c5.18,0,9,.14,12.28,2.06s5.13,4.72,5.13,9.52M271,138H260.61V95H271Zm120,0H376.6l-19.22-32.27V138H336.73l-3.94-9.59H311.72L307.9,138H296c-4.93,0-11.17-1.1-14.7-4.76s-5.42-8.6-5.42-16.42c0-6.38,1.11-12.21,5.47-16.81,3.28-3.43,8.41-5,15.4-5h9.81v9.21H297c-3.7,0-5.79.56-7.8,2.55-1.73,1.81-2.92,5.23-2.92,9.74s.9,7.93,2.79,10.1c1.56,1.7,4.4,2.22,7.06,2.22h4.55L315,95h15.19l17.16,40.67V95h15.44L380.58,125V95H391v43ZM56.08,146.47H73.41l3.91-9.55h8.74l3.9,9.55H124v-7.3l3,7.33h17.69l3-7.44v7.41h84.7l0-15.68h1.64c1.15,0,1.48.15,1.48,2.07v13.61h43.81v-3.65a34.31,34.31,0,0,0,16.26,3.65H314.1l3.94-9.55h8.75l3.86,9.55h35.52V137.4l5.38,9.07H400v-60H371.83v7.08l-3.94-7.08H339v7.08l-3.62-7.08h-39c-6.54,0-12.28.92-16.92,3.5V86.5H252.47V90c-3-2.65-7-3.5-11.45-3.5H142.59L136,102,129.21,86.5h-31v7.08L94.8,86.5H68.36L56.08,115,42,146.47Z"/><path class="amf" d="M88.6,120.47l-6.94-17.14-6.9,17.14m166.71-6.83c-1.39.86-3,.89-5,.89H224.14V105h12.48a10.3,10.3,0,0,1,4.81.77,4,4,0,0,1,2.13,3.8,4.4,4.4,0,0,1-2.09,4.09m87.86,6.83-7-17.14-7,17.14ZM165.55,139h-10.4l0-33.68L140.41,139h-8.9l-14.74-33.71V139H96.15l-3.9-9.59H71.15L67.21,139h-11L74.36,96H89.42l17.24,40.71V96h16.55l13.27,29.17L148.67,96h16.88v43ZM207,139H173.1V96H207v9H183.24v7.75H206.4v8.82H183.24v8.59H207Zm47.76-31.42a12.11,12.11,0,0,1-7.15,11.46,11.79,11.79,0,0,1,5,3.62c1.43,2.14,1.68,4,1.68,7.89V139H244l0-5.42c0-2.59.24-6.31-1.6-8.38-1.48-1.51-3.74-1.84-7.39-1.84H224.14V139H214V96h23.32c5.18,0,9,.14,12.28,2.06s5.13,4.72,5.13,9.52M271,139H260.61V96H271Zm120,0H376.6l-19.22-32.27V139H336.73l-3.94-9.59H311.72L307.9,139H296c-4.93,0-11.17-1.1-14.7-4.76s-5.42-8.6-5.42-16.42c0-6.38,1.11-12.21,5.47-16.81,3.28-3.43,8.41-5,15.4-5h9.81v9.21H297c-3.7,0-5.79.56-7.8,2.55-1.73,1.81-2.92,5.23-2.92,9.74s.9,7.93,2.79,10.1c1.56,1.7,4.4,2.22,7.06,2.22h4.55L315,96h15.19l17.16,40.67V96h15.44L380.58,126V96H391v43ZM56.08,147.47H73.41l3.91-9.55h8.74l3.9,9.55H124v-7.3l3,7.33h17.69l3-7.44v7.41h84.7l0-15.68h1.64c1.15,0,1.48.15,1.48,2.07v13.61h43.81v-3.65a34.31,34.31,0,0,0,16.26,3.65H314.1l3.94-9.55h8.75l3.86,9.55h35.52V138.4l5.38,9.07H400v-60H371.83v7.08l-3.94-7.08H339v7.08l-3.62-7.08h-39c-6.54,0-12.28.92-16.92,3.5V87.5H252.47V91c-3-2.65-7-3.5-11.45-3.5H142.59L136,103,129.21,87.5h-31v7.08L94.8,87.5H68.36L56.08,116,42,147.47Z"/><path class="ame" d="M422.74,187V159.5h-25.4c-5.67,0-9.78,1.38-12.69,3.51V159.5H356.88c-4.44,0-9.65,1.11-12.11,3.51V159.5H295.18V163c-3.95-2.88-10.61-3.51-13.68-3.51H248.8V163c-3.12-3.06-10.06-3.51-14.3-3.51H197.9l-8.37,9.18-7.85-9.18H127v60h53.65l8.63-9.32,8.13,9.32,33.07,0V205.4h3.25c4.38.07,9.56-.11,14.13-2.11v16.19h27.27V203.84h1.32c1.68,0,1.85.07,1.85,1.77v13.86h82.86c5.26,0,10.76-1.36,13.81-3.84v3.84h26.28c5.47,0,10.81-.78,14.88-2.76v-.06A21.69,21.69,0,0,0,422.74,187Zm-188.56,9.59H221.52V211H201.81L189.32,196.8l-13,14.23H136.16V168H177l12.48,14.09L202.34,168h32.41c8.05,0,17.1,2.26,17.1,14.16S243,196.61,234.18,196.61Zm61-1.95c1.43,2.1,1.64,4.06,1.68,7.85V211H286.72v-5.38c0-2.58.24-6.41-1.64-8.41-1.48-1.54-3.74-1.91-7.44-1.91H266.8V211H256.61v-43H280c5.13,0,8.87.23,12.2,2,3.2,2,5.21,4.64,5.21,9.54a12,12,0,0,1-7.19,11.43A11.06,11.06,0,0,1,295.22,194.66Zm41.7-17.72H313.17v7.81h23.17v8.77H313.17v8.55l23.75,0V211H303.07V168h33.85ZM362.75,211H343v-9.21h19.68c1.92,0,3.29-.26,4.14-1.07a3.83,3.83,0,0,0,1.2-2.8,3.71,3.71,0,0,0-1.24-2.84,5.28,5.28,0,0,0-3.61-1c-9.49-.32-21.37.3-21.37-13.3,0-6.23,3.87-12.79,14.5-12.79h20.34v9.15H358c-1.84,0-3,.07-4.06.77a3.62,3.62,0,0,0,.7,6.29,11.49,11.49,0,0,0,3.95.49l5.46.15c5.5.14,9.29,1.1,11.58,3.46,2,2.07,3,4.68,3,9.1C378.69,206.71,373,211,362.75,211Zm52.2-4.15c-2.67,2.74-7,4.15-12.6,4.15H382.76v-9.21h19.51c1.93,0,3.29-.26,4.1-1.07a3.79,3.79,0,0,0,1.2-2.8,3.55,3.55,0,0,0-1.24-2.84,5.1,5.1,0,0,0-3.57-1c-9.52-.32-21.41.3-21.41-13.3,0-6.23,3.91-12.79,14.56-12.79h19.82v9.15h-18.1c-1.85,0-3.07.07-4.1.77a3.36,3.36,0,0,0-1.48,3.09,3.23,3.23,0,0,0,2.22,3.2,11.38,11.38,0,0,0,3.91.49l5.5.15c5.55.14,9.25,1.1,11.51,3.46a5.54,5.54,0,0,1,.94,1.06l-.35-.44a14.11,14.11,0,0,1-.82,17.9ZM171.69,176.94l11.1,12.52L171.2,202.07H146.26v-8.55h22.27v-8.77H146.26v-7.81h25.43Zm24.15,12.67,15.57-16.95v34.46Zm45.1-7.4c0,3.72-2.42,5.68-6.32,5.68H221.52V176.94h13.22C238.41,176.94,241,178.45,241,182.21Zm45.28-.63a4.65,4.65,0,0,1-2.1,4.13c-1.36.81-3,.88-5,.88H266.8v-9.65h12.49c1.81,0,3.61,0,4.84.77A4.1,4.1,0,0,1,286.23,181.58Z"/><path class="amf" d="M422.74,188V160.5h-25.4c-5.67,0-9.78,1.38-12.69,3.51V160.5H356.88c-4.44,0-9.65,1.11-12.11,3.51V160.5H295.18V164c-3.95-2.88-10.61-3.51-13.68-3.51H248.8V164c-3.12-3.06-10.06-3.51-14.3-3.51H197.9l-8.37,9.18-7.85-9.18H127v60h53.65l8.63-9.32,8.13,9.32,33.07,0V206.4h3.25c4.38.07,9.56-.11,14.13-2.11v16.19h27.27V204.84h1.32c1.68,0,1.85.07,1.85,1.77v13.86h82.86c5.26,0,10.76-1.36,13.81-3.84v3.84h26.28c5.47,0,10.81-.78,14.88-2.76v-.06A21.69,21.69,0,0,0,422.74,188Zm-188.56,9.59H221.52V212H201.81L189.32,197.8l-13,14.23H136.16V169H177l12.48,14.09L202.34,169h32.41c8.05,0,17.1,2.26,17.1,14.16S243,197.61,234.18,197.61Zm61-1.95c1.43,2.1,1.64,4.06,1.68,7.85V212H286.72v-5.38c0-2.58.24-6.41-1.64-8.41-1.48-1.54-3.74-1.91-7.44-1.91H266.8V212H256.61v-43H280c5.13,0,8.87.23,12.2,2,3.2,2,5.21,4.64,5.21,9.54a12,12,0,0,1-7.19,11.43A11.06,11.06,0,0,1,295.22,195.66Zm41.7-17.72H313.17v7.81h23.17v8.77H313.17v8.55l23.75,0V212H303.07V169h33.85ZM362.75,212H343v-9.21h19.68c1.92,0,3.29-.26,4.14-1.07a3.83,3.83,0,0,0,1.2-2.8,3.71,3.71,0,0,0-1.24-2.84,5.28,5.28,0,0,0-3.61-1c-9.49-.32-21.37.3-21.37-13.3,0-6.23,3.87-12.79,14.5-12.79h20.34v9.15H358c-1.84,0-3,.07-4.06.77a3.62,3.62,0,0,0,.7,6.29,11.49,11.49,0,0,0,3.95.49l5.46.15c5.5.14,9.29,1.1,11.58,3.46,2,2.07,3,4.68,3,9.1C378.69,207.71,373,212,362.75,212Zm52.2-4.15c-2.67,2.74-7,4.15-12.6,4.15H382.76v-9.21h19.51c1.93,0,3.29-.26,4.1-1.07a3.79,3.79,0,0,0,1.2-2.8,3.55,3.55,0,0,0-1.24-2.84,5.1,5.1,0,0,0-3.57-1c-9.52-.32-21.41.3-21.41-13.3,0-6.23,3.91-12.79,14.56-12.79h19.82v9.15h-18.1c-1.85,0-3.07.07-4.1.77a3.36,3.36,0,0,0-1.48,3.09,3.23,3.23,0,0,0,2.22,3.2,11.38,11.38,0,0,0,3.91.49l5.5.15c5.55.14,9.25,1.1,11.51,3.46a5.54,5.54,0,0,1,.94,1.06l-.35-.44a14.11,14.11,0,0,1-.82,17.9ZM171.69,177.94l11.1,12.52L171.2,203.07H146.26v-8.55h22.27v-8.77H146.26v-7.81h25.43Zm24.15,12.67,15.57-16.95v34.46Zm45.1-7.4c0,3.72-2.42,5.68-6.32,5.68H221.52V177.94h13.22C238.41,177.94,241,179.45,241,183.21Zm45.28-.63a4.65,4.65,0,0,1-2.1,4.13c-1.36.81-3,.88-5,.88H266.8v-9.65h12.49c1.81,0,3.61,0,4.84.77A4.1,4.1,0,0,1,286.23,182.58Z"/></svg>
                </div>
            </div>
        </section>
        <section class="container">
            <h2 class="title">Card Details</h2>

            <div class="input-wrap text">
                <label for="full-name">Full Name</label>
                <input type="text" id="full-name" class="form-text required" autocomplete="cc-name" placeholder="Full Name" />
                <span class="helper"></span>
            </div>

            <div class="input-wrap card-number text">
                <label for="card-number">Card Number</label>
                <input type="text" id="card-number" class="form-text required" autocomplete="cc-number" placeholder="&#9679;&#9679;&#9679;&#9679; &#9679;&#9679;&#9679;&#9679; &#9679;&#9679;&#9679;&#9679; &#9679;&#9679;&#9679;&#9679;" />
                <span class="helper"></span>
                <div class="card-icon visa"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 732 224.43"><defs><style>.via{fill:#004686;}.vib{fill:#ef9b11;}</style></defs><title>Visa Logo</title><polygon class="via" points="257.87 221.21 294.93 3.77 354.19 3.77 317.11 221.21 257.87 221.21"/><path class="via" d="M532.06,9.41A152.88,152.88,0,0,0,478.94.28C420.38.28,379.13,29.77,378.78,72c-.33,31.24,29.45,48.67,51.93,59.07,23.07,10.65,30.82,17.45,30.71,27-.15,14.57-18.42,21.23-35.46,21.23-23.72,0-36.32-3.29-55.79-11.41l-7.64-3.46-8.32,48.67c13.84,6.07,39.44,11.33,66,11.61,62.3,0,102.74-29.15,103.2-74.28.22-24.74-15.57-43.56-49.76-59.08-20.71-10.06-33.4-16.77-33.27-27,0-9,10.74-18.7,33.94-18.7A109.19,109.19,0,0,1,518.71,54l5.31,2.5,8-47.12Z" transform="translate(0 -0.28)"/><path class="via" d="M684,4.26h-45.8c-14.19,0-24.8,3.88-31,18l-88,199.25h62.23s10.18-26.79,12.48-32.67c6.8,0,67.26.09,75.9.09,1.78,7.61,7.21,32.58,7.21,32.58h55L684,4.26M611,144.41c4.9-12.53,23.61-60.78,23.61-60.78-.35.57,4.86-12.59,7.86-20.75l4,18.74s11.34,51.91,13.72,62.79H611Z" transform="translate(0 -0.28)"/><path class="via" d="M208.17,4.21l-58,148.27L144,122.36C133.16,87.62,99.51,50,61.88,31.15L114.94,221.3l62.7-.07,93.3-217H208.17Z" transform="translate(0 -0.28)"/><path class="vib" d="M96.32,4.08H.76L0,8.61c74.35,18,123.54,61.49,144,113.75L123.18,22.44c-3.59-13.77-14-17.87-26.86-18.36Z" transform="translate(0 -0.28)"/></svg></div>
                <div class="card-icon mastercard"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000.01 775.97"><defs><style>.mca{fill:#ff5f00;}.mcb{fill:#eb001b;}.mcc{fill:#f79e1b;}</style></defs><title>Mastercard Logo</title><path d="M182,774.26v-51.5c0-19.74-12-32.62-32.62-32.62-10.3,0-21.46,3.43-29.18,14.59-6-9.44-14.59-14.59-27.47-14.59-8.58,0-17.17,2.58-24,12v-10.3h-18v82.4h18V728.76c0-14.59,7.73-21.46,19.74-21.46s18,7.73,18,21.46v45.49h18V728.76c0-14.59,8.58-21.46,19.74-21.46,12,0,18,7.73,18,21.46v45.49Zm267-82.4H419.75V667h-18v24.89H385.41v16.31h16.31v37.77c0,18.88,7.73,30,28.33,30a48,48,0,0,0,22.32-6l-5.15-15.45a28.24,28.24,0,0,1-15.45,4.29c-8.58,0-12-5.15-12-13.73V708.16h29.18Zm152.79-1.72c-10.3,0-17.17,5.15-21.46,12v-10.3h-18v82.4h18V727.9c0-13.73,6-21.46,17.17-21.46a50.23,50.23,0,0,1,11.16,1.72L613.74,691c-3.43-.86-8.58-.86-12-.86Zm-230.9,8.58c-8.58-6-20.6-8.58-33.48-8.58-20.6,0-34.34,10.3-34.34,26.61,0,13.73,10.3,21.46,28.33,24l8.58.86c9.44,1.72,14.59,4.29,14.59,8.58,0,6-6.87,10.3-18.88,10.3a47.38,47.38,0,0,1-27.47-8.58l-8.58,13.73c9.44,6.87,22.32,10.3,35.19,10.3,24,0,37.77-11.16,37.77-26.61,0-14.59-11.16-22.32-28.33-24.89l-8.58-.86c-7.73-.86-13.73-2.58-13.73-7.73,0-6,6-9.44,15.45-9.44,10.3,0,20.6,4.29,25.75,6.87l7.73-14.59Zm479-8.58c-10.3,0-17.17,5.15-21.46,12v-10.3h-18v82.4h18V727.9c0-13.73,6-21.46,17.17-21.46a50.23,50.23,0,0,1,11.16,1.72L861.81,691c-3.43-.86-8.58-.86-12-.86Zm-230,42.92c0,24.89,17.17,42.92,43.78,42.92,12,0,20.6-2.58,29.18-9.44l-8.58-14.59c-6.87,5.15-13.73,7.73-21.46,7.73-14.59,0-24.89-10.3-24.89-26.61,0-15.45,10.3-25.75,24.89-26.61,7.73,0,14.59,2.58,21.46,7.73l8.58-14.59c-8.58-6.87-17.17-9.44-29.18-9.44-26.61,0-43.78,18-43.78,42.92h0Zm166.52,0v-41.2h-18v10.3c-6-7.73-14.59-12-25.75-12-23.18,0-41.2,18-41.2,42.92s18,42.92,41.2,42.92c12,0,20.6-4.29,25.75-12v10.3h18v-41.2Zm-66.1,0c0-14.59,9.44-26.61,24.89-26.61,14.59,0,24.89,11.16,24.89,26.61,0,14.59-10.3,26.61-24.89,26.61-15.45-.86-24.89-12-24.89-26.61ZM504.72,690.13c-24,0-41.2,17.17-41.2,42.92S480.69,776,505.58,776c12,0,24-3.43,33.48-11.16l-8.58-12.88c-6.87,5.15-15.45,8.58-24,8.58-11.16,0-22.32-5.15-24.89-19.74h60.94v-6.87c.86-26.61-14.59-43.78-37.77-43.78h0Zm0,15.45c11.16,0,18.88,6.87,20.6,19.74H482.41c1.72-11.16,9.44-19.74,22.32-19.74Zm447.21,27.47V659.23h-18v42.92c-6-7.73-14.59-12-25.75-12-23.18,0-41.2,18-41.2,42.92S885,776,908.16,776c12,0,20.6-4.29,25.75-12v10.3h18v-41.2Zm-66.1,0c0-14.59,9.44-26.61,24.89-26.61,14.59,0,24.89,11.16,24.89,26.61,0,14.59-10.3,26.61-24.89,26.61-15.45-.86-24.89-12-24.89-26.61Zm-602.58,0v-41.2h-18v10.3c-6-7.73-14.59-12-25.75-12-23.18,0-41.2,18-41.2,42.92s18,42.92,41.2,42.92c12,0,20.6-4.29,25.75-12v10.3h18v-41.2Zm-67,0c0-14.59,9.44-26.61,24.89-26.61,14.59,0,24.89,11.16,24.89,26.61,0,14.59-10.3,26.61-24.89,26.61C225.75,758.8,216.31,747.65,216.31,733.05Z" transform="translate(0 0)"/><rect class="mca" x="364.81" y="66.1" width="270.39" height="485.84"/><path class="mcb" d="M382,309c0-98.71,46.35-186.27,117.6-242.92A307.12,307.12,0,0,0,309,0C138.2,0,0,138.2,0,309S138.2,618,309,618a307.12,307.12,0,0,0,190.56-66.1C428.33,496.14,382,407.73,382,309Z" transform="translate(0 0)"/><path class="mcc" d="M1000,309c0,170.82-138.2,309-309,309a307.12,307.12,0,0,1-190.56-66.1C572.54,495.28,618,407.73,618,309S571.68,122.75,500.43,66.1A307.12,307.12,0,0,1,691,0C861.81,0,1000,139.06,1000,309Z" transform="translate(0 0)"/></svg></div>
                <div class="card-icon amex"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 480 300"><defs><style>.ama{fill:url(#ama);}.amb,.amd{opacity:0.5;}.amc{fill:#369;}.amd,.amf{fill:#fff;}.amd{isolation:isolate;}.ame{fill:#2e77bc;}</style><linearGradient id="ama" x1="149" y1="96.01" x2="149" y2="416.59" gradientTransform="translate(91 -112.5)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#2e77bc"/><stop offset="0.88" stop-color="#0da6e0"/></linearGradient></defs><title>Amex Logo</title><path class="ama" d="M480,270a30.09,30.09,0,0,1-30,30H30A30.09,30.09,0,0,1,0,270V30A30.09,30.09,0,0,1,30,0H450a30.09,30.09,0,0,1,30,30Z"/><g class="amb"><path class="amc" d="M450,1a29,29,0,0,1,29,29V270a29,29,0,0,1-29,29H30A29,29,0,0,1,1,270V30A29,29,0,0,1,30,1H450m0-1H30A30.09,30.09,0,0,0,0,30V270a30.09,30.09,0,0,0,30,30H450a30.09,30.09,0,0,0,30-30V30A30.09,30.09,0,0,0,450,0Z"/></g><path class="amd" d="M31,2H449a30.09,30.09,0,0,1,30,30V31A30.09,30.09,0,0,0,449,1H31A30.09,30.09,0,0,0,1,31v1A30.09,30.09,0,0,1,31,2Z"/><path class="amd" d="M449,298H31A30.09,30.09,0,0,1,1,268v1a30.09,30.09,0,0,0,30,30H449a30.09,30.09,0,0,0,30-30v-1A30.09,30.09,0,0,1,449,298Z"/><path class="ame" d="M88.6,119.47l-6.94-17.14-6.9,17.14m166.71-6.83c-1.39.86-3,.89-5,.89H224.14V104h12.48a10.3,10.3,0,0,1,4.81.77,4,4,0,0,1,2.13,3.8,4.4,4.4,0,0,1-2.09,4.09m87.86,6.83-7-17.14-7,17.14ZM165.55,138h-10.4l0-33.68L140.41,138h-8.9l-14.74-33.71V138H96.15l-3.9-9.59H71.15L67.21,138h-11L74.36,95H89.42l17.24,40.71V95h16.55l13.27,29.17L148.67,95h16.88v43ZM207,138H173.1V95H207v9H183.24v7.75H206.4v8.82H183.24v8.59H207Zm47.76-31.42a12.11,12.11,0,0,1-7.15,11.46,11.79,11.79,0,0,1,5,3.62c1.43,2.14,1.68,4,1.68,7.89V138H244l0-5.42c0-2.59.24-6.31-1.6-8.38-1.48-1.51-3.74-1.84-7.39-1.84H224.14V138H214V95h23.32c5.18,0,9,.14,12.28,2.06s5.13,4.72,5.13,9.52M271,138H260.61V95H271Zm120,0H376.6l-19.22-32.27V138H336.73l-3.94-9.59H311.72L307.9,138H296c-4.93,0-11.17-1.1-14.7-4.76s-5.42-8.6-5.42-16.42c0-6.38,1.11-12.21,5.47-16.81,3.28-3.43,8.41-5,15.4-5h9.81v9.21H297c-3.7,0-5.79.56-7.8,2.55-1.73,1.81-2.92,5.23-2.92,9.74s.9,7.93,2.79,10.1c1.56,1.7,4.4,2.22,7.06,2.22h4.55L315,95h15.19l17.16,40.67V95h15.44L380.58,125V95H391v43ZM56.08,146.47H73.41l3.91-9.55h8.74l3.9,9.55H124v-7.3l3,7.33h17.69l3-7.44v7.41h84.7l0-15.68h1.64c1.15,0,1.48.15,1.48,2.07v13.61h43.81v-3.65a34.31,34.31,0,0,0,16.26,3.65H314.1l3.94-9.55h8.75l3.86,9.55h35.52V137.4l5.38,9.07H400v-60H371.83v7.08l-3.94-7.08H339v7.08l-3.62-7.08h-39c-6.54,0-12.28.92-16.92,3.5V86.5H252.47V90c-3-2.65-7-3.5-11.45-3.5H142.59L136,102,129.21,86.5h-31v7.08L94.8,86.5H68.36L56.08,115,42,146.47Z"/><path class="amf" d="M88.6,120.47l-6.94-17.14-6.9,17.14m166.71-6.83c-1.39.86-3,.89-5,.89H224.14V105h12.48a10.3,10.3,0,0,1,4.81.77,4,4,0,0,1,2.13,3.8,4.4,4.4,0,0,1-2.09,4.09m87.86,6.83-7-17.14-7,17.14ZM165.55,139h-10.4l0-33.68L140.41,139h-8.9l-14.74-33.71V139H96.15l-3.9-9.59H71.15L67.21,139h-11L74.36,96H89.42l17.24,40.71V96h16.55l13.27,29.17L148.67,96h16.88v43ZM207,139H173.1V96H207v9H183.24v7.75H206.4v8.82H183.24v8.59H207Zm47.76-31.42a12.11,12.11,0,0,1-7.15,11.46,11.79,11.79,0,0,1,5,3.62c1.43,2.14,1.68,4,1.68,7.89V139H244l0-5.42c0-2.59.24-6.31-1.6-8.38-1.48-1.51-3.74-1.84-7.39-1.84H224.14V139H214V96h23.32c5.18,0,9,.14,12.28,2.06s5.13,4.72,5.13,9.52M271,139H260.61V96H271Zm120,0H376.6l-19.22-32.27V139H336.73l-3.94-9.59H311.72L307.9,139H296c-4.93,0-11.17-1.1-14.7-4.76s-5.42-8.6-5.42-16.42c0-6.38,1.11-12.21,5.47-16.81,3.28-3.43,8.41-5,15.4-5h9.81v9.21H297c-3.7,0-5.79.56-7.8,2.55-1.73,1.81-2.92,5.23-2.92,9.74s.9,7.93,2.79,10.1c1.56,1.7,4.4,2.22,7.06,2.22h4.55L315,96h15.19l17.16,40.67V96h15.44L380.58,126V96H391v43ZM56.08,147.47H73.41l3.91-9.55h8.74l3.9,9.55H124v-7.3l3,7.33h17.69l3-7.44v7.41h84.7l0-15.68h1.64c1.15,0,1.48.15,1.48,2.07v13.61h43.81v-3.65a34.31,34.31,0,0,0,16.26,3.65H314.1l3.94-9.55h8.75l3.86,9.55h35.52V138.4l5.38,9.07H400v-60H371.83v7.08l-3.94-7.08H339v7.08l-3.62-7.08h-39c-6.54,0-12.28.92-16.92,3.5V87.5H252.47V91c-3-2.65-7-3.5-11.45-3.5H142.59L136,103,129.21,87.5h-31v7.08L94.8,87.5H68.36L56.08,116,42,147.47Z"/><path class="ame" d="M422.74,187V159.5h-25.4c-5.67,0-9.78,1.38-12.69,3.51V159.5H356.88c-4.44,0-9.65,1.11-12.11,3.51V159.5H295.18V163c-3.95-2.88-10.61-3.51-13.68-3.51H248.8V163c-3.12-3.06-10.06-3.51-14.3-3.51H197.9l-8.37,9.18-7.85-9.18H127v60h53.65l8.63-9.32,8.13,9.32,33.07,0V205.4h3.25c4.38.07,9.56-.11,14.13-2.11v16.19h27.27V203.84h1.32c1.68,0,1.85.07,1.85,1.77v13.86h82.86c5.26,0,10.76-1.36,13.81-3.84v3.84h26.28c5.47,0,10.81-.78,14.88-2.76v-.06A21.69,21.69,0,0,0,422.74,187Zm-188.56,9.59H221.52V211H201.81L189.32,196.8l-13,14.23H136.16V168H177l12.48,14.09L202.34,168h32.41c8.05,0,17.1,2.26,17.1,14.16S243,196.61,234.18,196.61Zm61-1.95c1.43,2.1,1.64,4.06,1.68,7.85V211H286.72v-5.38c0-2.58.24-6.41-1.64-8.41-1.48-1.54-3.74-1.91-7.44-1.91H266.8V211H256.61v-43H280c5.13,0,8.87.23,12.2,2,3.2,2,5.21,4.64,5.21,9.54a12,12,0,0,1-7.19,11.43A11.06,11.06,0,0,1,295.22,194.66Zm41.7-17.72H313.17v7.81h23.17v8.77H313.17v8.55l23.75,0V211H303.07V168h33.85ZM362.75,211H343v-9.21h19.68c1.92,0,3.29-.26,4.14-1.07a3.83,3.83,0,0,0,1.2-2.8,3.71,3.71,0,0,0-1.24-2.84,5.28,5.28,0,0,0-3.61-1c-9.49-.32-21.37.3-21.37-13.3,0-6.23,3.87-12.79,14.5-12.79h20.34v9.15H358c-1.84,0-3,.07-4.06.77a3.62,3.62,0,0,0,.7,6.29,11.49,11.49,0,0,0,3.95.49l5.46.15c5.5.14,9.29,1.1,11.58,3.46,2,2.07,3,4.68,3,9.1C378.69,206.71,373,211,362.75,211Zm52.2-4.15c-2.67,2.74-7,4.15-12.6,4.15H382.76v-9.21h19.51c1.93,0,3.29-.26,4.1-1.07a3.79,3.79,0,0,0,1.2-2.8,3.55,3.55,0,0,0-1.24-2.84,5.1,5.1,0,0,0-3.57-1c-9.52-.32-21.41.3-21.41-13.3,0-6.23,3.91-12.79,14.56-12.79h19.82v9.15h-18.1c-1.85,0-3.07.07-4.1.77a3.36,3.36,0,0,0-1.48,3.09,3.23,3.23,0,0,0,2.22,3.2,11.38,11.38,0,0,0,3.91.49l5.5.15c5.55.14,9.25,1.1,11.51,3.46a5.54,5.54,0,0,1,.94,1.06l-.35-.44a14.11,14.11,0,0,1-.82,17.9ZM171.69,176.94l11.1,12.52L171.2,202.07H146.26v-8.55h22.27v-8.77H146.26v-7.81h25.43Zm24.15,12.67,15.57-16.95v34.46Zm45.1-7.4c0,3.72-2.42,5.68-6.32,5.68H221.52V176.94h13.22C238.41,176.94,241,178.45,241,182.21Zm45.28-.63a4.65,4.65,0,0,1-2.1,4.13c-1.36.81-3,.88-5,.88H266.8v-9.65h12.49c1.81,0,3.61,0,4.84.77A4.1,4.1,0,0,1,286.23,181.58Z"/><path class="amf" d="M422.74,188V160.5h-25.4c-5.67,0-9.78,1.38-12.69,3.51V160.5H356.88c-4.44,0-9.65,1.11-12.11,3.51V160.5H295.18V164c-3.95-2.88-10.61-3.51-13.68-3.51H248.8V164c-3.12-3.06-10.06-3.51-14.3-3.51H197.9l-8.37,9.18-7.85-9.18H127v60h53.65l8.63-9.32,8.13,9.32,33.07,0V206.4h3.25c4.38.07,9.56-.11,14.13-2.11v16.19h27.27V204.84h1.32c1.68,0,1.85.07,1.85,1.77v13.86h82.86c5.26,0,10.76-1.36,13.81-3.84v3.84h26.28c5.47,0,10.81-.78,14.88-2.76v-.06A21.69,21.69,0,0,0,422.74,188Zm-188.56,9.59H221.52V212H201.81L189.32,197.8l-13,14.23H136.16V169H177l12.48,14.09L202.34,169h32.41c8.05,0,17.1,2.26,17.1,14.16S243,197.61,234.18,197.61Zm61-1.95c1.43,2.1,1.64,4.06,1.68,7.85V212H286.72v-5.38c0-2.58.24-6.41-1.64-8.41-1.48-1.54-3.74-1.91-7.44-1.91H266.8V212H256.61v-43H280c5.13,0,8.87.23,12.2,2,3.2,2,5.21,4.64,5.21,9.54a12,12,0,0,1-7.19,11.43A11.06,11.06,0,0,1,295.22,195.66Zm41.7-17.72H313.17v7.81h23.17v8.77H313.17v8.55l23.75,0V212H303.07V169h33.85ZM362.75,212H343v-9.21h19.68c1.92,0,3.29-.26,4.14-1.07a3.83,3.83,0,0,0,1.2-2.8,3.71,3.71,0,0,0-1.24-2.84,5.28,5.28,0,0,0-3.61-1c-9.49-.32-21.37.3-21.37-13.3,0-6.23,3.87-12.79,14.5-12.79h20.34v9.15H358c-1.84,0-3,.07-4.06.77a3.62,3.62,0,0,0,.7,6.29,11.49,11.49,0,0,0,3.95.49l5.46.15c5.5.14,9.29,1.1,11.58,3.46,2,2.07,3,4.68,3,9.1C378.69,207.71,373,212,362.75,212Zm52.2-4.15c-2.67,2.74-7,4.15-12.6,4.15H382.76v-9.21h19.51c1.93,0,3.29-.26,4.1-1.07a3.79,3.79,0,0,0,1.2-2.8,3.55,3.55,0,0,0-1.24-2.84,5.1,5.1,0,0,0-3.57-1c-9.52-.32-21.41.3-21.41-13.3,0-6.23,3.91-12.79,14.56-12.79h19.82v9.15h-18.1c-1.85,0-3.07.07-4.1.77a3.36,3.36,0,0,0-1.48,3.09,3.23,3.23,0,0,0,2.22,3.2,11.38,11.38,0,0,0,3.91.49l5.5.15c5.55.14,9.25,1.1,11.51,3.46a5.54,5.54,0,0,1,.94,1.06l-.35-.44a14.11,14.11,0,0,1-.82,17.9ZM171.69,177.94l11.1,12.52L171.2,203.07H146.26v-8.55h22.27v-8.77H146.26v-7.81h25.43Zm24.15,12.67,15.57-16.95v34.46Zm45.1-7.4c0,3.72-2.42,5.68-6.32,5.68H221.52V177.94h13.22C238.41,177.94,241,179.45,241,183.21Zm45.28-.63a4.65,4.65,0,0,1-2.1,4.13c-1.36.81-3,.88-5,.88H266.8v-9.65h12.49c1.81,0,3.61,0,4.84.77A4.1,4.1,0,0,1,286.23,182.58Z"/></svg></div>
            </div>

            <div class="input-wrap text left">
                <label for="expiry-date">Expiry Date</label>
                <input type="text" id="expiry-date" class="form-text required" autocomplete="cc-exp" placeholder="mm / yy" />
                <span class="helper"></span>
            </div>

            <div class="input-wrap text right">
                <label for="cvc">Security Code</label>
                <input type="text" id="cvc" class="form-text required" placeholder="123" />
                <span class="helper"></span>
            </div>
        </section>
        <section class="container no-flex form-footer">
            <div class="agreement">
                <input type="checkbox" name="agreement" id="agreement">

                <span id="agreementSvg"><svg id="fe23f8f6-4194-4c24-82b9-d63b3ce8db2c" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1550 1188"><path  d="M1550,232q0,40-28,68L798,1024,662,1160q-28,28-68,28t-68-28L390,1024,28,662Q0,634,0,594t28-68L164,390q28-28,68-28t68,28L594,685,1250,28q28-28,68-28t68,28l136,136Q1550,192,1550,232Z"/></svg></span>

                <label for="agreement" id="agreement-label">By completing your order you confirm that you accept the terms and conditions and that your membership will automatically renew on a monthly basis and your credit card will automatically be charged the applicable monthly fee. You are free to cancel your subscription at anytime.

                </label>
                <span class="helper"></span>
            </div>
            <div class="input-wrap submit">
                <button type="submit" class="form-submit txt-white bg-blue btn-circle " name="submit" disabled>
                    <span class="loading"></span>
                    <svg width="20" height="20" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M640 768h512v-192q0-106-75-181t-181-75-181 75-75 181v192zm832 96v576q0 40-28 68t-68 28h-960q-40 0-68-28t-28-68v-576q0-40 28-68t68-28h32v-192q0-184 132-316t316-132 316 132 132 316v192h32q40 0 68 28t28 68z"/></svg>
                    <span class="text inactive">Pay $9.99</span>
                    <span class="text active">Processing...</span>
                </button>
            </div>

            <p>By registering you confirm that you agree with our <br><a href="/terms" class="txt-blue">Terms &amp; Conditions</a> and <a href="/privacy" class="txt-blue">Privacy Policy</a></p>
        </section>
        {!! csrf_field() !!}
        <input type="hidden" id="stripe_id" value="">
        <input type="hidden" id="card_brand" value="">
        <input type="hidden" id="card_last_four" value="">
    </form>
</section>
@endsection