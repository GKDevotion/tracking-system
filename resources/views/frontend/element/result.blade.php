
    <section class="forex-signal">

                <style>


                    /* Table wrapper */
                    .tbl-wrap {
                        border-radius: 8px;
                        overflow: hidden;
                        border: 1px solid #666666;
                    }

                    /* Table */
                    .sig-table {
                        width: 100%;
                        border-collapse: collapse;
                    }

                    /* Header */
                    .sig-table thead tr {
                        background: #000;
                    }
                    .sig-table thead th {
                        font-weight: 700;
                        font-size: rem;
                        letter-spacing: 0.1em;
                        text-transform: uppercase;
                        color: #fff;
                        padding: 15px 20px;
                        text-align: center;
                        white-space: nowrap;
                        border: none;
                    }

                    /* Body rows */
                    .sig-table tbody tr {
                        position: relative;
                        transition: background 0.2s ease, box-shadow 0.2s ease, transform 0.15s ease;
                        cursor: pointer;
                    }
                    .sig-table tbody tr:nth-child(odd)  {
                        background: #fff;
                    }

                    /* Hover */
                    .sig-table tbody tr:hover {
                    /* background: rgba(46,204,143,0.11) !important;  */
                    transform: scaleY(1.015);
                    z-index: 3;
                    }
                    .sig-table tbody tr:hover .btn-live {
                        background: #000;
                        /* box-shadow: 0 0 10px rgba(204, 46, 46, 0.6); */
                        /* color: #fff !important; */
                        transform: scale(1.06);
                    }

                    .sig-table tbody tr:hover .btn-live a {
                        color: #fff !important;
                    }

                    /* Cells */
                    .sig-table tbody td {
                    padding: 13px 20px;
                    text-align: center;
                    border-top: 1px solid #666;
                    white-space: nowrap;
                    font-size: 1rem;
                    font-weight: 500;
                    letter-spacing: 0.02em;
                    vertical-align: middle;
                    }

                    /* Cell colour roles */
                    .c-date   { color: #000; font-weight: 600; }
                    .c-pair   { color: #000; font-weight: 600; letter-spacing: 0.06em; }
                    .c-entry  { color: #000; }
                    .c-profit { color: #000; font-weight: 700; font-size: 0.92rem; }
                    .c-zero   { color: var(--text-muted); font-weight: 600; }

                    /* Faded row overrides */
                    .row-faded .c-date,
                    .row-faded .c-pair,
                    .row-faded .c-entry {
                        color: #000;
                    }

                    /* Order badges */
                    .badge-order {
                        display: inline-block;
                        padding: 3px 16px;
                        border-radius: 3px;
                        /* font-weight: 700; */
                        font-size: 1rem;
                        letter-spacing: 0.1em;
                        text-transform: uppercase;
                    }
                    .badge-sell {
                        color: #000;
                        background: #fff;
                        /* border: 1px solid #000; */
                    }
                    .badge-buy {
                    color: #000;
                    background: #fff;
                    /* border: 1px solid #000; */
                    }
                    /* .row-faded .badge-sell, .row-faded .badge-buy { opacity: 0.38; } */

                    /* SL | TP */
                    .sl  {
                         color: #000;
                    }
                    .tp  {
                        color: #000;
                     }
                    .sep { color: var(--text-muted); margin: 0 5px; }
                    .row-faded .sl,
                    .row-faded .tp { opacity: 0.4; }

                    /* Live Proof button */
                    .btn-live {
                    display: inline-block;
                    padding: 6px 16px;
                    background: #fff;
                    /* color: #000; */
                    border: 1px solid #000;
                    border-radius: 5px;
                    font-weight: 700;
                    font-size: 0.72rem;
                    letter-spacing: 0.1em;
                    text-transform: uppercase;
                    cursor: pointer;
                    transition: background 0.18s ease, box-shadow 0.18s ease, transform 0.14s ease;
                    white-space: nowrap;
                    }

                    /* Row entrance animation */
                    @keyframes fadeUp {
                    from { opacity: 0; transform: translateY(8px); }
                    to   { opacity: 1; transform: translateY(0); }
                    }
                    .sig-table tbody tr { animation: fadeUp 0.4s ease both; }
                    .sig-table tbody tr:nth-child(1)  { animation-delay: .04s; }
                    .sig-table tbody tr:nth-child(2)  { animation-delay: .08s; }
                    .sig-table tbody tr:nth-child(3)  { animation-delay: .12s; }
                    .sig-table tbody tr:nth-child(4)  { animation-delay: .16s; }
                    .sig-table tbody tr:nth-child(5)  { animation-delay: .20s; }
                    .sig-table tbody tr:nth-child(6)  { animation-delay: .24s; }
                    .sig-table tbody tr:nth-child(7)  { animation-delay: .28s; }
                    .sig-table tbody tr:nth-child(8)  { animation-delay: .32s; }
                    .sig-table tbody tr:nth-child(9)  { animation-delay: .36s; }
                    .sig-table tbody tr:nth-child(10) { animation-delay: .40s; }
                    .sig-table tbody tr:nth-child(11) { animation-delay: .44s; }
                    .sig-table tbody tr:nth-child(12) { animation-delay: .48s; }
                    .sig-table tbody tr:nth-child(13) { animation-delay: .52s; }
                    .sig-table tbody tr:nth-child(14) { animation-delay: .56s; }
                    .sig-table tbody tr:nth-child(15) { animation-delay: .60s; }

                    /* Responsive */
                    @media (max-width: 900px) {
                    .tbl-wrap { overflow-x: auto; }
                    .sig-table { min-width: 720px; }
                    }

                    .c-profit {
                        color: green;
                    }

                    .c-loss {
                        color: red;
                    }

                    .c-zero {
                        color: #666; /* or any neutral color */
                    }
                </style>

                 <div class="tbl-wrap">

                    <table class="sig-table">

                        <thead>
                            <tr>
                            <th>Date</th>
                            <th>Pair</th>
                            <th>Order</th>
                            <th class="">Profit</th>
                            <th>Live</th>
                            </tr>
                        </thead>

                        <tbody>
                                @forelse($signals as $signal)
                                    <tr class="{{ $signal->profit == 0 ? 'row-faded' : '' }} redirect-tg-channel" data-link-url="{{ $signal->live_btn_url }}">

                                        {{-- Signal Date --}}
                                        <td class="c-date">
                                            {{ \Carbon\Carbon::parse($signal->signal_date)->format('d M y') }}
                                        </td>

                                        {{-- Pair --}}
                                        <td class="c-pair">
                                            {{ $signal->pair }}
                                        </td>

                                        {{-- Order Type --}}
                                        <td>
                                            <span class="badge-order {{ $signal->order_type == 0 ? 'badge-buy' : 'badge-sell' }}">
                                                {{ $signal->order_type == 0 ? 'BUY' : 'SELL' }}
                                            </span>
                                        </td>


                                        {{-- Profit --}}
                                        {{-- <td class="{{ $signal->profit > 0 ? 'c-profit' : 'c-zero' }}">
                                            {{ $signal->profit }}
                                        </td> --}}
                                        <td class=" {{ $signal->profit > 0 ? 'c-profit' : ($signal->profit < 0 ? 'c-loss' : 'c-zero') }}">
                                            @if ( $signal->profit)
                                                {{ $signal->profit }}
                                            @else
                                                <span style="color:var(--green);font-size: 1.4rem;">Running</span>
                                            @endif
                                        </td>

                                        {{-- Live Proof Button --}}
                                        <td>
                                            <button class="btn-live">
                                                LIVE PROOF
                                            </button>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            No Signals Found
                                        </td>
                                    </tr>
                                @endforelse
                        </tbody>

                    </table>


                </div>

    </section>
