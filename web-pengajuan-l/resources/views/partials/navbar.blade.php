<div class="sidebar">
    <h2>Sistem Keluhan & Saran</h2>
    <ul>
        {{-- Ganti semua link PHP murni dengan route atau url Laravel --}}
        <li><a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard*') ? 'active' : '' }}">Dashboard</a></li>
        <li><a href="{{ url('/Keluhan') }}" class="{{ request()->is('Keluhan*') ? 'active' : '' }}">Keluhan Baru</a></li>
        <li><a href="{{ url('/saran') }}" class="{{ request()->is('saran*') ? 'active' : '' }}">Saran Baru</a></li>
        <li><a href="{{ url('/profil') }}" class="{{ request()->is('profil*') ? 'active' : '' }}">Profil</a></li>
    </ul>
    <a href="{{ url('/logout') }}" class="logout-btn">Logout</a>
</div>