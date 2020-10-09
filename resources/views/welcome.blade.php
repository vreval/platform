@extends('layouts.app')

@section('content')
    <div class="bg-white hero h-screen flex items-center" style="margin-top: -80px">
        <div class="container mx-auto p-12 bg-white bg-opacity-75 rounded">
            <h2 class="text-2xl">A simple toolbox for user centric evaluations of virtual environments.</h2>
            <p>Based on the research of team InfAr at Bauhaus-University Weimar, Germany, this toolbox aimes to make user
                centred research a breeze. Following proven methods and processes like
                <a href="https://www.yumpu.com/de/document/view/51452434/pdf-download-infar-bauhaus-universitat-weimar">Design
                    by Research</a>, scientists can use VREVAL to make the most of their resources and gain a unique insight
                into their target demographic.</p>
            <div class="flex mt-4">
                <a href="#" class="btn btn-green text-xs mr-4">Documentation</a>
                <a href="#" class="btn btn-gray-text text-xs">Download</a>
            </div>
        </div>
    </div>

    <div class="bg-white py-32">
        <div class="container mx-auto">
            <h2 class="text-xl text-center border-b-2 pb-6 mb-6">What is VREVAL?</h2>
            <div class="flex justify-between -mx-4 text-center">
                <div class="flex-col w-1/3 px-4 justify-center">
                    <h3 class="text-3xl">Platform</h3>
                    <p>An online platform where users can manage their projects from anywhere, invite colleagues to
                        collaborate on their work and share results with the world. <a href="/register">Create an account to get started!</a></p>
                </div>
                <div class="flex-col w-1/3 px-4 justify-center">
                    <h3 class="text-3xl">Client</h3>
                    <p>The client is a standalone program, designed to be used for running user studies using a desktop or
                        virtual reality. <a href="#">Everyone can download it for free.</a></p>
                </div>
                <div class="flex-col w-1/3 px-4 justify-center">
                    <h3 class="text-3xl">Schnittstellen</h3>
                    <p>VREVAL provides a REST API for developers to make use of their data and build amazing third party
                        applications for data analysis or otherwise.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-200 py-32">
        <div class="container mx-auto">
            <h2 class="text-xl text-center border-b-2 pb-6 mb-6">Tutorials</h2>
            <div class="flex justify-between -mx-4">
                <div class="flex-col w-1/3 mx-4 bg-white border border-gray-400 rounded overflow-hidden hover:shadow-2xl transition-shadow duration-200">
                    <img src="img/WTP_Pol-1080x675.png" alt="">
                    <div class="p-8">
                        <h3 class="text-lg mb-4">Getting started with VREVAL</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur deleniti ea, eos fugiat iste maxime molestiae quaerat sapiente sint vitae! Dolor laboriosam minima numquam provident.</p>
                        <ul class="flex flex-wrap -mx-1">
                            <li class="bg-gray-200 rounded-full text-xs font-medium px-3 py-1 m-1">#tutorial</li>
                            <li class="bg-gray-200 rounded-full text-xs font-medium px-3 py-1 m-1">#beginner</li>
                            <li class="bg-gray-200 rounded-full text-xs font-medium px-3 py-1 m-1">#video</li>
                        </ul>
                    </div>
                </div>
                <div class="flex-col w-1/3 mx-4 bg-white border border-gray-400 rounded overflow-hidden hover:shadow-2xl transition-shadow duration-200">
                    <img src="img/Post-title_1-1080x675.jpg" alt="">
                    <div class="p-8">
                        <h3 class="text-lg mb-4">Intermediate Study Structure</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur deleniti ea, eos fugiat iste maxime molestiae quaerat sapiente sint vitae! Dolor laboriosam minima numquam provident.</p>
                        <ul class="flex flex-wrap -mx-1">
                            <li class="bg-gray-200 rounded-full text-xs font-medium px-3 py-1 m-1">#tutorial</li>
                            <li class="bg-gray-200 rounded-full text-xs font-medium px-3 py-1 m-1">#intermediate</li>
                            <li class="bg-gray-200 rounded-full text-xs font-medium px-3 py-1 m-1">#blog</li>
                        </ul>
                    </div>
                </div>
                <div class="flex-col w-1/3 mx-4 bg-white border border-gray-400 rounded overflow-hidden hover:shadow-2xl transition-shadow duration-200">
                    <img src="img/Cover-Image_1_edit_4-1080x675.jpg" alt="">
                    <div class="p-8">
                        <h3 class="text-lg mb-4">Creating Modules - deep dive!</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur deleniti ea, eos fugiat iste maxime molestiae quaerat sapiente sint vitae! Dolor laboriosam minima numquam provident.</p>
                        <ul class="flex flex-wrap -mx-1">
                            <li class="bg-gray-200 rounded-full text-xs font-medium px-3 py-1 m-1">#tutorial</li>
                            <li class="bg-gray-200 rounded-full text-xs font-medium px-3 py-1 m-1">#advanced</li>
                            <li class="bg-gray-200 rounded-full text-xs font-medium px-3 py-1 m-1">#video</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white py-32">
        <div class="container mx-auto">
            <h2 class="text-xl text-center border-b-2 pb-6 mb-6">Our Team</h2>
        </div>
    </div>

    <div class="bg-gray-800 py-32">
        <div class="container mx-auto">
            <h2 class="text-xl text-center border-b-2 pb-6 mb-6 text-white">VREVAL</h2>
            <nav class="flex justify-center text-white">
                <a href="#" class="btn btn-gray-text mx-4">About</a>
                <a href="#" class="btn btn-gray-text mx-4">Blog</a>
                <a href="#" class="btn btn-gray-text mx-4">Partners</a>
                <a href="#" class="btn btn-gray-text mx-4">Imprint</a>
            </nav>
        </div>
    </div>
@endsection
