@extends('layouts.app')

@section('title', 'Contact — ÉCLORIA')

@section('content')
<div class="container py-5">
    <div class="section-title">
        <h2>Contactez-nous</h2>
    </div>

    <div class="row g-5">
        {{-- Form --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('contact.send') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nom complet *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Sujet *</label>
                            <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" required>
                            @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Message *</label>
                            <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="5" required>{{ old('message') }}</textarea>
                            @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-ecloria-primary mt-3">
                        <i class="bi bi-send me-2"></i> Envoyer le message
                    </button>
                </form>
            </div>
        </div>

        {{-- Info --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm p-4 mb-4">
                <h5 class="mb-3" style="font-family: 'Playfair Display', serif;">Nos coordonnées</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-3"><i class="bi bi-geo-alt text-ecloria-rose me-2"></i> 123 Bd Zerktouni, Casablanca</li>
                    <li class="mb-3"><i class="bi bi-telephone text-ecloria-rose me-2"></i> +212 5 22 12 34 56</li>
                    <li class="mb-3"><i class="bi bi-envelope text-ecloria-rose me-2"></i> contact@ecloria.ma</li>
                    <li><i class="bi bi-clock text-ecloria-rose me-2"></i> Lun - Sam : 9h - 19h</li>
                </ul>
            </div>

            <div class="card border-0 shadow-sm p-4">
                <h5 class="mb-3" style="font-family: 'Playfair Display', serif;">Suivez-nous</h5>
                <div class="d-flex gap-3">
                    <a href="#" class="text-ecloria-rose fs-4"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-ecloria-rose fs-4"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-ecloria-rose fs-4"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
