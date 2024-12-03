@extends('layouts.app')

@section('content')
    <main class="py-4">
        <!-- Menambahkan Tailwind CSS melalui CDN hanya untuk halaman profil -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">

        <!-- Menambahkan elemen untuk Particles.js -->
        <div id="particles-js"></div>

        <section id="hero" class="hero-text">
            <img src="{{ $user->profile_image_url }}" alt="profile" class="profile-img" width="200" height="200">
            <h1 class="heading-warna">{{ Auth::user()->name }}</h1>
            <p class="paragraf-warna">{{ $user->email }}</p>
            <div class="bio-marquee">
                <span>Welcome, {{ $user->name }}</span>
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
            </div>
        </section>

        <div class="container mt-5">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </main>

    <style>
        body {
            background-color: #040507;
            font-family: 'Poppins', sans-serif;
            color: #fff;
            overflow-x: hidden;
            margin: 0; 
            padding: 0; 
        }

        html {
            scroll-behavior: smooth;
        }

        /* Hero Section Styling */
        .hero-text {
            text-align: center;
            margin-top: 80px;
            position: relative;
            background-image: url('');
            background-size: cover;
            background-position: center; 
            min-height: 75vh; 
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .heading-warna {
            color: white;
            font-size: 3rem;
            margin-bottom: 10px;
        }
        .paragraf-warna {
            color: white; 
            font-size: 1.5rem;
        }
        .profile-img {
            border-radius: 50%;
            overflow: hidden;
            border: 5px solid #FFD700;
            transition: transform 0.5s ease;
            width: 200px; 
            height: 200px; 
            object-fit: cover; 
            border-radius: 50%;
            border: 2px solid #FFD700;
            margin-bottom: 20px;
            box-shadow: 0 0 20px rgba(255,215, 0, 0.8);
        }
        .profile-img:hover {
            transform: scale(1.1);
            box-shadow: 0 0 30px rgba(255,215, 0, 0.8);
        }
        h1 {
            font-size: 3.5rem;
            margin-top: 20px;
            font-weight: 600;
            letter-spacing: 1px;
        }
        p {
            font-size: 1.2rem;
            font-weight: 300;
            margin-top: 10px;
        }

        /* Marquee Styling */
        .bio-marquee {
            color: #e5da9a;
            font-size: 1.5rem;
            margin-top: 20px;
            white-space: nowrap;
            overflow: hidden;
            max-width: 600px;
            margin-top: 20px;
            background-color: rgba(255, 255, 255, 0.156); 
            color: #FFD700;
            padding: 10px;
            border-radius: 10px;
        }
        .bio-marquee span {
            display: inline-block;
            padding-left: 100%;
            animation: marquee 5s linear infinite; /* Mengubah durasi animasi menjadi 5 detik */
        }
        @keyframes marquee {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }

        /* Button Styling */
        .btn-primary {
            background-color: #FFD700;
            color: #000;
            padding: 10px 20px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            border-radius: 5px; 
            transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #04fa00; 
            color: #000000; 
            transform: scale(1.05); 
        }

        /* Particles.js Styling */
        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/particles.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function typeEffect(element, text, speed) {
                let i = 0;
                function typing() {
                    if (i < text.length) {
                        element.innerHTML += text.charAt(i);
                        i++;
                        setTimeout(typing, speed);
                    } else {
                        setTimeout(() => {
                            element.innerHTML = '';
                            i = 0;
                            typing();
                        }, 2000); // Delay before restarting the typing effect
                    }
                }
                element.innerHTML = '';
                typing();
            }

            const headingElement = document.querySelector('.heading-warna');
            const paragraphElement = document.querySelector('.paragraf-warna');

            typeEffect(headingElement, "{{ $user->name }}", 70);
            typeEffect(paragraphElement, "{{ $user->email }}", 50);

            // Particles.js configuration
            particlesJS('particles-js', {
                particles: {
                    number: {
                        value: 80,
                        density: {
                            enable: true,
                            value_area: 800
                        }
                    },
                    color: {
                        value: "#ffffff"
                    },
                    shape: {
                        type: "circle",
                        stroke: {
                            width: 0,
                            color: "#000000"
                        },
                        polygon: {
                            nb_sides: 5
                        },
                        image: {
                            src: "img/github.svg",
                            width: 100,
                            height: 100
                        }
                    },
                    opacity: {
                        value: 0.5,
                        random: false,
                        anim: {
                            enable: false,
                            speed: 1,
                            opacity_min: 0.1,
                            sync: false
                        }
                    },
                    size: {
                        value: 3,
                        random: true,
                        anim: {
                            enable: false,
                            speed: 40,
                            size_min: 0.1,
                            sync: false
                        }
                    },
                    line_linked: {
                        enable: true,
                        distance: 150,
                        color: "#FFD700",
                        opacity: 0.4,
                        width: 1
                    },
                    move: {
                        enable: true,
                        speed: 6,
                        direction: "none",
                        random: false,
                        straight: false,
                        out_mode: "out",
                        bounce: false,
                        attract: {
                            enable: false,
                            rotateX: 600,
                            rotateY: 1200
                        }
                    }
                },
                interactivity: {
                    detect_on: "canvas",
                    events: {
                        onhover: {
                            enable: true,
                            mode: "repulse"
                        },
                        onclick: {
                            enable: true,
                            mode: "push"
                        },
                        resize: true
                    },
                    modes: {
                        grab: {
                            distance: 400,
                            line_linked: {
                                opacity: 1
                            }
                        },
                        bubble: {
                            distance: 400,
                            size: 40,
                            duration: 2,
                            opacity: 8,
                            speed: 3
                        },
                        repulse: {
                            distance: 200,
                            duration: 0.4
                        },
                        push: {
                            particles_nb: 4
                        },
                        remove: {
                            particles_nb: 2
                        }
                    }
                },
                retina_detect: true
            });
        });
    </script>
@endsection