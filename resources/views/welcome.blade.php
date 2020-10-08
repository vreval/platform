<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>VREVAL</title>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            a {
                color: #636b6f;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                    @endauth
                </div>
            @endif

            <div class="content container">
                <div class="title m-b-md">
                    VREVAL
                </div>
                <p class="text-center text-2xl">A simple toolbox for user centric evaluations of virtual environments.</p>

                <p>Based on the research of team InfAr at Bauhaus-University Weimar, Germany, this toolbox aimes to make user centred research a breeze. Following proven methods and processes like
                    <a href="https://www.yumpu.com/de/document/view/51452434/pdf-download-infar-bauhaus-universitat-weimar">Design by Research</a>, scientists can use VREVAL to make the most of their resources and gain a unique insight into their target demographic.</p>

                <div class="my-12 flex justify-between -mx-4">
                    <div class="flex-col flex-1 px-4 justify-center">
                        <div class="w-32 h-32 mb-4 rounded-full bg-gray-400 text-5xl flex items-center justify-center mx-auto"><span>P</span></div>
                        <p>An online platform where users can manage their projects from anywhere, invite colleagues to collaborate on their work and share results with the world.</p>
                    </div>
                    <div class="flex-col flex-1 px-4 justify-center">
                        <div class="w-32 h-32 mb-4 rounded-full bg-gray-400 text-5xl flex items-center justify-center mx-auto"><span>C</span></div>
                        <p>The client is a standalone program, designed to be used for running user studies using a desktop or virtual reality. Everyone can download it for free.</p>
                    </div>
                    <div class="flex-col flex-1 px-4 justify-center">
                        <div class="w-32 h-32 mb-4 rounded-full bg-gray-400 text-5xl flex items-center justify-center mx-auto"><span>API</span></div>
                        <p>VREVAL provides a REST API for developers to make use of their data and build amazing third party applications for data analysis or otherwise.</p>
                    </div>
                </div>

                <div class="text-center">
                    <a href="/register" class="text-2xl btn btn-green">Register now</a>
                </div>
            </div>
        </div>
    </body>
</html>
