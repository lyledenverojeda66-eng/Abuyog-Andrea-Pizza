<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact - Abuyog Andrea Pizza</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #fff8ee;
            color: #222;
        }

        a {
            text-decoration: none;
        }

        /* =========================
           CONTACT HEADER
        ========================== */

        .contact-header {
            text-align: center;
            padding: 55px 20px 35px;
        }

        .contact-header h1 {
            font-size: 42px;
            margin-bottom: 10px;
            color: #222;
        }

        .contact-header p {
            color: #777;
            font-size: 17px;
        }

        /* =========================
           CONTACT SECTION
        ========================== */

        .contact-container {
            width: 92%;
            max-width: 1150px;
            margin: 0 auto 60px;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .contact-card {
            background: white;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.07);
        }

        .contact-card h2 {
            font-size: 25px;
            margin-bottom: 25px;
            color: #222;
        }

        .contact-item {
            display: flex;
            gap: 15px;
            margin-bottom: 22px;
            align-items: flex-start;
        }

        .contact-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #e51b23;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 20px;
        }

        .contact-item h3 {
            font-size: 15px;
            margin-bottom: 5px;
            color: #333;
        }

        .contact-item p,
        .contact-item a {
            color: #666;
            line-height: 1.5;
            font-size: 15px;
        }

        .contact-item a:hover {
            color: #e51b23;
        }

        /* =========================
           MAP
        ========================== */

        .map-container {
            width: 100%;
            height: 100%;
            min-height: 400px;
            border-radius: 15px;
            overflow: hidden;
        }

        .map-container iframe {
            width: 100%;
            height: 100%;
            min-height: 400px;
            border: 0;
        }

        /* =========================
           FOOTER
        ========================== */

        .contact-footer {
            background: #111;
            color: white;
            text-align: center;
            padding: 25px 15px;
            margin-top: 70px;
        }

        .contact-footer p {
            color: #ccc;
            font-size: 14px;
        }

        /* =========================
           MOBILE
        ========================== */

        @media (max-width: 800px) {

            .contact-grid {
                grid-template-columns: 1fr;
            }

            .contact-header h1 {
                font-size: 34px;
            }

            .map-container {
                min-height: 350px;
            }

            .map-container iframe {
                min-height: 350px;
            }
        }

        @media (max-width: 550px) {

            .contact-container {
                width: 94%;
            }

            .contact-card {
                padding: 22px;
            }

            .contact-header {
                padding: 40px 15px 25px;
            }

            .contact-header h1 {
                font-size: 30px;
            }

            .contact-header p {
                font-size: 15px;
            }

            .map-container {
                min-height: 300px;
            }

            .map-container iframe {
                min-height: 300px;
            }
        }

    </style>

</head>

<body>

    {{-- =========================
         SHARED NAVBAR
    ========================== --}}

    @include('partials.navbar')


    {{-- =========================
         CONTACT HEADER
    ========================== --}}

    <section class="contact-header">

        <h1>
            Contact Us
        </h1>

        <p>
            We'd love to hear from you. Visit us or get in touch with Andrea's Pizza.
        </p>

    </section>


    {{-- =========================
         CONTACT INFORMATION
    ========================== --}}

    <section class="contact-container">

        <div class="contact-grid">

            {{-- Contact Information --}}

            <div class="contact-card">

                <h2>
                    Get In Touch
                </h2>


                {{-- Address --}}

                <div class="contact-item">

                    <div class="contact-icon">
                        📍
                    </div>

                    <div>

                        <h3>
                            Address
                        </h3>

                        <p>
                            P2W6+GXX Andrea's Pizza,
                            Avenida Rizal St., Bito,
                            Abuyog, 6510 Northern Leyte
                        </p>

                    </div>

                </div>


                {{-- Phone --}}

                <div class="contact-item">

                    <div class="contact-icon">
                        📞
                    </div>

                    <div>

                        <h3>
                            Phone
                        </h3>

                        <a href="tel:09066151243">
                            09066151243
                        </a>

                    </div>

                </div>


                {{-- Email --}}

                <div class="contact-item">

                    <div class="contact-icon">
                        ✉
                    </div>

                    <div>

                        <h3>
                            Email
                        </h3>

                        <a href="mailto:Andreapizza@gmail.com">
                            Andreapizza@gmail.com
                        </a>

                    </div>

                </div>


                {{-- Facebook --}}

                <div class="contact-item">

                    <div class="contact-icon">
                        f
                    </div>

                    <div>

                        <h3>
                            Facebook
                        </h3>

                        <a href="#" target="_blank">
                            Andrea's Pizza
                        </a>

                    </div>

                </div>

            </div>


            {{-- =========================
                 GOOGLE MAP
            ========================== --}}

            <div class="contact-card">

                <h2>
                    Find Us
                </h2>

                <div class="map-container">

                    <iframe
                        src="https://www.google.com/maps?q=P2W6%2BGXX%20Andrea%27s%20Pizza%2C%20Avenida%20Rizal%20St%2C%20Bito%2C%20Abuyog%2C%206510%20Northern%20Leyte&output=embed"
                        loading="lazy"
                        allowfullscreen>
                    </iframe>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================
         FOOTER
    ========================== --}}

    <footer class="contact-footer">

        <p>
            © {{ date('Y') }} Abuyog Andrea Pizza. All rights reserved.
        </p>

    </footer>


</body>

</html>