@extends('frontoffice.app')

@section('content')
<section class="py-4">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-8">
        <article class="card">
          @if($actualite->image)
            <img src="{{ asset($actualite->image) }}" alt="{{ $actualite->titre }}" class="card-img-top" style="max-height:360px; object-fit:cover;">
          @endif
          <div class="card-body">
            <h1 class="h3">{{ $actualite->titre }}</h1>
            <p class="text-muted small">{{ $actualite->created_at->translatedFormat('d M Y') }}</p>
            <hr>
            <div class="content">
              {!! $actualite->contenu !!}
            </div>
          </div>
        </article>
      </div>

      <div class="col-lg-4">
        <div class="card">
          <div class="card-body">
            <h2 class="h5">Récemment</h2>
            <ul class="list-unstyled mb-0">
              @foreach($recentes as $r)
                <li class="mb-3">
                  <a href="{{ route('front.actualites.show', $r->id) }}" class="text-decoration-none">{{ $r->titre }}</a>
                  <div class="small text-muted">{{ $r->created_at->translatedFormat('d M Y') }}</div>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection
