<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wealthora — Signal Creator</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&amp;display=swap">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg: #0a0c10;
            --surface: #111318;
            --card: #161a22;
            --border: #1e2330;
            --border-hi: #2a3245;
            --text: #e2e8f0;
            --muted: #64748b;
            --dim: #94a3b8;

            --green: #00d084;
            --green-dim: rgba(0, 208, 132, .12);
            --green-glow: rgba(0, 208, 132, .25);

            --red: #ff4d6a;
            --red-dim: rgba(255, 77, 106, .12);

            --gold: #f5a623;
            --gold-dim: rgba(245, 166, 35, .10);

            --blue: #3b82f6;
            --blue-dim: rgba(59, 130, 246, .12);

            --accent: #7c3aed;
            --accent2: #a855f7;
        }

        body {
            background: #fff;
            color: var(--text);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Header ── */
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 32px;
            border-bottom: 1px solid var(--border);
            background: #fff;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 18px;
            color: var(--text);
            letter-spacing: -0.5px;
        }

        .logo-mark {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .header-tag {
            font-family: 'Poppins', sans-serif;
            font-size: 11px;
            color: var(--green);
            background: var(--green-dim);
            border: 1px solid rgba(0, 208, 132, .2);
            padding: 4px 10px;
            border-radius: 20px;
            letter-spacing: 0.5px;
        }

        /* ── Layout ── */
        main {
            flex: 1;
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 0;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            padding: 32px 24px;
            gap: 24px;
            align-items: start;
        }

        /* ── Form Panel ── */
        .form-panel {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .panel-title {
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            font-weight: 600;
            color: var(--muted);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .card-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--dim);
            letter-spacing: 0.3px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-label .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        /* ── Direction Toggle ── */
        .direction-toggle {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .dir-btn {
            padding: 14px;
            border-radius: 10px;
            border: 2px solid var(--border);
            background: transparent;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 1px;
            transition: all 0.18s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: var(--muted);
        }

        .dir-btn:hover {
            border-color: var(--border-hi);
            color: var(--text);
        }

        .dir-btn.buy.active {
            background: var(--green-dim);
            border-color: var(--green);
            color: var(--green);
            box-shadow: 0 0 20px var(--green-glow);
        }

        .dir-btn.sell.active {
            background: var(--red-dim);
            border-color: var(--red);
            color: var(--red);
            box-shadow: 0 0 20px rgba(255, 77, 106, .2);
        }

        /* ── Pair Selector ── */
        .pair-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }

        .pair-btn {
            padding: 10px 6px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: transparent;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-size: 11px;
            font-weight: 600;
            color: var(--muted);
            transition: all 0.15s ease;
            text-align: center;
        }

        .pair-btn:hover {
            border-color: var(--border-hi);
            color: var(--dim);
        }

        .pair-btn.active {
            background: var(--blue-dim);
            border-color: var(--blue);
            color: var(--blue);
        }

        .pair-custom-row {
            display: flex;
            gap: 8px;
            margin-top: 8px;
        }

        .pair-custom-row input {
            flex: 1;
        }

        /* ── Inputs ── */
        .field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .field.full {
            grid-column: 1 / -1;
        }

        label {
            font-size: 11px;
            font-weight: 600;
            color: var(--muted);
            letter-spacing: 0.8px;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .label-badge {
            font-size: 10px;
            padding: 1px 6px;
            border-radius: 4px;
            font-weight: 500;
            text-transform: none;
            letter-spacing: 0;
        }

        .badge-green {
            background: var(--green-dim);
            color: var(--green);
        }

        .badge-red {
            background: var(--red-dim);
            color: var(--red);
        }

        .badge-gold {
            background: var(--gold-dim);
            color: var(--gold);
        }

        input[type="text"],
        input[type="number"],
        select {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 500;
            padding: 11px 14px;
            width: 100%;
            transition: border-color 0.15s, box-shadow 0.15s;
            outline: none;
            -moz-appearance: textfield;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }

        input:focus,
        select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, .15);
        }

        input.green-focus:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px var(--green-glow);
        }

        input.red-focus:focus {
            border-color: var(--red);
            box-shadow: 0 0 0 3px rgba(255, 77, 106, .15);
        }

        input.gold-focus:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(245, 166, 35, .15);
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
        }

        select option {
            background: var(--card);
        }

        /* ── Random Button ── */
        .randomize-btn {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 14px;
            border-radius: 8px;
            border: 1px solid var(--border-hi);
            background: transparent;
            color: var(--dim);
            font-family: 'Poppins', sans-serif;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
            letter-spacing: 0.5px;
        }

        .randomize-btn:hover {
            border-color: var(--accent);
            color: var(--accent2);
            background: rgba(124, 58, 237, .08);
        }

        .randomize-btn svg {
            transition: transform 0.3s;
        }

        .randomize-btn:hover svg {
            transform: rotate(180deg);
        }

        /* ── Channel Toggle ── */
        .channel-toggle {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .channel-btn {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: transparent;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            color: var(--muted);
            transition: all 0.15s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
        }

        .channel-btn.active {
            background: var(--gold-dim);
            border-color: var(--gold);
            color: var(--gold);
        }

        /* ── Submit ── */
        .submit-btn {
            width: 100%;
            padding: 16px;
            border-radius: 10px;
            border: none;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            letter-spacing: 0.2px;
            position: relative;
            overflow: hidden;
        }

        .submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(124, 58, 237, .4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .submit-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .submit-btn .spinner {
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, .3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            display: none;
        }

        .submit-btn.loading .spinner {
            display: block;
        }

        .submit-btn.loading .btn-text {
            display: none;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ── Preview Panel ── */
        .preview-panel {
            position: sticky;
            top: 88px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .preview-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .preview-header {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .preview-title {
            font-size: 11px;
            font-weight: 600;
            color: var(--muted);
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .live-dot {
            width: 7px;
            height: 7px;
            background: var(--green);
            border-radius: 50%;
            box-shadow: 0 0 6px var(--green);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.4;
            }
        }

        .tg-preview {
            padding: 20px 18px;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            line-height: 1.8;
            color: var(--text);
            min-height: 200px;
        }

        .tg-preview .pair-dir {
            font-weight: 700;
            font-size: 15px;
        }

        .tg-preview .buy-color {
            color: var(--green);
        }

        .tg-preview .sell-color {
            color: var(--red);
        }

        .tg-preview .val {
            color: var(--gold);
        }

        .tg-preview .tp {
            color: var(--green);
        }

        .tg-preview .sl {
            color: var(--red);
        }

        .tg-preview .placeholder {
            color: var(--muted);
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 160px;
            flex-direction: column;
            gap: 8px;
        }

        /* ── Risk Meter ── */
        .risk-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 18px;
            border-top: 1px solid var(--border);
            font-size: 11px;
            color: var(--muted);
            font-family: 'Poppins', sans-serif;
        }

        .risk-val {
            font-weight: 600;
        }

        .risk-good {
            color: var(--green);
        }

        .risk-warn {
            color: var(--gold);
        }

        .risk-bad {
            color: var(--red);
        }

        /* ── Toast ── */
        .toast {
            position: fixed;
            bottom: 28px;
            right: 28px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
            transform: translateY(80px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            z-index: 999;
            max-width: 360px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .4);
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        .toast.success {
            border-color: var(--green);
        }

        .toast.error {
            border-color: var(--red);
        }

        .toast-icon {
            font-size: 20px;
        }

        .toast-msg {
            flex: 1;
        }

        .toast-msg strong {
            display: block;
            margin-bottom: 2px;
        }

        .toast-msg span {
            font-size: 12px;
            color: var(--muted);
        }

        /* ── Divider ── */
        .divider {
            height: 1px;
            background: var(--border);
            margin: 4px 0;
        }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            main {
                grid-template-columns: 1fr;
            }

            .preview-panel {
                position: static;
            }

            .pair-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            header {
                padding: 14px 20px;
            }

            main {
                padding: 20px 16px;
            }
        }

        @media (max-width: 480px) {
            .pair-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .field-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <header>
        <div class="logo">
            <img src="{{url('public/frontend/images/logo.png')}}" alt="Wealthora" height="40">
        </div>
    </header>

    <main>
        <!-- ── Form Panel ── -->
        <div class="form-panel">

            <!-- Direction -->
            <div class="card">
                <div class="card-header">
                    <span class="card-label">
                        <span class="dot" style="background:var(--blue)"></span>
                        Direction
                    </span>
                </div>
                <div class="direction-toggle">
                    <button class="dir-btn buy active" onclick="setDirection('BUY')">
                        ▲ BUY
                    </button>
                    <button class="dir-btn sell" onclick="setDirection('SELL')">
                        ▼ SELL
                    </button>
                </div>
            </div>

            <!-- Pair -->
            <div class="card">
                <div class="card-header">
                    <span class="card-label">
                        <span class="dot" style="background:var(--gold)"></span>
                        Instrument
                    </span>
                </div>
                <div class="pair-grid" id="pairGrid">
                    <button class="pair-btn active" onclick="setPair('GBP/USD')">GBP/USD</button>
                    <button class="pair-btn" onclick="setPair('EUR/USD')">EUR/USD</button>
                    <button class="pair-btn" onclick="setPair('USD/JPY')">USD/JPY</button>
                    <button class="pair-btn" onclick="setPair('AUD/USD')">AUD/USD</button>
                    <button class="pair-btn" onclick="setPair('USD/CAD')">USD/CAD</button>
                    <button class="pair-btn" onclick="setPair('NZD/USD')">NZD/USD</button>
                    <button class="pair-btn" onclick="setPair('XAU/USD')">XAU/USD</button>
                    <button class="pair-btn" onclick="setPair('XAG/USD')">XAG/USD</button>
                    <button class="pair-btn" onclick="setPair('NAS100')">NAS100</button>
                    <button class="pair-btn" onclick="setPair('US30')">US30</button>
                    <button class="pair-btn" onclick="setPair('BTC/USD')">BTC/USD</button>
                    <button class="pair-btn custom-btn" onclick="focusCustomPair()">+ Custom</button>
                </div>
                <div class="pair-custom-row" id="customPairRow" style="display:none;">
                    <input type="text" id="customPair" placeholder="e.g. USD/CHF" style="text-transform:uppercase"
                        oninput="this.value=this.value.toUpperCase(); setPair(this.value)" />
                </div>
            </div>

            <!-- Price Levels -->
            <div class="card">
                <div class="card-header">
                    <span class="card-label">
                        <span class="dot" style="background:var(--green)"></span>
                        Price Levels
                    </span>
                    <button class="randomize-btn" onclick="randomizePrices()" title="Generate random values">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <path d="M1 4v6h6M23 20v-6h-6" />
                            <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10M23 14l-4.64 4.36A9 9 0 0 1 3.51 15" />
                        </svg>
                        RANDOMIZE
                    </button>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label>
                            Entry Min
                            <span class="label-badge badge-green">FROM</span>
                        </label>
                        <input type="number" id="entryMin" class="green-focus" placeholder="1.28000" step="0.00001"
                            oninput="updatePreview()" />
                    </div>
                    <div class="field">
                        <label>
                            Entry Max
                            <span class="label-badge badge-green">TO</span>
                        </label>
                        <input type="number" id="entryMax" class="green-focus" placeholder="1.28200" step="0.00001"
                            oninput="updatePreview()" />
                    </div>
                </div>

                <div style="height:14px"></div>

                <div class="field-row">
                    <div class="field full">
                        <label>
                            Stop Loss
                            <span class="label-badge badge-red">SL</span>
                        </label>
                        <input type="number" id="sl" class="red-focus" placeholder="1.27500" step="0.00001"
                            oninput="updatePreview()" />
                    </div>
                </div>

                <div style="height:14px"></div>

                <div class="field-row">
                    <div class="field">
                        <label>TP1 <span class="label-badge badge-gold">TARGET</span></label>
                        <input type="number" id="tp1" class="gold-focus" placeholder="1.28800"
                            step="0.00001" oninput="updatePreview()" />
                    </div>
                    <div class="field">
                        <label>TP2 <span class="label-badge badge-gold">TARGET</span></label>
                        <input type="number" id="tp2" class="gold-focus" placeholder="1.29200"
                            step="0.00001" oninput="updatePreview()" />
                    </div>
                    <div class="field">
                        <label>TP3 <span class="label-badge badge-gold">TARGET</span></label>
                        <input type="number" id="tp3" class="gold-focus" placeholder="1.29600"
                            step="0.00001" oninput="updatePreview()" />
                    </div>
                </div>
            </div>

            <!-- Channel -->
            <div class="card">
                <div class="card-header">
                    <span class="card-label">
                        <span class="dot" style="background:var(--gold)"></span>
                        Post To
                    </span>
                </div>
                <div class="channel-toggle">
                    <button class="channel-btn active" onclick="setChannel('public')">
                        📢 Public Channel
                    </button>
                    <button class="channel-btn" onclick="setChannel('vip')">
                        👑 VIP Channel
                    </button>
                </div>
            </div>

            <!-- Submit -->
            <button class="submit-btn" id="submitBtn" onclick="submitSignal()">
                <div class="spinner"></div>
                <span class="btn-text">📤 Send to Approval Desk</span>
            </button>

        </div>

        <!-- ── Preview Panel ── -->
        <div class="preview-panel">
            <div class="preview-card">
                <div class="preview-header">
                    <span class="preview-title">Telegram Preview</span>
                    <div class="live-dot"></div>
                </div>
                <div class="tg-preview" id="tgPreview">
                    <div class="placeholder">
                        <span style="font-size:28px">📊</span>
                        <span>Fill in the form to see<br>the Telegram message preview</span>
                    </div>
                </div>
                <div class="risk-row" id="riskRow" style="display:none">
                    <span>Risk : Reward</span>
                    <span class="risk-val" id="riskVal">—</span>
                </div>
            </div>

            <!-- Stats row -->
            <div class="card" id="statsCard" style="display:none; padding:16px 18px;">
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; text-align:center;">
                    <div>
                        <div
                            style="font-size:10px;color:var(--muted);letter-spacing:.8px;text-transform:uppercase;margin-bottom:4px">
                            SL Pips</div>
                        <div id="slPips"
                            style="font-family:'JetBrains Mono';font-size:15px;font-weight:700;color:var(--red)">—
                        </div>
                    </div>
                    <div>
                        <div
                            style="font-size:10px;color:var(--muted);letter-spacing:.8px;text-transform:uppercase;margin-bottom:4px">
                            TP1 Pips</div>
                        <div id="tp1Pips"
                            style="font-family:'JetBrains Mono';font-size:15px;font-weight:700;color:var(--green)">—
                        </div>
                    </div>
                    <div>
                        <div
                            style="font-size:10px;color:var(--muted);letter-spacing:.8px;text-transform:uppercase;margin-bottom:4px">
                            Max TP</div>
                        <div id="maxTpPips"
                            style="font-family:'JetBrains Mono';font-size:15px;font-weight:700;color:var(--gold)">—
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Toast -->
    <div class="toast" id="toast">
        <span class="toast-icon" id="toastIcon">✅</span>
        <div class="toast-msg">
            <strong id="toastTitle"></strong>
            <span id="toastSub"></span>
        </div>
    </div>

    <script>

        APIurl = "{{url('/')}}";
        // ── State ──────────────────────────────────────────────────────────────────
        const state = {
            direction: 'BUY',
            pair: 'GBP/USD',
            channel: 'public',
        };

        // ── Pair configs for random generation ────────────────────────────────────
        const PAIR_CONFIG = {
            'GBP/USD': {
                base: 1.2700,
                spread: 0.0030,
                digits: 5,
                mult: 10000,
                unit: 'PIPS'
            },
            'EUR/USD': {
                base: 1.0800,
                spread: 0.0025,
                digits: 5,
                mult: 10000,
                unit: 'PIPS'
            },
            'USD/JPY': {
                base: 149.50,
                spread: 0.30,
                digits: 3,
                mult: 100,
                unit: 'PIPS'
            },
            'AUD/USD': {
                base: 0.6500,
                spread: 0.0020,
                digits: 5,
                mult: 10000,
                unit: 'PIPS'
            },
            'USD/CAD': {
                base: 1.3600,
                spread: 0.0025,
                digits: 5,
                mult: 10000,
                unit: 'PIPS'
            },
            'NZD/USD': {
                base: 0.6100,
                spread: 0.0020,
                digits: 5,
                mult: 10000,
                unit: 'PIPS'
            },
            'XAU/USD': {
                base: 2020,
                spread: 5,
                digits: 2,
                mult: 1,
                unit: 'POINTS'
            },
            'XAG/USD': {
                base: 24.00,
                spread: 0.20,
                digits: 3,
                mult: 1,
                unit: 'POINTS'
            },
            'NAS100': {
                base: 17500,
                spread: 20,
                digits: 1,
                mult: 1,
                unit: 'POINTS'
            },
            'US30': {
                base: 38000,
                spread: 30,
                digits: 1,
                mult: 1,
                unit: 'POINTS'
            },
            'BTC/USD': {
                base: 65000,
                spread: 200,
                digits: 0,
                mult: 1,
                unit: 'POINTS'
            },
        };

        function getCfg() {
            return PAIR_CONFIG[state.pair] || PAIR_CONFIG['GBP/USD'];
        }

        // ── Direction ──────────────────────────────────────────────────────────────
        function setDirection(dir) {
            state.direction = dir;
            document.querySelectorAll('.dir-btn').forEach(b => b.classList.remove('active'));
            document.querySelector(`.dir-btn.${dir.toLowerCase()}`).classList.add('active');
            updatePreview();
        }

        // ── Pair ───────────────────────────────────────────────────────────────────
        function setPair(pair) {
            if (!pair) return;
            state.pair = pair.toUpperCase();
            document.querySelectorAll('.pair-btn:not(.custom-btn)').forEach(b => {
                b.classList.toggle('active', b.textContent === state.pair);
            });
            // Check if it's a custom pair (not in grid)
            const inGrid = [...document.querySelectorAll('.pair-btn:not(.custom-btn)')].some(b => b.textContent === state
                .pair);
            if (!inGrid && state.pair) {
                document.getElementById('customPairRow').style.display = 'flex';
            }
            updatePreview();
        }

        function focusCustomPair() {
            document.getElementById('customPairRow').style.display = 'flex';
            document.getElementById('customPair').focus();
            document.querySelectorAll('.pair-btn').forEach(b => b.classList.remove('active'));
            document.querySelector('.custom-btn').classList.add('active');
        }

        // ── Channel ────────────────────────────────────────────────────────────────
        function setChannel(ch) {
            state.channel = ch;
            document.querySelectorAll('.channel-btn').forEach(b => b.classList.remove('active'));
            event.currentTarget.classList.add('active');
        }

        // ── Randomize ─────────────────────────────────────────────────────────────
        function randomizePrices() {
            const cfg = getCfg();
            const d = cfg.digits;

            // Random entry base near the pair's typical price ±2×spread
            const variance = cfg.spread * (1 + Math.random() * 2);
            const entryBase = cfg.base + (Math.random() - 0.5) * variance * 4;
            const entryRange = cfg.spread * (0.3 + Math.random() * 0.7);

            const entryMin = parseFloat(entryBase.toFixed(d));
            const entryMax = parseFloat((entryBase + entryRange).toFixed(d));

            // SL: below entry for BUY, above for SELL
            const slDist = cfg.spread * (2 + Math.random() * 3);
            const sl = state.direction === 'BUY' ?
                parseFloat((entryMin - slDist).toFixed(d)) :
                parseFloat((entryMax + slDist).toFixed(d));

            // TPs: above entry for BUY, below for SELL
            const tp1Dist = cfg.spread * (2 + Math.random() * 2);
            const tp2Dist = tp1Dist + cfg.spread * (1 + Math.random() * 2);
            const tp3Dist = tp2Dist + cfg.spread * (1 + Math.random() * 2);

            let tp1, tp2, tp3;
            if (state.direction === 'BUY') {
                tp1 = parseFloat((entryMax + tp1Dist).toFixed(d));
                tp2 = parseFloat((entryMax + tp2Dist).toFixed(d));
                tp3 = parseFloat((entryMax + tp3Dist).toFixed(d));
            } else {
                tp1 = parseFloat((entryMin - tp1Dist).toFixed(d));
                tp2 = parseFloat((entryMin - tp2Dist).toFixed(d));
                tp3 = parseFloat((entryMin - tp3Dist).toFixed(d));
            }

            // Animate fill
            animateFill('entryMin', entryMin);
            animateFill('entryMax', entryMax);
            animateFill('sl', sl);
            animateFill('tp1', tp1);
            animateFill('tp2', tp2);
            animateFill('tp3', tp3);

            setTimeout(updatePreview, 80);
        }

        function animateFill(id, val) {
            const el = document.getElementById(id);
            el.style.transition = 'background 0.3s';
            el.style.background = 'rgba(124,58,237,.15)';
            el.value = val;
            setTimeout(() => {
                el.style.background = '';
            }, 400);
        }

        // ── Preview ────────────────────────────────────────────────────────────────
        function updatePreview() {
            const entryMin = parseFloat(document.getElementById('entryMin').value);
            const entryMax = parseFloat(document.getElementById('entryMax').value);
            const sl = parseFloat(document.getElementById('sl').value);
            const tp1 = parseFloat(document.getElementById('tp1').value);
            const tp2 = parseFloat(document.getElementById('tp2').value);
            const tp3 = parseFloat(document.getElementById('tp3').value);

            const hasEntry = !isNaN(entryMin);
            const hasSL = !isNaN(sl);

            if (!hasEntry || !hasSL) {
                document.getElementById('tgPreview').innerHTML = `
      <div class="placeholder">
        <span style="font-size:28px">📊</span>
        <span>Fill in Entry & SL to see preview</span>
      </div>`;
                document.getElementById('riskRow').style.display = 'none';
                document.getElementById('statsCard').style.display = 'none';
                return;
            }

            const dirColor = state.direction === 'BUY' ? 'buy-color' : 'sell-color';
            const dirArrow = state.direction === 'BUY' ? '▲' : '▼';
            const entry = (!isNaN(entryMax) && entryMax !== entryMin) ?
                `${fmt(entryMin)} – ${fmt(entryMax)}` :
                fmt(entryMin);

            let html = `
    <div class="pair-dir ${dirColor}">${dirArrow} ${state.pair} ${state.direction}</div>
    <div style="height:10px"></div>
    <div>📍 Entry: <span class="val">${entry}</span></div>
    <div>🛑 SL: <span class="sl">${fmt(sl)}</span></div>`;

            if (!isNaN(tp1)) html += `<div>🎯 TP1: <span class="tp">${fmt(tp1)}</span></div>`;
            if (!isNaN(tp2)) html += `<div>🎯 TP2: <span class="tp">${fmt(tp2)}</span></div>`;
            if (!isNaN(tp3)) html += `<div>🎯 TP3: <span class="tp">${fmt(tp3)}</span></div>`;

            html +=
                `<div style="height:10px"></div><div style="color:var(--muted);font-size:11px">📢 ${state.channel.toUpperCase()}</div>`;

            document.getElementById('tgPreview').innerHTML = html;

            // Risk:Reward
            const cfg = getCfg();
            const eRef = (!isNaN(entryMax)) ? Math.max(entryMin, entryMax) : entryMin;
            const slPips = Math.abs(eRef - sl) * cfg.mult;
            const tp1Pips = !isNaN(tp1) ? Math.abs(eRef - tp1) * cfg.mult : null;
            const maxTp = !isNaN(tp3) ? tp3 : (!isNaN(tp2) ? tp2 : tp1);
            const maxPips = maxTp ? Math.abs(eRef - maxTp) * cfg.mult : null;

            if (tp1Pips !== null) {
                const rr = (tp1Pips / slPips).toFixed(2);
                const cls = rr >= 2 ? 'risk-good' : rr >= 1 ? 'risk-warn' : 'risk-bad';
                document.getElementById('riskVal').className = `risk-val ${cls}`;
                document.getElementById('riskVal').textContent = `1 : ${rr}`;
                document.getElementById('riskRow').style.display = 'flex';

                document.getElementById('slPips').textContent = Math.round(slPips) + ' ' + cfg.unit;
                document.getElementById('tp1Pips').textContent = Math.round(tp1Pips) + ' ' + cfg.unit;
                document.getElementById('maxTpPips').textContent = maxPips ? Math.round(maxPips) + ' ' + cfg.unit : '—';
                document.getElementById('statsCard').style.display = 'block';
            }
        }

        function fmt(n) {
            if (isNaN(n)) return '—';
            const cfg = getCfg();
            return n.toFixed(cfg.digits);
        }

        // ── Submit ─────────────────────────────────────────────────────────────────
        async function submitSignal() {
            const entryMin = parseFloat(document.getElementById('entryMin').value);
            const entryMax = parseFloat(document.getElementById('entryMax').value);
            const sl = parseFloat(document.getElementById('sl').value);
            const tp1 = parseFloat(document.getElementById('tp1').value);
            const tp2 = parseFloat(document.getElementById('tp2').value);
            const tp3 = parseFloat(document.getElementById('tp3').value);

            // Validate
            if (isNaN(entryMin)) {
                showToast('error', 'Missing Entry Min', 'Please enter at least an entry price.');
                return;
            }
            if (isNaN(sl)) {
                showToast('error', 'Missing Stop Loss', 'SL is required for every signal.');
                return;
            }

            const btn = document.getElementById('submitBtn');
            btn.classList.add('loading');
            btn.disabled = true;

            const payload = {
                pair: state.pair,
                direction: state.direction,
                entry_min: entryMin,
                entry_max: isNaN(entryMax) ? null : entryMax,
                sl: sl,
                tp1: isNaN(tp1) ? null : tp1,
                tp2: isNaN(tp2) ? null : tp2,
                tp3: isNaN(tp3) ? null : tp3,
                channel: state.channel,
            };

            try {
                // Step 1: Create signal
                const createRes = await fetch(APIurl+'/signals', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${getToken()}`,
                    },
                    body: JSON.stringify(payload),
                });

                const createData = await createRes.json();

                if (!createRes.ok) {
                    const msg = createData.message || 'Failed to create signal.';
                    showToast('error', 'Create Failed', msg);
                    return;
                }

                const signalId = createData.data?.id;

                // // Step 2: Submit to approval desk
                // const submitRes = await fetch(APIurl+`/signals/${signalId}/submit`, {
                //     method: 'POST',
                //     headers: {
                //         'Content-Type': 'application/json',
                //         'Accept': 'application/json',
                //         'Authorization': `Bearer ${getToken()}`,
                //     },
                // });

                // if (!submitRes.ok) {
                //     showToast('error', 'Submit Failed', 'Signal created but failed to send to approval desk.');
                //     return;
                // }

                showToast('success', 'Sent to Approval Desk!',
                    `${state.pair} ${state.direction} signal #${signalId} is pending review.`);
                resetForm();

            } catch (err) {
                showToast('error', 'Network Error', err.message || 'Could not reach the server.');
            } finally {
                btn.classList.remove('loading');
                btn.disabled = false;
            }
        }

        function getToken() {
            // Read from meta tag or localStorage — set this after login
            return document.querySelector('meta[name="api-token"]')?.content ||
                localStorage.getItem('wealthora_token') ||
                '';
        }

        function resetForm() {
            ['entryMin', 'entryMax', 'sl', 'tp1', 'tp2', 'tp3'].forEach(id => {
                document.getElementById(id).value = '';
            });
            updatePreview();
        }

        // ── Toast ──────────────────────────────────────────────────────────────────
        function showToast(type, title, sub) {
            const t = document.getElementById('toast');
            const icon = type === 'success' ? '✅' : '❌';
            document.getElementById('toastIcon').textContent = icon;
            document.getElementById('toastTitle').textContent = title;
            document.getElementById('toastSub').textContent = sub;
            t.className = `toast ${type} show`;
            setTimeout(() => {
                t.classList.remove('show');
            }, 4000);
        }

        // ── Init ───────────────────────────────────────────────────────────────────
        document.addEventListener('DOMContentLoaded', () => {
            updatePreview();
        });
    </script>
</body>

</html>
