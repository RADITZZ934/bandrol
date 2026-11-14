<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="google-adsense-account" content="ca-pub-2423097738999520">
    <link rel="shortcut icon" href="{{ url('assets/img/LOGO_LBI.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/print.css') }}">
    <link rel="stylesheet" href="{{ url('assets/fontawesome/css/all.min.css') }}">
    <title>LB | BANDROL</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Anton&display=swap');

        .bebas-neue-regular {
            font-family: "Bebas Neue", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .anton-regular {
            font-family: "Anton", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .arial-black-font {
            font-family: "Arial Black", sans-serif;
        }

        .price_color {
            color: #ff0000;
        }

        .title_color {
            color: rgb(0, 203, 0);
        }

        .my_outline {
            color: rgb(255, 255, 255);
            /* Warna teks */
            text-shadow: -1px -1px 0 #000,
                1px -1px 0 #000,
                -1px 1px 0 #000,
                1px 1px 0 #000;
        }
    </style>
</head>

<body>

    <div class="row container-fluid mx-auto mt-3">
        <div class="col-md-12 col-lg-12 col-sm-12 col-12 col-xs-12">
            <div class="card shadow mb-5 bg-body-tertiary rounded">
                <div class="card-body">
                    <section>
                        <div class="row container-fluid justify-content-center mt-5">
                            <div class="col-md-12 text-center bebas-neue-regular text-secondary mb-3">
                                <h3>MAKE BANDROL LB</h3>
                            </div>
                            <!-- New row for form elements and image -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <!-- Left column: form elements -->
                                    <div class="mb-3">
                                        <select class="form-select" id="bazaarSelect"
                                            aria-label="Default select example">
                                            <option selected hidden>Open this select menu</option>
                                            <option value="1">LASKAR BUAH F4 LANDSCAPE</option>
                                            <option value="15">LASKAR BUAH F4 2 LANDSCAPE</option>
                                            <option value="3">LASKAR BUAH F4 2 POTRAIT</option>
                                            <option value="7">LASKAR BUAH F4 4 POTRAIT</option>
                                            <option value="4">LASKAR BUAH F4 30 LANDSCAPE</option>
                                            <option value="11">LASKAR BUAH F4 18 POTRAIT</option>
                                            <option value="13">LASKAR BUAH F4 PROMO LANDSCAPE</option>
                                            <option value="9">LASKAR BUAH F4 2 PROMO POTRAIT</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" class="form-control" name="filebandrol" id="filebandrol"
                                            accept=".xls,.xlsx" multiple>
                                        <span class="ms-3 fw-lighter fst-italic"><span class="text-danger">*
                                            </span>Memilih file bisa lebih dari satu</span>
                                    </div>
                                    <div class="col-md-12 text-center mb-3">
                                        <button id="printButton"
                                            class="btn btn-warning text-light rounded-0 btn-loading"
                                            style="display: none;">Print Bandrol</button>
                                        <button id="printButton2"
                                            class="btn btn-success text-light rounded-0 btn-loading"
                                            style="display: none;">Print Bandrol</button>
                                        <button id="printButton3"
                                            class="btn btn-danger text-light rounded-0 btn-loading"
                                            style="display: none;">Print Bandrol</button>
                                        <button id="printButton4"
                                            class="btn btn-primary text-light rounded-0 btn-loading"
                                            style="display: none;">Print Bandrol</button>
                                        <button id="printButton5"
                                            class="btn btn-secondary text-light rounded-0 btn-loading"
                                            style="display: none;">Print Bandrol</button>
                                        <button id="printButton6"
                                            class="btn btn-primary text-light rounded-0 btn-loading"
                                            style="display: none;">Print Bandrol</button>
                                        <button id="printButton7"
                                            class="btn btn-danger text-light rounded-0 btn-loading"
                                            style="display: none;">Print Bandrol</button>
                                    </div>
                                    <div class="col-md-12 text-center text-body-secondary mb-4">

                                        <h6>© IT SUPPORT All Right Reserved 2024</h6>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Right column: image card -->
                                    <div class="card p-4 shadow">
                                        <div class="ratio ratio-16x9">
                                            <img id="templateImage" src="{{ url('assets/img/bandrol/template1.png') }}"
                                                class="img-fluid rounded" alt="Template Preview">
                                        </div> <br>
                                    </div> <br>
                                </div> <br>
                            </div> <br>
                            <!-- Copyright and buttons -->


                        </div>
                        <div id="cardsContainer" class="col-md-12 mb-3 justify-content-center text-center"></div>
                    </section>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#bazaarSelect, #bandrolSelect').change(function () {
                var bazaar = $('#bazaarSelect').val();
                var bandrol = $('#bandrolSelect').val();
                if (bazaar && bandrol) {
                    console.log('Bazaar:', bazaar, 'Bandrol:', bandrol);
                }

                var selectedValue = $(this).val();

                // Sembunyikan kedua tombol terlebih dahulu
                $('#printButton').hide();
                $('#printButton2').hide();
                $('#printButton3').hide();
                $('#printButton4').hide();
                $('#printButton5').hide();
                $('#printButton6').hide();
                $('#printButton7').hide();

                // Tampilkan tombol sesuai dengan nilai yang dipilih
                if (['1', '2', '13', '14'].includes(selectedValue)) {
                    $('#printButton').show();
                } else if (['3', '5'].includes(selectedValue)) {
                    $('#printButton2').show();
                } else if (['7', '8'].includes(selectedValue)) {
                    $('#printButton3').show();
                } else if (['9', '10'].includes(selectedValue)) {
                    $('#printButton4').show();
                } else if (['4', '6'].includes(selectedValue)) {
                    $('#printButton5').show();
                } else if (['11', '12'].includes(selectedValue)) {
                    $('#printButton6').show();
                } else if (['15', '16'].includes(selectedValue)) {
                    $('#printButton7').show();
                }
            });

            function formatPrice(price) {
                return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            function generateCardHtml(bazaar, namaProduk, price, uom, nameStore, discountMember) {
                const totalMemberPrice = price - discountMember;
                const formattedPrice = formatPrice(price);
                const formattedTotalMemberPrice = formatPrice(totalMemberPrice);
                if (bazaar == '1') {
                    if (discountMember > 0) {
                        return `
                        <div class="card-top">
                            <div class="bandrol-size lbmb1f4l">
                            <div class="bandrol-border1">
                                <div class="text-container1">
                                    <span class="resizable-text1 product-name">${namaProduk}</span>
                                </div>
                                <div class="bandrol-border4"></div>
                                <div class="text-container2">
                                    <div class="bandrol-rp">
                                        <div class="logo">
                                            <img src="{{ url('assets/img/logo/lbt.png') }}" style="width:75%" class="img-fluid text-end" alt="bazzar">
                                        </div><br>
                                            <div style="background-color: yellow">
                                                <span style="align-items: center;text-align:center">RP.</span><br>
                                                    <span style="align-items: center;text-align:center"
                                                        class="bandrol-uom uom">/${uom}
                                                    </span>
                                            </div>
                                    </div>
                                    <span class="resizable-text2 price">${formattedPrice}
                                    </span>
                                </div>

                                <div class="bandrol-toko">
                                    <div class="text-container3">
                                        <label class="bandrol-member">MEMBER </label>
                                        <span class="resizable-text3">
                                            <span style="vertical-align: top; font-weight:bold; font-family: Poppins, serif;"
                                                class="harga-uom">RP.</span>

                                            <span class="member-price">${formattedTotalMemberPrice}
                                            </span>

                                            <span style="font-weight:bold; font-family: Poppins, serif;"
                                                class="harga-uom uom">${uom}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        `;
                    } else {
                        return `
                        <div class="card-top">
                            <div class="bandrol-size lbb1f4l">
                                <div class="bandrol-border1">
                                    <div class="bandrol-border2">
                                        <div class="bandrol-border3">
                                            <div class="text-container1">
                                                <span class="resizable-text1 product-name">${namaProduk}</span>
                                            </div>
                                            <div class="bandrol-border4"></div>
                                            <div class="text-container2">
                                                <label class="bandrol-rp">RP. </label>
                                                <span class="resizable-text2 price">${formattedPrice}
                                                </span>
                                                <label class="bandrol-uom uom">/${uom}
                                                </label>
                                            </div>
                                            <div class="bandrol-toko">
                                                <div class="text-container3">
                                                    <div class="logo left">
                                                        <img src="{{ url('assets/img/logo/lbt.png') }}" style="width:75%" class="img-fluid text-end" alt="bazzar">
                                                    </div>
                                                    <span class="resizable-text3 store">${nameStore}
                                                    </span>
                                                    <div class="logo right">
                                                       <img src="{{ url('assets/img/logo/lbt.png') }}" style="width:75%" class="img-fluid text-end" alt="bazzar">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                           ` ;
                    }
                } else if (bazaar == '2') {
                    if (discountMember > 0) {
                        return `
                        <div class="card-top">
                            <div class="bandrol-size lbmb1f4l">
                            <div class="bandrol-border1">
                                <div class="text-container1">
                                    <span class="resizable-text1 product-name">${namaProduk}</span>
                                </div>
                                <div class="bandrol-border4"></div>
                                <div class="text-container2">
                                    <div class="bandrol-rp">
                                        <div class="logo">
                                            <img src="{{ url('assets/img/logo/bz.png') }}" style="width:75%" class="img-fluid text-end" alt="bazzar">
                                        </div><br>
                                            <div style="background-color: yellow">
                                                <span style="align-items: center;text-align:center">RP.</span><br>
                                                    <span style="align-items: center;text-align:center"
                                                        class="bandrol-uom uom">/${uom}
                                                    </span>
                                            </div>
                                    </div>
                                    <span class="resizable-text2 price">${formattedPrice}
                                    </span>
                                </div>

                                <div class="bandrol-toko">
                                    <div class="text-container3">
                                        <label class="bandrol-member">MEMBER </label>
                                        <span class="resizable-text3">
                                            <span style="vertical-align: top; font-weight:bold; font-family: Poppins, serif;"
                                                class="harga-uom">RP.</span>

                                            <span class="member-price">${formattedTotalMemberPrice}
                                            </span>

                                            <span style="font-weight:bold; font-family: Poppins, serif;"
                                                class="harga-uom uom">${uom}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        `;
                    } else {
                        return `
                         <div class="card-top">
                            <div class="bandrol-size bzb1f4l">
                                <div class="bandrol-border1">
                                    <div class="bandrol-border2">
                                        <div class="bandrol-border3">
                                            <div class="text-container1">
                                                <span class="resizable-text1 product-name">${namaProduk}</span>
                                            </div>
                                            <div class="bandrol-border4"></div>
                                            <div class="text-container2">
                                                <label class="bandrol-rp">RP. </label>
                                                <span class="resizable-text2 price">${formattedPrice}
                                                </span>
                                                <label class="bandrol-uom uom">/${uom}
                                                </label>
                                            </div>
                                            <div class="bandrol-toko">
                                                <div class="text-container3">
                                                    <div class="logo left">
                                                        <img src="{{ url('assets/img/logo/bz.png') }}" style="width:75%" class="img-fluid text-end" alt="bazzar">
                                                    </div>
                                                    <span class="resizable-text3 store">${nameStore}
                                                    </span>
                                                    <div class="logo right">
                                                       <img src="{{ url('assets/img/logo/bz.png') }}" style="width:75%" class="img-fluid text-end" alt="bazzar">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                           ` ;
                    }
                }
                else if (bazaar == '3') {
                    if (discountMember > 0) {
                        return `
                        <div class="card-top">
                            <div class="bandrol-size lbmb2f4p">
                            <div class="bandrol-border1">
                                <div class="text-container1">
                                    <span class="resizable-text1 product-name">${namaProduk}</span>
                                </div>
                                <div class="bandrol-border4"></div>
                                <div class="text-container2">
                                    <div class="bandrol-rp">
                                        <div class="logo">
                                            <img src="{{ url('assets/img/logo/lbt.png') }}" style="width:75%" class="img-fluid text-end" alt="bazzar">
                                        </div><br>
                                            <div style="background-color: yellow">
                                                <span style="align-items: center;text-align:center">RP.</span><br>
                                                    <span style="align-items: center;text-align:center"
                                                        class="bandrol-uom uom">/${uom}
                                                    </span>
                                            </div>
                                    </div>
                                    <span class="resizable-text2 price">${formattedPrice}
                                    </span>
                                </div>

                                <div class="bandrol-toko">
                                    <div class="text-container3">
                                        <label class="bandrol-member">MEMBER </label>
                                        <span class="resizable-text3">
                                            <span style="vertical-align: top; font-weight:bold; font-family: Poppins, serif;"
                                                class="harga-uom">RP.</span>

                                            <span class="member-price">${formattedTotalMemberPrice}
                                            </span>

                                            <span style="font-weight:bold; font-family: Poppins, serif;"
                                                class="harga-uom uom">${uom}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        `;
                    } else {
                        return `
                        <div class="card-top">
                            <div class="bandrol-size lbb2f4p">
                                <div class="bandrol-border1">
                                    <div class="bandrol-border2">
                                        <div class="bandrol-border3">
                                            <div class="text-container1">
                                                <span class="resizable-text1 product-name">${namaProduk}</span>
                                            </div>
                                            <div class="bandrol-border4"></div>
                                            <div class="text-container2">
                                                <label class="bandrol-rp">RP. </label>
                                                <span class="resizable-text2 price">${formattedPrice}
                                                </span>
                                                <label class="bandrol-uom uom">/${uom}
                                                </label>
                                            </div>
                                            <div class="bandrol-toko">
                                                <div class="text-container3">
                                                    <div class="logo left">
                                                        <img src="{{ url('assets/img/logo/lbt.png') }}" style="width:75%" class="img-fluid text-end" alt="bazzar">
                                                    </div>
                                                    <span class="resizable-text3 store">${nameStore}
                                                    </span>
                                                    <div class="logo right">
                                                       <img src="{{ url('assets/img/logo/lbt.png') }}" style="width:75%" class="img-fluid text-end" alt="bazzar">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                           ` ;
                    }
                } else if (bazaar == '5') {
                    if (discountMember > 0) {
                        return `
                        <div class="card-top">
                            <div class="bandrol-size lbmb2f4p">
                            <div class="bandrol-border1">
                                <div class="text-container1">
                                    <span class="resizable-text1 product-name">${namaProduk}</span>
                                </div>
                                <div class="bandrol-border4"></div>
                                <div class="text-container2">
                                    <div class="bandrol-rp">
                                        <div class="logo">
                                            <img src="{{ url('assets/img/logo/bz.png') }}" style="width:75%" class="img-fluid text-end" alt="bazzar">
                                        </div><br>
                                            <div style="background-color: yellow">
                                                <span style="align-items: center;text-align:center">RP.</span><br>
                                                    <span style="align-items: center;text-align:center"
                                                        class="bandrol-uom uom">/${uom}
                                                    </span>
                                            </div>
                                    </div>
                                    <span class="resizable-text2 price">${formattedPrice}
                                    </span>
                                </div>

                                <div class="bandrol-toko">
                                    <div class="text-container3">
                                        <label class="bandrol-member">MEMBER </label>
                                        <span class="resizable-text3">
                                            <span style="vertical-align: top; font-weight:bold; font-family: Poppins, serif;"
                                                class="harga-uom">RP.</span>

                                            <span class="member-price">${formattedTotalMemberPrice}
                                            </span>

                                            <span style="font-weight:bold; font-family: Poppins, serif;"
                                                class="harga-uom uom">${uom}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        `;
                    } else {
                        return `
                        <div class="card-top">
                            <div class="bandrol-size bzb2f4p">
                                <div class="bandrol-border1">
                                    <div class="bandrol-border2">
                                        <div class="bandrol-border3">
                                            <div class="text-container1">
                                                <span class="resizable-text1 product-name">${namaProduk}</span>
                                            </div>
                                            <div class="bandrol-border4"></div>
                                            <div class="text-container2">
                                                <label class="bandrol-rp">RP. </label>
                                                <span class="resizable-text2 price">${formattedPrice}
                                                </span>
                                                <label class="bandrol-uom uom">/${uom}
                                                </label>
                                            </div>
                                            <div class="bandrol-toko">
                                                <div class="text-container3">
                                                    <div class="logo left">
                                                        <img src="{{ url('assets/img/logo/bz.png') }}" style="width:75%" class="img-fluid text-end" alt="bazzar">
                                                    </div>
                                                    <span class="resizable-text3 store">${nameStore}
                                                    </span>
                                                    <div class="logo right">
                                                       <img src="{{ url('assets/img/logo/bz.png') }}" style="width:75%" class="img-fluid text-end" alt="bazzar">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                           ` ;
                    }
                }
                else if (bazaar == '7') {
                    return `
             <div class="card-top">
                            <div class="bandrol-size lbb4f4p">
                                <div class="bandrol-border1">
                                    <div class="bandrol-border2">
                                        <div class="bandrol-border3">
                                            <div class="text-container1">
                                                <span class="resizable-text1 product-name">${namaProduk}</span>
                                            </div>
                                            <div class="bandrol-border4"></div>
                                            <div class="text-container2">
                                                <label class="bandrol-rp">RP. </label>
                                                <span class="resizable-text2 price">${formattedPrice}
                                                </span>
                                                <label class="bandrol-uom uom">/${uom}
                                                </label>
                                            </div>
                                            <div class="bandrol-toko">
                                                <div class="text-container3">
                                                    <div class="logo left">
                                                        <img src="{{ url('assets/img/logo/lbt.png') }}" style="width:75%" class="img-fluid text-end" alt="bazzar">
                                                    </div>
                                                    <span class="resizable-text3 store">${nameStore}
                                                    </span>
                                                    <div class="logo right">
                                                       <img src="{{ url('assets/img/logo/lbt.png') }}" style="width:75%" class="img-fluid text-end" alt="bazzar">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            `;
                }
                else if (bazaar == '8') {
                    return `
               <div class="card-top">
                            <div class="bandrol-size bzb4f4p">
                                <div class="bandrol-border1">
                                    <div class="bandrol-border2">
                                        <div class="bandrol-border3">
                                            <div class="text-container1">
                                                <span class="resizable-text1 product-name">${namaProduk}</span>
                                            </div>
                                            <div class="bandrol-border4"></div>
                                            <div class="text-container2">
                                                <label class="bandrol-rp">RP. </label>
                                                <span class="resizable-text2 price">${formattedPrice}
                                                </span>
                                                <label class="bandrol-uom uom">/${uom}
                                                </label>
                                            </div>
                                            <div class="bandrol-toko">
                                                <div class="text-container3">
                                                    <div class="logo left">
                                                        <img src="{{ url('assets/img/logo/bz.png') }}" style="width:75%" class="img-fluid text-end" alt="bazzar">
                                                    </div>
                                                    <span class="resizable-text3 store">${nameStore}
                                                    </span>
                                                    <div class="logo right">
                                                       <img src="{{ url('assets/img/logo/bz.png') }}" style="width:75%" class="img-fluid text-end" alt="bazzar">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            `;
                }
                else if (bazaar == '4') {
                    return `
                    <div class="card-top">
                        <div class="bandrol-size lbb25l">
                             <div class="bandrol-border0">
                            <div class="bandrol-border1"></div>
                            <div class="text-container1">
                                <span class="resizable-text1 product-name">${namaProduk}</span>
                            </div>
                            <div class="text-container2">
                                <label class="bandrol-rp">RP. </label>
                                <span class="resizable-text2 price">${formattedPrice}
                                </span>
                            </div>
                            <div class="text-container3">
                                <img src="{{ url('assets/img/logo/lbbt.png') }}" style="width: 100%;">
                            </div>
                        </div>   </div>
                    </div>
                    `;
                } else if (bazaar == '6') {
                    return `
                    <div class="card-top">
                        <div class="bandrol-size lbb25l">
                             <div class="bandrol-border0">
                            <div class="bandrol-border1"></div>
                            <div class="text-container1">
                                <span class="resizable-text1 product-name">${namaProduk}</span>
                            </div>
                            <div class="text-container2">
                                <label class="bandrol-rp">RP. </label>
                                <span class="resizable-text2 price">${formattedPrice}
                                </span>
                            </div>
                            <div class="text-container3">
                                <img src="{{ url('assets/img/logo/bzbt.png') }}" style="width: 100%;">
                            </div>
                        </div>   </div>
                    </div>
                    `;
                } else if (bazaar == '9') {
                    return `
                    <div class="card-top">
                        <div class="bandrol-size lbpb1f42">
                            <div class="bandrol-border1">
                                <div class="text-container1">
                                    <span class="resizable-text1 product-name">${namaProduk}</span>
                                </div>
                                <div class="bandrol-border4"></div>
                                <div class="text-container2">
                                    <div class="promo">BIG PROMO!!!</div>
                                    <div>
                                        <label class="bandrol-rp">RP. </label>
                                        <span class="resizable-text2 price">${formattedPrice}
                                        </span>
                                        <label class="bandrol-uom uom">/${uom}
                                        </label>
                                    </div>
                                </div>
                                <div class="bandrol-toko">
                                    <div class="text-container3">
                                        
                                        <div class="logo">
                                            <img src="{{ url('assets/img/logo/lbt.png') }}" alt="Logo" class="img-fluid" style="width:50mm;margin-left:2mm;">
                                        </div>
                                        <span class="resizable-text3 store">${nameStore}
                                        </span>
                                        <div class="logo">
                                            <img src="{{ url('assets/img/logo/lbt.png') }}" alt="Logo" class="img-fluid" style="width:50mm;margin-right:2mm;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;
                }
                else if (bazaar == '10') {
                    return `
                    <div class="card-top">
                        <div class="bandrol-size bzpb1f42">
                            <div class="bandrol-border1">
                                <div class="text-container1">
                                    <span class="resizable-text1 product-name">${namaProduk}</span>
                                </div>
                                <div class="bandrol-border4"></div>
                                <div class="text-container2">
                                    <div class="promo">BIG PROMO!!!</div>
                                    <div>
                                        <label class="bandrol-rp">RP. </label>
                                        <span class="resizable-text2 price">${formattedPrice}
                                        </span>
                                        <label class="bandrol-uom uom">/${uom}
                                        </label>
                                    </div>
                                </div>
                                <div class="bandrol-toko">
                                    <div class="text-container3">
                                        
                                        <div class="logo">
                                            <img src="{{ url('assets/img/logo/bz.png') }}" alt="Logo" class="img-fluid" style="width:50mm;margin-left:2mm;">
                                        </div>
                                        <span class="resizable-text3 store">${nameStore}
                                        </span>
                                        <div class="logo">
                                            <img src="{{ url('assets/img/logo/bz.png') }}" alt="Logo" class="img-fluid" style="width:50mm;margin-right:2mm;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;
                } else if (bazaar == '11') {
                    return `
                    <div class="card-top">
                        <div class="bandrol-size lbb18l">
                             <div class="bandrol-border0">
                            <div class="bandrol-border1"></div>
                            <div class="text-container1">
                                <span class="resizable-text1 product-name">${namaProduk}</span>
                            </div>
                            <div class="text-container2">
                                <label class="bandrol-rp">RP. </label>
                                <span class="resizable-text2 price">${formattedPrice}
                                </span>
                                <label class="bandrol-uom uom">/${uom}
                                        </label>
                            </div>
                            <div class="text-container3">
                                <img src="{{ url('assets/img/logo/lbbtr.png') }}" style="width: 100%;">
                            </div>
                        </div>   </div>
                    </div>
                    `;
                } else if (bazaar == '13') {
                    return `
                    <div class="card-top">
                        <div class="bandrol-size lbpb1f41">
                            <div class="bandrol-border1">
                                <div class="text-container1">
                                    <span class="resizable-text1 product-name">${namaProduk}</span>
                                </div>
                                <div class="bandrol-border4"></div>
                                <div class="text-container2">
                                    <div class="promo">BIG PROMO!!!</div>
                                    <div>
                                        <label class="bandrol-rp">RP. </label>
                                        <span class="resizable-text2 price">${formattedPrice}
                                        </span>
                                        <label class="bandrol-uom uom">/${uom}
                                        </label>
                                    </div>
                                </div>
                                <div class="bandrol-toko">
                                    <div class="text-container3">
                                        
                                        <div class="logo">
                                            <img src="{{ url('assets/img/logo/lbt.png') }}" alt="Logo" class="img-fluid" style="width:40mm;margin-left:2mm;">
                                        </div>
                                        <span class="resizable-text3 store">${nameStore}
                                        </span>
                                        <div class="logo">
                                            <img src="{{ url('assets/img/logo/lbt.png') }}" alt="Logo" class="img-fluid" style="width:40mm;margin-right:2mm;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;
                } else if (bazaar == '15') {
                    return `
             <div class="card-top">
                            <div class="bandrol-size lbb2f4l" style="text-align: center; font-family: 'Poppins', serif; font-weight: bold; box-sizing: border-box;">
    <div class="bandrol-border1" style="width: 100%; height: 100%; border: 3mm solid #fef213; border-radius: 6mm; box-sizing: border-box;">
        <div class="bandrol-border2" style="margin: 1mm; border: 3mm solid #00ff0d; width: auto; border-radius: 5mm; box-sizing: border-box;">
            <div class="bandrol-border3" style="margin: 1mm; border: 3mm solid #ff0000; width: auto; border-radius: 4mm; box-sizing: border-box;">
                <div class="text-container1" style="width: auto; min-height: 20mm; display: flex; align-items: center; justify-content: center; overflow: hidden; text-align: center; box-sizing: border-box;">
                    <span class="resizable-text1 product-name" style="text-align: center; color: #ff0000; font-size: 15mm; font-family: 'Anton', serif; font-weight: 400; -webkit-text-stroke-width: 1px; -webkit-text-stroke-color: black; width: 100%; max-width: 100%; max-height: 53mm; box-sizing: border-box; line-height: 1; margin: 0; display: flex; align-items: center; justify-content: center; word-wrap: break-word; white-space: normal; font-weight: bold;">${namaProduk}</span>
                </div>
                <div class="bandrol-border4" style="border-bottom: 3mm solid #000000; box-sizing: border-box;"></div>
                <div class="text-container2" style="width: auto; height: 38mm; color: #000000; display: flex; align-items: center; justify-content: center; overflow: hidden; word-wrap: break-word; font-family: 'Anton', serif; font-weight: 700; box-sizing: border-box;">
                    <label class="bandrol-rp" style="font-size: 20mm; color: #000000;">RP. </label>
                    <span class="resizable-text2 price" style="font-size: 35mm; transition: font-size 0.2s; font-weight: 400; width: auto; line-height: 0.8; box-sizing: border-box;">${formattedPrice}</span>
                    <label class="bandrol-uom uom" style="font-size: 20mm; color: #000000;">/${uom}</label>
                </div>
                <div class="bandrol-toko" style="color: #00268f; box-sizing: border-box;">
                    <div class="text-container3" style="display: flex; align-items: center; justify-content: space-between; height: 23mm; overflow: visible; letter-spacing: 0; box-sizing: border-box;">
                        <div class="logo left" style="width: 40mm; height: 40mm; margin-top: 20mm;">
                            <img src="{{ url('assets/img/logo/lbt.png') }}" style="width:75%" class="img-fluid text-end" alt="bazzar">
                        </div>
                        <span class="resizable-text3 store" style="text-align: center; font-size: 15mm; color: rgb(14, 0, 214); transition: font-size 0.2s; box-sizing: border-box; line-height: 0.1; display: flex; align-items: center; justify-content: center; font-family: 'Anton', serif; font-weight: 400;">${nameStore}</span>
                        <div class="logo right" style="width: 40mm; height: 40mm; margin-top: 20mm;">
                            <img src="{{ url('assets/img/logo/lbt.png') }}" style="width:75%" class="img-fluid text-end" alt="bazzar">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                        </div>
            `;
                }

                return '';
            }

            function handleFileSelect(e) {
                var files = e.target.files;
                if (!files.length) {
                    console.error('No files selected');
                    return;
                }

                // Clear existing cards and reset uniqueItems and itemCount
                $('#cardsContainer').empty();
                uniqueItems = [];
                itemCount = 0;

                // Mulai baris baru
                $('#cardsContainer').append('<div class="row">');

                var filePromises = [];

                // Loop through each selected file
                for (var i = 0; i < files.length; i++) {
                    (function (file) {
                        var reader = new FileReader();
                        var filePromise = new Promise(function (resolve, reject) {
                            reader.onload = function (event) {
                                var data = new Uint8Array(event.target.result);
                                var workbook = XLSX.read(data, {
                                    type: 'array'
                                });
                                var sheetName = workbook.SheetNames[0];
                                var sheet = workbook.Sheets[sheetName];
                                var json = XLSX.utils.sheet_to_json(sheet);

                                json.forEach(function (row) {
                                    var kodeProduk = row['Kode Produk'];
                                    var namaProduk = row['Nama Produk'];
                                    var price = parseFloat(row['Price']);
                                    var uom = row['UOM'];
                                    var kodeStore = row['Kode Store'];
                                    var nameStore = row['Name Store'];
                                    var discountMember = parseFloat(row['Discount Member'] || 0);

                                    // Generate the card HTML
                                    var cardHtml = generateCardHtml($('#bazaarSelect')
                                        .val(), namaProduk, price, uom, nameStore, discountMember);

                                    // Append the new card to the container
                                    $('#cardsContainer').append(cardHtml);
                                });

                                resolve();
                            };
                            reader.onerror = function () {
                                reject('Error reading file');
                            };
                            reader.readAsArrayBuffer(file);
                        });

                        filePromises.push(filePromise);
                    })(files[i]);
                }

                // Wait for all files to be processed before closing the last row
                Promise.all(filePromises).then(function () {
                    // Tutup baris terakhir
                    $('#cardsContainer').append('</div>');
                }).catch(function (error) {
                    console.error(error);
                });
            }

            $('#filebandrol').change(handleFileSelect);

            $('#printButton').click(function () {
                const {
                    jsPDF
                } = window.jspdf;
                var doc = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: [330, 210] // F4 in mm: 210 x 330
                });

                var cards = document.getElementsByClassName('card-top');
                var promises = [];

                var button = $(this);
                button.text('Mengunduh bandrol').prop('disabled', true);

                Array.from(cards).forEach(function (card, index) {
                    promises.push(html2canvas(card).then(function (canvas) {
                        var imgData = canvas.toDataURL('image/png');
                        if (index === 0) {
                            doc.addImage(imgData, 'PNG', 0, 0, 330, 210);
                        } else {
                            doc.addPage();
                            doc.addImage(imgData, 'PNG', 0, 0, 330, 210);
                        }
                    }));
                });

                Promise.all(promises).then(function () {
                    doc.save('bandrol.pdf');
                    button.text('Print Bandrol').prop('disabled', false);
                }).catch(function () {
                    button.text('Print Bandrol').prop('disabled', false);
                });
            });
            $('#printButton2').click(function () {
                const {
                    jsPDF
                } = window.jspdf;
                var doc = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: [210, 165] // Width 210 mm, Height 165 mm in landscape orientation
                });

                var cards = document.getElementsByClassName('card-top');
                var promises = [];

                var button = $(this);
                button.text('Mengunduh bandrol').prop('disabled', true);

                Array.from(cards).forEach(function (card, index) {
                    promises.push(html2canvas(card).then(function (canvas) {
                        var imgData = canvas.toDataURL('image/png');
                        if (index === 0) {
                            doc.addImage(imgData, 'PNG', 0, 0, 210, 164);
                        } else {
                            doc.addPage();
                            doc.addImage(imgData, 'PNG', 0, 0, 210, 164);
                        }
                    }));
                });

                Promise.all(promises).then(function () {
                    doc.save('bandrol.pdf');
                    button.text('Print Bandrol').prop('disabled', false);
                }).catch(function () {
                    button.text('Print Bandrol').prop('disabled', false);
                });
            });
            $('#printButton3').click(function () {
                const {
                    jsPDF
                } = window.jspdf;
                var doc = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: [210, 82] // Width 210 mm, Height 165 mm in landscape orientation
                });

                var cards = document.getElementsByClassName('card-top');
                var promises = [];

                var button = $(this);
                button.text('Mengunduh bandrol').prop('disabled', true);

                Array.from(cards).forEach(function (card, index) {
                    promises.push(html2canvas(card).then(function (canvas) {
                        var imgData = canvas.toDataURL('image/png');
                        if (index === 0) {
                            doc.addImage(imgData, 'PNG', 0, 0, 210, 82);
                        } else {
                            doc.addPage();
                            doc.addImage(imgData, 'PNG', 0, 0, 210, 82);
                        }
                    }));
                });

                Promise.all(promises).then(function () {
                    doc.save('bandrol.pdf');
                    button.text('Print Bandrol').prop('disabled', false);
                }).catch(function () {
                    button.text('Print Bandrol').prop('disabled', false);
                });
            });
            $('#printButton4').click(function () {
                const {
                    jsPDF
                } = window.jspdf;
                var doc = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: [330, 260] // Width 330 m23 Height 165 mm in landscape orientation
                });

                var cards = document.getElementsByClassName('card-top');
                var promises = [];

                var button = $(this);
                button.text('Mengunduh bandrol').prop('disabled', true);

                Array.from(cards).forEach(function (card, index) {
                    promises.push(html2canvas(card).then(function (canvas) {
                        var imgData = canvas.toDataURL('image/png');
                        if (index === 0) {
                            doc.addImage(imgData, 'PNG', 0, 0, 330, 260);
                        } else {
                            doc.addPage();
                            doc.addImage(imgData, 'PNG', 0, 0, 330, 260);
                        }
                    }));
                });

                Promise.all(promises).then(function () {
                    doc.save('bandrol.pdf');
                    button.text('Print Bandrol').prop('disabled', false);
                }).catch(function () {
                    button.text('Print Bandrol').prop('disabled', false);
                });
            });
            $('#printButton5').click(function () {
                const {
                    jsPDF
                } = window.jspdf;
                var doc = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: [330, 175] // Width 330 m23 Height 165 mm in landscape orientation
                });

                var cards = document.getElementsByClassName('card-top');
                var promises = [];

                var button = $(this);
                button.text('Mengunduh bandrol').prop('disabled', true);

                Array.from(cards).forEach(function (card, index) {
                    promises.push(html2canvas(card).then(function (canvas) {
                        var imgData = canvas.toDataURL('image/png');
                        if (index === 0) {
                            doc.addImage(imgData, 'PNG', 0, 0, 330, 175);
                        } else {
                            doc.addPage();
                            doc.addImage(imgData, 'PNG', 0, 0, 330, 175);
                        }
                    }));
                });

                Promise.all(promises).then(function () {
                    doc.save('bandrol.pdf');
                    button.text('Print Bandrol').prop('disabled', false);
                }).catch(function () {
                    button.text('Print Bandrol').prop('disabled', false);
                });
            });
            $('#printButton6').click(function () {
                const {
                    jsPDF
                } = window.jspdf;
                var doc = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: [330, 113] // Width 330 m23 Height 165 mm in landscape orientation
                });

                var cards = document.getElementsByClassName('card-top');
                var promises = [];

                var button = $(this);
                button.text('Mengunduh bandrol').prop('disabled', true);

                Array.from(cards).forEach(function (card, index) {
                    promises.push(html2canvas(card).then(function (canvas) {
                        var imgData = canvas.toDataURL('image/png');
                        if (index === 0) {
                            doc.addImage(imgData, 'PNG', 0, 0, 330, 113);
                        } else {
                            doc.addPage();
                            doc.addImage(imgData, 'PNG', 0, 0, 330, 113);
                        }
                    }));
                });

                Promise.all(promises).then(function () {
                    doc.save('bandrol.pdf');
                    button.text('Print Bandrol').prop('disabled', false);
                }).catch(function () {
                    button.text('Print Bandrol').prop('disabled', false);
                });
            });
            $('#printButton7').click(function () {
                const {
                    jsPDF
                } = window.jspdf;
                var doc = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: [330, 105] // Width 330 m23 Height 165 mm in landscape orientation
                });

                var cards = document.getElementsByClassName('card-top');
                var promises = [];

                var button = $(this);
                button.text('Mengunduh bandrol').prop('disabled', true);

                Array.from(cards).forEach(function (card, index) {
                    promises.push(html2canvas(card).then(function (canvas) {
                        var imgData = canvas.toDataURL('image/png');
                        if (index === 0) {
                            doc.addImage(imgData, 'PNG', 0, 0, 330, 105);
                        } else {
                            doc.addPage();
                            doc.addImage(imgData, 'PNG', 0, 0, 330, 105);
                        }
                    }));
                });

                Promise.all(promises).then(function () {
                    doc.save('bandrol.pdf');
                    button.text('Print Bandrol').prop('disabled', false);
                }).catch(function () {
                    button.text('Print Bandrol').prop('disabled', false);
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const bazaarSelect = document.getElementById('bazaarSelect');
            const templateImage = document.getElementById('templateImage');

            // Function to update the template preview based on the selected option
            function updateTemplatePreview(value) {
                const templateSrc = {
                    '1': '{{ url("assets/img/bandrol/1.png") }}',
                    '3': '{{ url("assets/img/bandrol/3.png") }}',
                    '7': '{{ url("assets/img/bandrol/7.png") }}',
                    '4': '{{ url("assets/img/bandrol/4.png") }}',
                    '11': '{{ url("assets/img/bandrol/11.png") }}',
                    '13': '{{ url("assets/img/bandrol/13.png") }}',
                    '15': '{{ url("assets/img/bandrol/15.png") }}',
                    '9': '{{ url("assets/img/bandrol/9.png") }}'
                    // Add more key-value pairs for additional templates as needed
                };

                templateImage.src = templateSrc[value] || '{{ url("assets/img/bandrol/template1.png") }}';
            }

            // Initialize the template preview with the first option
            updateTemplatePreview(bazaarSelect.value);

            // Update the preview when the select value changes
            bazaarSelect.addEventListener('change', function () {
                updateTemplatePreview(this.value);
            });
        });
    </script>
</body>

</html>