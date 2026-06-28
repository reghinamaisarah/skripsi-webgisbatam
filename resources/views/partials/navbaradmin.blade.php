<style>
    .navbar-admin {
        position: sticky;
        top: 0;
        z-index: 100;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 2.5rem;
        height: 65px;
        background: #f5f3ee;
        border-bottom: 1px solid rgba(0,0,0,0.07);
        box-shadow: 0 2px 16px rgba(0,0,0,0.06);
        font-family: 'Poppins', sans-serif;
    }

    /* ── Brand (logo + judul) ── */
    .navbar-admin .brand {
        display: flex;
        align-items: center;
        gap: 1rem;
        text-decoration: none;
    }
    .navbar-admin .brand img {
        height: 60px;
        width: auto;
        transition: transform 0.3s;
    }
    .navbar-admin .brand:hover img {
        transform: scale(1.05) rotate(-2deg);
    }
    .navbar-admin .brand .title {
        font-family: 'Poppins', sans-serif;
        font-size: 1.10rem;
        font-weight: 600;
        color: #1a3a8f;
        letter-spacing: -0.01em;
    }

    /* ── Admin info kanan ── */
    .navbar-admin .admin-info {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-family: 'Poppins', sans-serif;
        font-size: 0.875rem;
        font-weight: 600;
        color: #233d59;
        padding: 0.5rem 0.875rem;
        border-radius: 8px;
        transition: background 0.18s, color 0.18s;
        cursor: default;
    }
    .navbar-admin .admin-info:hover {
        color: #1a3a8f;
    }
    .navbar-admin .admin-info svg {
        width: 20px;
        height: 20px;
        stroke: currentColor;
        fill: none;
        stroke-width: 1.75;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    /* ── Animasi masuk ── */
    @keyframes navSlideDown {
        from { opacity: 0; transform: translateY(-100%); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .navbar-admin { animation: navSlideDown 0.5s ease both; }

    @media (max-width: 768px) {
        .navbar-admin { padding: 0 1.25rem; height: 70px; }
        .navbar-admin .brand img { height: 48px; }
        .navbar-admin .brand .title { font-size: 1.05rem; }
    }
</style>

<nav class="navbar-admin">
    <a href="{{ route('admin.page') }}" class="brand">
        <img src="{{ asset('images/logo-biru.png') }}" alt="Logo">
        <span class="title">Kelola Data Admin</span>
    </a>

    <div class="admin-info">
        {{-- Ikon user-admin --}}
        <svg viewBox="0 0 24 24">
            <circle cx="12" cy="8" r="4"/>
            <path d="M4 21c0-4 4-7 8-7s8 3 8 7"/>
            <path d="M17 11l1.5 1.5L21 10"/>
        </svg>
        <span>{{ Auth::user()->name ?? 'Admin' }}</span>
    </div>
</nav>
