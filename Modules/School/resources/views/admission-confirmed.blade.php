<x-school::layouts.master :module="$module" :page-title="$module['label'].' · Demande envoyée'">

    <section class="hero" style="text-align:center;">
        <div style="font-size:4rem; margin-bottom:1rem;">✅</div>
        <span class="badge" style="margin-bottom:.75rem;">Confirmation</span>
        <h1 class="headline">Votre demande a bien été reçue !</h1>
        <p class="muted" style="max-width:520px; margin:0 auto 1.5rem;">
            Merci pour votre intérêt pour <strong style="color:#fff;">{{ $module['label'] }}</strong>.
            Notre équipe pédagogique examinera votre dossier et vous contactera par email sous 48 heures ouvrées.
        </p>
        <div style="display:flex; justify-content:center; gap:.75rem; flex-wrap:wrap;">
            <a class="cta" href="{{ route($module['route_prefix'].'.home') }}">← Retour au site</a>
            <a class="badge" href="{{ route($module['route_prefix'].'.portal') }}">🔐 Accéder au portail</a>
        </div>
    </section>

    <section class="panel" style="margin-bottom:1.5rem;">
        <h2 style="margin-top:0;">Prochaines étapes</h2>
        <div class="card-grid">
            <article class="card" style="text-align:center;">
                <div style="font-size:1.8rem; margin-bottom:.5rem;">📧</div>
                <strong>Email de confirmation</strong>
                <p class="muted" style="font-size:.88rem;">Un email de confirmation vous a été envoyé avec le récapitulatif de votre demande.</p>
            </article>
            <article class="card" style="text-align:center;">
                <div style="font-size:1.8rem; margin-bottom:.5rem;">📋</div>
                <strong>Examen du dossier</strong>
                <p class="muted" style="font-size:.88rem;">Notre équipe pédagogique examine votre dossier sous 48 h et vous contacte pour la suite.</p>
            </article>
            <article class="card" style="text-align:center;">
                <div style="font-size:1.8rem; margin-bottom:.5rem;">💳</div>
                <strong>Confirmation &amp; paiement</strong>
                <p class="muted" style="font-size:.88rem;">En cas d'acceptation, réglez les frais d'inscription via notre portail sécurisé.</p>
            </article>
        </div>
    </section>

</x-school::layouts.master>
