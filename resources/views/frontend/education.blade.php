@extends('frontend.layout')

@section('content')

    <style>
     
        .edu-nav {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            padding: 1rem 0 1.25rem
        }

        .edu-nav button {
            font-size: 17px;
            padding: 9px 36px;
            border-radius: 20px;
            border: 0.5px solid #d0d0d0;
            background: transparent;
            color: #555;
            cursor: pointer;
            transition: all .18s
        }

        .edu-nav button.active,
        .edu-nav button:hover {
            background: #fff;
            color: #f73b20;
            border-color: #f73b20
        }

        .edu-section {
            display: none;
            animation: fadein .25s ease
        }

        .edu-section.active {
            display: block
        }

        @keyframes fadein {
            from {
                opacity: 0;
                transform: translateY(6px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .card {
            background: #fff;
            border: 0.5px solid #e0e0e0;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 12px
        }

        .card h3 {
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 6px
        }

        .card p {
            font-size: 14px;
            line-height: 1.65
        }

        .badge {
            display: inline-block;
            font-size: 22px;
            padding: 20px 9px;
            border-radius: 20px;
            font-weight: 500;
            margin-bottom: 8px
        }

        .badge.info {
            background: #e8f0fe;
            color: #f73b20;
        }

        .badge.warn {
            background: #fef3c7;
            color: #92400e
        }

        .pair-row {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 8px;
            margin-bottom: 10px
        }

        .pair-card {
            background: #f7f7f7;
            border-radius: 8px;
            padding: 10px 12px
        }

        .pair-name {
            font-size: 13px;
            font-weight: 500;
            color: #1a1a1a
        }

        .pair-rate {
            font-size: 16px;
            font-weight: 500;
            color: #1a1a1a;
            margin: 4px 0 2px
        }

        .pair-change {
            font-size: 12px
        }

        .pair-change.up {
            color: #3B6D11
        }

        .pair-change.dn {
            color: #791F1F
        }

        .pip-demo {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 12px 0 6px;
            flex-wrap: wrap
        }

        .pip-digit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 38px;
            border-radius: 6px;
            font-size: 18px;
            font-weight: 500;
            background: #f7f7f7;
            color: #1a1a1a;
            border: 0.5px solid #e0e0e0
        }

        .pip-digit.highlight {
            background: #fef3c7;
            color: #92400e;
            border-color: #fbbf24;
            font-size: 22px;
            width: 36px;
            height: 44px
        }

        .pip-label {
            font-size: 11px;
            color: #999;
            text-align: center;
            margin-top: 2px
        }

        .calc-row {
            display: flex;
            gap: 10px;
            align-items: center;
            margin: 10px 0;
            flex-wrap: wrap
        }

        .calc-row label {
            font-size: 13px;
            color: #555;
            min-width: 90px
        }

        .calc-row input[type=range] {
            flex: 1;
            min-width: 120px
        }

        .calc-row span {
            font-size: 14px;
            font-weight: 500;
            color: #1a1a1a;
            min-width: 80px
        }

        .result-box {
            background: #f7f7f7;
            border-radius: 8px;
            padding: 12px 16px;
            margin-top: 10px;
            font-size: 14px;
            color: #555;
            line-height: 1.8
        }

        .result-box strong {
            color: #1a1a1a
        }

        .term-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px
        }

        .term-item {
            background: #f7f7f7;
            border-radius: 8px;
            padding: 10px 12px
        }

        .term-item .term {
            font-size: 13px;
            font-weight: 500;
            color: #1a1a1a;
            margin-bottom: 3px
        }

        .term-item .def {
            font-size: 12px;
            color: #555;
            line-height: 1.55
        }

        .session-bar {
            display: flex;
            height: 50px;
            border-radius: 8px;
            overflow: hidden;
            margin: 10px 0
        }

        .sess {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 500
        }

        .rule-list {
            list-style: none;
            padding: 0
        }

        .rule-list li {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            font-size: 14px;
            color: #555;
            padding: 8px 0;
            border-bottom: 0.5px solid #e0e0e0;
            line-height: 1.55
        }

        .rule-list li:last-child {
            border-bottom: none
        }

        .rule-list li .icon {
            font-size: 15px;
            margin-top: 1px;
            flex-shrink: 0
        }

        .spread-vis {
            display: flex;
            align-items: stretch;
            margin: 12px 0;
            font-size: 13px;
            border-radius: 8px;
            overflow: hidden;
            border: 0.5px solid #e0e0e0
        }

        .spread-vis .bid {
            background: #FCEBEB;
            color: #791F1F;
            padding: 10px 16px;
            font-weight: 500;
            flex: 1;
            text-align: center
        }

        .spread-vis .mid {
            background: #fef3c7;
            color: #92400e;
            padding: 10px 12px;
            font-weight: 500;
            text-align: center;
            font-size: 11px
        }

        .spread-vis .ask {
            background: #EAF3DE;
            color: #3B6D11;
            padding: 10px 16px;
            font-weight: 500;
            flex: 1;
            text-align: center
        }

        .session-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px
        }

        @media(max-width:480px) {
            .pair-row {
                grid-template-columns: 1fr 1fr
            }

            .term-grid {
                grid-template-columns: 1fr
            }

            .session-grid {
                grid-template-columns: 1fr
            }
        }

        .education-navbar {
            padding-top: 120px;
        }
    </style>

    <section class="education-navbar">
        <div class="container">
            <h2 style="font-size:0;position:absolute">Forex beginner guide: interactive education on currency trading basics
            </h2>

            <div class="edu-nav">
                <button class="active" onclick="show('what',this)">What is Forex?</button>
                <button onclick="show('pairs',this)">Currency pairs</button>
                <button onclick="show('pips',this)">Pips &amp; spreads</button>
                <button onclick="show('leverage',this)">Leverage calculator</button>
                <button onclick="show('sessions',this)">Market sessions</button>
                <button onclick="show('rules',this)">Beginner rules</button>
            </div>
        </div>
    </section>

    <div class="container">
        <div id="what" class="edu-section active">
            <div class="card">
                <span class="badge info">The basics</span>
                <h3>Forex = Foreign Exchange</h3>
                <p>Every time you travel abroad and exchange money, you're doing forex. The forex market is just this — but
                    at a
                    massive scale, where banks, companies, and traders swap currencies to profit from price changes.</p>
            </div>
            <div class="card">
                <h3>How big is it?</h3>
                <p>Forex is the <strong>largest financial market in the world</strong> — over <strong>$7.5 trillion</strong>
                    traded every single day. It dwarfs the stock market. It runs 24 hours a day, 5 days a week across global
                    financial centres.</p>
            </div>
            <div class="card">
                <h3>How do traders make money?</h3>
                <p>You buy a currency when you think it will <strong style="color:#3B6D11">rise in value</strong>, and sell
                    it
                    when you think it will <strong style="color:#791F1F">fall</strong>. The difference between your entry
                    and
                    exit price is your profit or loss.</p>
                <br>
                <p style="font-size:13px;background:#f7f7f7;padding:10px;border-radius:8px;line-height:1.7">
                    <strong>Example:</strong> You buy EUR/USD at 1.0800. The price rises to 1.0850. You close the trade. You
                    made <strong style="color:#3B6D11">50 pips profit</strong>.
                </p>
            </div>
            <div class="card">
                <h3>Who trades forex?</h3>
                <p>Central banks · Commercial banks · Hedge funds · Multinational corporations · Individual retail traders
                    (that's you!)</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div id="pairs" class="edu-section">
            <div class="card">
                <span class="badge info">Live-style display</span>
                <h3>Major currency pairs</h3>
                <p style="margin-bottom:12px">In forex, you always trade one currency <em>against</em> another. The first is
                    the
                    <strong>base</strong> currency, the second is the <strong>quote</strong> currency.
                </p>
                <div class="pair-row">
                    <div class="pair-card">
                        <div class="pair-name">EUR/USD</div>
                        <div class="pair-rate">1.0842</div>
                        <div class="pair-change up">+0.12%</div>
                    </div>
                    <div class="pair-card">
                        <div class="pair-name">GBP/USD</div>
                        <div class="pair-rate">1.2731</div>
                        <div class="pair-change up">+0.08%</div>
                    </div>
                    <div class="pair-card">
                        <div class="pair-name">USD/JPY</div>
                        <div class="pair-rate">153.44</div>
                        <div class="pair-change dn">-0.21%</div>
                    </div>
                    <div class="pair-card">
                        <div class="pair-name">USD/CHF</div>
                        <div class="pair-rate">0.9012</div>
                        <div class="pair-change dn">-0.05%</div>
                    </div>
                </div>
                <p style="font-size:12px;color:#999">These are illustrative prices for educational purposes.</p>
            </div>
            <div class="card">
                <h3>Reading a pair</h3>
                <p>EUR/USD = 1.0842 means: <strong>1 Euro</strong> buys <strong>1.0842 US Dollars</strong>.</p>
                <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:12px">
                    <div style="flex:1;min-width:120px;background:#f7f7f7;border-radius:8px;padding:10px">
                        <div style="font-size:11px;color:#999;margin-bottom:4px">Base currency</div>
                        <div style="font-size:22px;font-weight:500">EUR</div>
                        <div style="font-size:12px;color:#555">What you buy/sell</div>
                    </div>
                    <div style="display:flex;align-items:center;font-size:20px;color:#ccc">/</div>
                    <div style="flex:1;min-width:120px;background:#f7f7f7;border-radius:8px;padding:10px">
                        <div style="font-size:11px;color:#999;margin-bottom:4px">Quote currency</div>
                        <div style="font-size:22px;font-weight:500">USD</div>
                        <div style="font-size:12px;color:#555">What you pay with</div>
                    </div>
                </div>
            </div>
            <div class="card">
                <h3>Types of pairs</h3>
                <p><strong>Majors</strong> — Most traded, lowest spreads. Always include USD (EUR/USD, GBP/USD,
                    USD/JPY).<br><br>
                    <strong>Minors</strong> — Don't include USD but use major currencies (EUR/GBP, EUR/JPY).<br><br>
                    <strong>Exotics</strong> — One major + emerging market currency. Higher risk, wider spreads (USD/TRY,
                    EUR/ZAR).
                </p>
            </div>
        </div>
    </div>

    <div class="container">
        <div id="pips" class="edu-section">
            <div class="card">
                <span class="badge warn">Key concept</span>
                <h3>What is a pip?</h3>
                <p>A <strong>pip</strong> (Percentage In Point) is the smallest standard price move in a currency pair.
                    For most
                    pairs, it's the <strong>4th decimal place</strong>.</p>
                <div class="pip-demo">
                    <div>
                        <div class="pip-digit">1</div>
                        <div class="pip-label">1</div>
                    </div>
                    <div>
                        <div class="pip-digit">.</div>
                        <div class="pip-label">&nbsp;</div>
                    </div>
                    <div>
                        <div class="pip-digit">0</div>
                        <div class="pip-label">0</div>
                    </div>
                    <div>
                        <div class="pip-digit">8</div>
                        <div class="pip-label">0</div>
                    </div>
                    <div>
                        <div class="pip-digit highlight">4</div>
                        <div class="pip-label">← pip</div>
                    </div>
                    <div>
                        <div class="pip-digit" style="font-size:14px;color:#aaa">2</div>
                        <div class="pip-label">pipette</div>
                    </div>
                </div>
                <p style="font-size:13px;margin-top:8px">So <strong>1.0842 → 1.0843</strong> = moved 1 pip. For USD/JPY,
                    the pip
                    is the <strong>2nd decimal place</strong> (e.g. 153.44 → 153.45).</p>
            </div>
            <div class="card">
                <h3>What is the spread?</h3>
                <p>The spread is the difference between the <strong>Bid</strong> (sell price) and <strong>Ask</strong>
                    (buy
                    price). This is the broker's fee — you enter at a small disadvantage.</p>
                <div class="spread-vis">
                    <div class="bid">BID 1.0840<br><span style="font-size:11px">You sell here</span></div>
                    <div class="mid">SPREAD<br>2 pips</div>
                    <div class="ask">ASK 1.0842<br><span style="font-size:11px">You buy here</span></div>
                </div>
                <p style="font-size:13px;color:#555">Tighter spread = cheaper to trade. Majors like EUR/USD typically
                    have very
                    tight spreads (1–2 pips). Exotics can be 20–50 pips wide.</p>
            </div>
            <div class="card">
                <h3>Pip value</h3>
                <p style="font-size:13px">On a <strong>standard lot (100,000 units)</strong>, 1 pip = ~$10. On a
                    <strong>mini
                        lot (10,000 units)</strong>, 1 pip = ~$1. On a <strong>micro lot (1,000 units)</strong>, 1 pip =
                    ~$0.10.
                    Beginners should always start with micro lots.
                </p>
            </div>
        </div>
    </div>

    <div class="container">
        <div id="leverage" class="edu-section">
            <div class="card">
                <span class="badge warn">Use carefully</span>
                <h3>Leverage calculator</h3>
                <p>Leverage lets you control a large position with a small deposit (margin). It magnifies both
                    profits
                    <em>and</em> losses.
                </p>
                <div class="calc-row"><label>Account size</label><input type="range" min="500" max="50000"
                        step="500" value="5000" id="acc" oninput="calc()"><span id="acc-v">$5,000</span>
                </div>
                <div class="calc-row"><label>Leverage</label><input type="range" min="1" max="100"
                        step="1" value="30" id="lev" oninput="calc()"><span id="lev-v">1:30</span>
                </div>
                <div class="calc-row"><label>Trade size</label><input type="range" min="1" max="1000"
                        step="1" value="100" id="lots" oninput="calc()"><span id="lots-v">1.00
                        lots</span>
                </div>
                <div class="result-box" id="calc-result"></div>
            </div>
            <div class="card">
                <h3>The double edge</h3>
                <p><span style="color:#3B6D11"><strong>With 1:100 leverage:</strong></span> A 1% market move in
                    your favour =
                    100% return on margin.<br><br>
                    <span style="color:#791F1F"><strong>But also:</strong></span> A 1% market move against you =
                    100% loss of
                    margin. Your account can be wiped in minutes.
                </p>
            </div>
            <div class="card" style="border-color:#fbbf24">
                <h3>Recommended for beginners</h3>
                <p>Start with <strong>1:10 leverage or lower</strong>. Many regulators now cap retail leverage at
                    1:30 for major
                    pairs. Never risk more than <strong>1–2% of your account</strong> on a single trade.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div id="sessions" class="edu-section">
            <div class="card">
                <h3>Forex is open 24 hours — but not equally active</h3>
                <p style="margin-bottom:12px">The market runs across four global sessions. Each has its own character
                    and best
                    pairs to trade.</p>
                <div class="session-bar">
                    <div class="sess" style="flex:2;background:#B5D4F4;color:#042C53">Sydney</div>
                    <div class="sess" style="flex:3;background:#378ADD;color:#fff">Tokyo</div>
                    <div class="sess" style="flex:3;background:#0C447C;color:#fff">London</div>
                    <div class="sess" style="flex:2.5;background:#185FA5;color:#fff">New York</div>
                </div>
                <p style="font-size:12px;color:#999;margin-bottom:12px">← Sydney open
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New
                    York close →</p>
                <div class="session-grid">
                    <div class="pair-card">
                        <div class="pair-name" style="color:#185FA5">Sydney</div>
                        <div style="font-size:12px;color:#555;margin-top:4px">10pm–7am GMT<br>Quietest session<br>AUD,
                            NZD
                            pairs</div>
                    </div>
                    <div class="pair-card">
                        <div class="pair-name" style="color:#185FA5">Tokyo</div>
                        <div style="font-size:12px;color:#555;margin-top:4px">12am–9am GMT<br>Asian markets
                            active<br>JPY, AUD
                            pairs</div>
                    </div>
                    <div class="pair-card">
                        <div class="pair-name" style="color:#0C447C">London</div>
                        <div style="font-size:12px;color:#555;margin-top:4px">8am–5pm GMT<br><strong
                                style="color:#3B6D11">Most liquid session</strong><br>EUR, GBP pairs</div>
                    </div>


                    <div class="pair-card">
                        <div class="pair-name" style="color:#0C447C">New York</div>
                        <div style="font-size:12px;color:#555;margin-top:4px">1pm–10pm GMT<br>High volatility<br>USD
                            pairs
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <h3>The London–New York overlap</h3>
                <p>The <strong>1pm–5pm GMT window</strong> (when London and New York are both open) is the <em>most
                        active
                        period</em> of the entire trading week. Spreads are tightest and price moves are largest. Most
                    professional traders focus on this window.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div id="rules" class="edu-section">
            <div class="card">
                <h3>Golden rules for beginners</h3>
                <ul class="rule-list">
                    <li><span class="icon">📋</span>
                        <div><strong>Always use a demo account first.</strong> Practice for at least 3–6 months before
                            risking
                            real money. Most brokers offer free demo accounts with virtual funds.</div>
                    </li>
                    <li><span class="icon">🎯</span>
                        <div><strong>Never risk more than 1–2% per trade.</strong> If you have $1,000, risk max $10–$20
                            per
                            trade. This keeps you in the game long enough to learn.</div>
                    </li>
                    <li><span class="icon">🛑</span>
                        <div><strong>Always use a stop loss.</strong> A stop loss automatically closes your trade if it
                            moves
                            too far against you. Never trade without one.</div>
                    </li>
                    <li><span class="icon">📰</span>
                        <div><strong>Watch economic news.</strong> Events like interest rate decisions, inflation data,
                            and
                            employment reports cause huge price moves. Check an economic calendar before trading.</div>
                    </li>
                    <li><span class="icon">📓</span>
                        <div><strong>Keep a trading journal.</strong> Write down every trade — why you entered, what
                            happened,
                            what you learned. It's the fastest way to improve.</div>
                    </li>
                    <li><span class="icon">🧠</span>
                        <div><strong>Control your emotions.</strong> Fear and greed are your biggest enemies. If you're
                            chasing
                            a loss or feeling over-confident, step away from the screen.</div>
                    </li>
                    <li><span class="icon">🎓</span>
                        <div><strong>Start with one pair.</strong> Master EUR/USD before touching anything else. It's
                            the most
                            liquid, has the tightest spreads, and has the most learning resources.</div>
                    </li>
                </ul>
            </div>
            <div class="card" style="border-color:#fbbf24">
                <span class="badge warn">Reality check</span>
                <h3>Most retail traders lose money</h3>
                <p>Studies show <strong>70–80% of retail forex traders lose money</strong>. This doesn't mean you can't
                    succeed
                    — but it means you must treat this as a skill that takes years to develop, not a quick money scheme.
                </p>
            </div>
        </div>
    </div>

    <script>
        function show(id, btn) {
            document.querySelectorAll('.edu-section').forEach(s => s.classList.remove('active'));
            document.querySelectorAll('.edu-nav button').forEach(b => b.classList.remove('active'));
            document.getElementById(id).classList.add('active');
            btn.classList.add('active');
        }

        function calc() {
            const acc = +document.getElementById('acc').value;
            const lev = +document.getElementById('lev').value;
            const lots = +document.getElementById('lots').value / 100;
            document.getElementById('acc-v').textContent = '$' + acc.toLocaleString();
            document.getElementById('lev-v').textContent = '1:' + lev;
            document.getElementById('lots-v').textContent = lots.toFixed(2) + ' lots';
            const position = lots * 100000;
            const margin = position / lev;
            const pip_val = lots * 10;
            const pct = (margin / acc * 100).toFixed(1);
            const color = pct > 50 ? '#791F1F' : pct > 20 ? '#92400e' : '#3B6D11';
            document.getElementById('calc-result').innerHTML =
                '<strong>Position size:</strong> $' + position.toLocaleString() + '<br>' +
                '<strong>Margin required:</strong> $' + Math.round(margin).toLocaleString() + ' (' + pct +
                '% of account)<br>' +
                '<strong>1 pip value:</strong> $' + pip_val.toFixed(2) + '<br>' +
                '<strong>Risk level:</strong> <span style="color:' + color + ';font-weight:500">' +
                (pct > 50 ? 'Very high — reduce leverage or lots' : pct > 20 ? 'Moderate — be careful' :
                    'Conservative — suitable for beginners') +
                '</span>';
        }
        calc();
    </script>
@endsection
