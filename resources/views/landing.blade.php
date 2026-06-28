@extends('layouts.app')

@section('content')

    @include('partials.hero')

    @include('partials.about')

    @include('partials.features')

    @include('partials.cta')

@endsection

@push('scripts')
<script>
    {{-- Scroll fade-in untuk semua elemen .fade-up --}}
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('visible');
                }, i * 80);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

    {{-- Smooth scroll untuk anchor link --}}
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
</script>
@endpush