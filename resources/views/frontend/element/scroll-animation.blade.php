<!-- Start Card Scroll Animation -->
<style>
    *,
    *::before,
    *::after {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --bg: #0a0a0f;
        --accent: #c8a96e;
        --white: #f5f0e8;
        --card1: #1a2a4a;
        --card2: #2a1a3a;
        --card3: #1a3a2a;
        --card4: #3a2a1a;
        --card5: #2a3a1a;
    }

    /* Sticky scene container */
    .scene-wrapper {
        position: relative;
        height: 600vh;
        top: 80px;
    }

    .sticky-scene {
        position: sticky;
        top: 0;
        height: 100vh;
        width: 100%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Noise overlay */
    .noise {
        position: fixed;
        inset: 0;
        pointer-events: none;
        z-index: 100;
        opacity: 0.035;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
        background-size: 200px 200px;
    }

    /* Radial glow center */
    .glow {
        position: absolute;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(200, 169, 110, 0.12) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
        z-index: 0;
    }

    /* Hero text */
    .hero-text {
        position: absolute;
        z-index: 0;
        text-align: center;
        pointer-events: none;
        user-select: none;
    }

    .hero-text .label {
        display: block;
        font-weight: 300;
        font-size: 11px;
        letter-spacing: 0.35em;
        text-transform: uppercase;
        color: var(--accent);
        margin-bottom: 18px;
        opacity: 0;
        animation: fadeUp 1s 0.3s forwards;
    }

    .hero-text h1 {
        font-weight: 600;
        line-height: 1.0;
        /* color: var(--white); */
        /* opacity: 0; */
        animation: fadeUp 1s 0.1s forwards;
        transition: font-size 0.1s linear;
    }

    .hero-text .sub {
        display: block;
        font-size: 14px;
        color: rgba(245, 240, 232, 0.4);
        margin-top: 20px;
        letter-spacing: 0.05em;
        opacity: 0;
        animation: fadeUp 1s 0.9s forwards;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Cards */
    .card {
        position: absolute;
        border-radius: 42px;
        overflow: hidden;
        will-change: transform, opacity;
        z-index: 5;
    }

    .card img {
        width: 350px;
        height: 250px;
    }

    /* Progress bar */
    .progress-bar {
        position: fixed;
        top: 0;
        left: 0;
        height: 2px;
        background: linear-gradient(90deg, var(--accent), var(--red-color));
        z-index: 200;
        width: 0%;
        transition: width 0.2s linear;
    }
</style>

<div class="cursor" id="cursor"></div>
<div class="noise"></div>
<div class="progress-bar" id="progressBar"></div>

<div class="scene-wrapper" id="sceneWrapper">
    <div class="sticky-scene" id="stickyScene">

        <div class="glow"></div>

        <!-- Hero Text -->
        <div class="hero-text">
            <h1>
                <p class="p-0 m-0">Proven Signals</p>
                <p class="p-0 m-0">Consistent
                    <span style="color: #46e546; text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.5);">Profits</span>
                </p>
            </h1>
        </div>

        <!-- 5 Cards -->
        <div class="card card-1" id="card1">
            <img src="{{ url('public/frontend/images/3700-pip.png') }}">
        </div>

        <div class="card card-2" id="card2">
            <div class="card-inner">
                <img src="{{ url('public/frontend/images/confirmed.png') }}">
            </div>
        </div>

        <div class="card card-3" id="card3">
            <div class="card-inner">
                <img src="{{ url('public/frontend/images/82-accuracy.png') }}">
            </div>
        </div>

        <div class="card card-4" id="card4">
            <div class="card-inner">
                <img src="{{ url('public/frontend/images/4k-signal-delivered.png') }}">
            </div>
        </div>

        <div class="card card-5" id="card5">
            <div class="card-inner">
                <img src="{{ url('public/frontend/images/82-profit.png') }}">
            </div>
        </div>
    </div>
</div>

<script>
    // Cursor
    const cursor = document.getElementById('cursor');
    document.addEventListener('mousemove', e => {
        cursor.style.left = e.clientX + 'px';
        cursor.style.top = e.clientY + 'px';
    });

    // Card definitions: corner origins (as vw/vh percentages from center)
    // Each card starts at a corner or edge, moves to center, then exits top
    const cards = [{
            el: document.getElementById('card1'),
            startX: -54,
            startY: 20,
            rot: 0
        }, // bottom-left
        {
            el: document.getElementById('card2'),
            startX: 54,
            startY: 20,
            rot: 0
        }, // bottom-right
        {
            el: document.getElementById('card3'),
            startX: -56,
            startY: -40,
            rot: 0
        }, // top-left
        {
            el: document.getElementById('card4'),
            startX: 55,
            startY: -40,
            rot: 0
        }, // top-right
        {
            el: document.getElementById('card5'),
            startX: 0,
            startY: 40,
            rot: 0
        }, // bottom-center
    ];

    const progressBar = document.getElementById('progressBar');
    const wrapper = document.getElementById('sceneWrapper');
    const heroTitle = document.querySelector('.hero-text h1');

    function lerp(a, b, t) {
        return a + (b - a) * t;
    }

    function clamp(v, lo, hi) {
        return Math.min(Math.max(v, lo), hi);
    }

    function ease(t) {
        return t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
    } // easeInOut

    // Convert vw offset to px
    function vw(p) {
        return window.innerWidth * p / 100;
    }

    function vh(p) {
        return window.innerHeight * p / 100;
    }

    function update() {
        const scrollTop = window.scrollY;
        const maxScroll = wrapper.offsetHeight - window.innerHeight;
        const raw = clamp(scrollTop / maxScroll, 0, 1);

        // Text scale (180px → 75px)
        const maxFont = 160;
        const minFont = 90;

        // Control how fast it shrinks (0.4 = faster, 1 = full scroll)
        const textProgress = clamp(raw * 1.2, 0, 1);

        const fontSize = lerp(maxFont, minFont, textProgress);

        // Apply font size
        heroTitle.style.fontSize = fontSize + 'px';

        progressBar.style.width = (raw * 100) + '%';

        cards.forEach((c, i) => {
            // Each card has its own scroll window, slightly staggered
            // Phase 1 (0 → 0.5): corner → center
            // Phase 2 (0.5 → 1.0): center → top exit

            const offset = i * 0.03; // tiny stagger so they don't all arrive at same time
            const t = clamp((raw - offset) / (1 - offset), 0, 1);

            let x, y, scale, opacity, rotation;

            if (t < 0.5) {
                // Incoming: corner → center
                const p = ease(t / 0.5);
                x = lerp(vw(c.startX), 0, p);
                y = lerp(vh(c.startY), 0, p);
                scale = lerp(0.55, 1, p);
                opacity = lerp(1, 1, p);
                rotation = lerp(c.rot, 0, p);
            } else {
                // Outgoing: center → top
                const p = ease((t - 0.5) / 0.5);
                x = lerp(0, 0, p); // straight up
                y = lerp(0, vh(-60), p);
                scale = lerp(1, 0.7, p);
                opacity = lerp(1, 0, p);
                rotation = lerp(0, c.rot * -0.5, p);
            }

            changeScreen = rotation;

            c.el.style.transform =
                `translate(calc(0% + ${x}px), calc(20% + ${y}px)) scale(${scale}) rotate(${rotation}deg)`;
            c.el.style.opacity = opacity;
        });
    }

    window.addEventListener('scroll', update, {
        passive: true
    });
    window.addEventListener('resize', update);

    update();
</script>
<!-- End Card Scroll Animation -->
