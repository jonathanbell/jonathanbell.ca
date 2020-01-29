<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="dns-prefetch" href="https://res.cloudinary.com">
    <link rel="icon" sizes="32x32" type="image/png" href="/img/favicon.png">

    <title>
        Jonathan Bell - Photographer {{ !Request::is('/') && $section ? '| '.$section : '' }}
    </title>

    <style>
        /* A very simple CSS reset. Based on: http://meyerweb.com/eric/tools/css/reset/ */
        html, body, div, span, applet, object, iframe,
        h1, h2, h3, h4, h5, h6, p, blockquote, pre,
        a, abbr, acronym, address, big, cite, code,
        del, dfn, em, img, ins, kbd, q, s, samp,
        small, strike, strong, sub, sup, tt, var,
        b, u, i, center,
        dl, dt, dd, ol, ul, li,
        fieldset, form, label, legend,
        table, caption, tbody, tfoot, thead, tr, th, td,
        article, aside, canvas, details, embed,
        figure, figcaption, footer, header, hgroup,
        menu, nav, output, section, summary,
        time, mark, audio, video {
            margin: 0;
            padding: 0;
            border: 0;
        }

        html {
            box-sizing: border-box;
        }
        *, *:before, *:after {
            box-sizing: inherit;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            font-family: serif;
        }

        audio, video, img, iframe {
            max-width: 100%;
        }

        /* =============================================================================
        VARIABLES
        ============================================================================= */

        :root {
            --main-bg-color: white;
            --main-font-color: #333;
            --extra-narrow-nav-width: 17%;
            --narrow-nav-width: 27%;
            --wide-nav-width: 29.5%;
        }

        /* =============================================================================
        RESET
        ============================================================================= */

        html {
            /* https://developer.mozilla.org/en-US/docs/Web/CSS/text-size-adjust */
            -moz-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
            font-family: serif;
            background-color: var(--main-bg-color);
            color: var(--main-font-color);
        }

        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            margin: 0;
        }

        /*
            Remove the gap between images and the bottom of their containers.
            See: h5bp.com/i/440
        */
        img {
            vertical-align: middle;
        }

        a,
        a:hover,
        a:active,
        a:visited {
            text-decoration: none;
            color: var(--main-font-color);
        }
        a:hover {
            text-decoration: underline;
        }

        /* =============================================================================
        TYPE
        ============================================================================= */

        body {
            letter-spacing: 1px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: normal;
        }
        h1 a:hover,
        h2 a:hover,
        h3 a:hover,
        h4 a:hover,
        h5 a:hover,
        h6 a:hover {
            text-decoration: none;
        }

        /* =============================================================================
        HEADER
        ============================================================================= */

        .masthead {
            padding: 1rem;
        }

        .site-title {
            margin: 0 0 2rem 0;
        }

        nav {
            font-style: italic;
            line-height: 1.3;
        }

        hr {
            opacity: 0;
        }
        hr.show {
            opacity: 1;
            margin: 1rem 0;
        }

        footer {
            font-style: italic;
            text-align: center;
        }

        /* =============================================================================
        PORTFOLIO CONTENT
        ============================================================================= */

        article {
            max-width: 120rem;
        }

        /* =============================================================================
        HELPER CLASSES
        ============================================================================= */

        .visuallyhidden {
            border: 0;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }

        /*
            Extends the `.visuallyhidden` class to allow the element to be
            focusable when navigated to via the keyboard: h5bp.com/p
        */
        .visuallyhidden.focusable:active,
        .visuallyhidden.focusable:focus {
            clip: auto;
            height: auto;
            margin: 0;
            overflow: visible;
            position: static;
            width: auto;
        }

        /* =============================================================================
        MEDIA QUERIES
        ============================================================================= */

        /* SMALL -------------------------------------------------------------------- */

        @media only screen and (min-width: 666px) {
            .masthead {
                width: var(--narrow-nav-width);
                position: fixed;
                height: 100vh;
            }

            article {
                margin-left: var(--narrow-nav-width);
            }

            article img {
                width: 100%;
            }
        }

        /* MEDIUM ------------------------------------------------------------------- */

        @media only screen and (min-width: 65rem) {
            .masthead {
                width: var(--wide-nav-width);
            }

            article {
                display: grid;
                grid-gap: 1rem;
                align-items: center;
                grid-auto-flow: row dense;
                grid-template-columns: repeat(2, 1fr);
                margin-left: var(--wide-nav-width);
            }

            article img {
                width: initial;
            }

            /* .portfolio-image:nth-child(9n) {
                grid-column: 1 / 3;
            }

            .portfolio-image:nth-child(11n),
            .portfolio-image:last-of-type {
                grid-column: 2 / -1;
            } */
        }

        /* LARGE -------------------------------------------------------------------- */

        @media only screen and (min-width: 80rem) {
            .masthead {
                width: var(--extra-narrow-nav-width);
            }

            article {
                margin-left: var(--extra-narrow-nav-width);
            }
        }

        /* =============================================================================
        PRINT STYLES
        ============================================================================= */

        @media print {
            * {
                background: transparent !important;
                /* Black prints faster: h5bp.com/s */
                color: #000 !important;
                box-shadow: none !important;
                text-shadow: none !important;
            }

            img {
                max-width: 99999999px !important;
                page-break-inside: avoid;
                margin: 1rem auto;
                display: block;
            }

            @page {
                margin: 0.5cm;
            }
        }
    </style>
</head>
<body>

    @include('includes.nav')
    @yield('content')

</body>
</html>
