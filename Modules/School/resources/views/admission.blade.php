<x-school::layouts.master :module="$module" :page-title="$module['label'].' · Admission en ligne'">

    {{-- ===== HERO ADMISSION ===== --}}
    <section class="hero">
        <div class="hero-grid">
            <div>
                <span class="badge">📋 Admission en ligne</span>
                <h1 class="headline">Inscrivez votre enfant en quelques clics</h1>
                <p class="muted">
                    Déposez votre dossier de pré-inscription directement en ligne.
                    Notre équipe pédagogique traitera votre demande sous 48 heures ouvrées.
                </p>
            </div>
            <div class="panel">
                <h2 style="margin-top:0;">Programmes disponibles</h2>
                <div style="display:flex; flex-direction:column; gap:.75rem;">
                    @foreach($records as $record)
                        <div style="display:flex; justify-content:space-between; align-items:center; padding:.75rem; background:rgba(255,255,255,.04); border-radius:.85rem; border:1px solid rgba(148,163,184,.12);">
                            <div>
                                <strong style="color:#e2e8f0;">{{ $record->name }}</strong>
                                <p class="muted" style="font-size:.82rem; margin:.15rem 0 0;">{{ $record->headline }}</p>
                            </div>
                            <span class="status">Ouvert</span>
                        </div>
                    @endforeach
                    @if($records->isEmpty())
                        <p class="muted" style="text-align:center; padding:1rem;">Aucun programme ouvert pour le moment.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ===== FORMULAIRE D'ADMISSION ===== --}}
    <section class="panel" style="margin-bottom:1.5rem;">
        <h2 style="margin-top:0;">Formulaire de pré-inscription</h2>
        <p class="muted" style="margin-bottom:1.5rem;">Tous les champs marqués d'un <span style="color:#f87171;">*</span> sont obligatoires.</p>

        <form method="POST" action="{{ route($module['route_prefix'].'.admission.submit') }}"
              style="display:grid; gap:1.25rem;">
            @csrf

            {{-- Informations de l'élève --}}
            <fieldset style="border:1px solid rgba(148,163,184,.18); border-radius:1rem; padding:1.25rem;">
                <legend style="color:#a5b4fc; font-weight:600; padding:0 .5rem;">👧 Informations de l'élève</legend>
                <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:1rem; margin-top:.75rem;">
                    <div>
                        <label style="display:block; margin-bottom:.4rem; color:#cbd5e1; font-size:.9rem;">Prénom <span style="color:#f87171;">*</span></label>
                        <input type="text" name="student_first_name" required
                               style="width:100%; padding:.75rem 1rem; background:rgba(15,23,42,.8); border:1px solid rgba(148,163,184,.25); border-radius:.75rem; color:#e2e8f0; font-size:.95rem; box-sizing:border-box;"
                               placeholder="Prénom de l'élève">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:.4rem; color:#cbd5e1; font-size:.9rem;">Nom <span style="color:#f87171;">*</span></label>
                        <input type="text" name="student_last_name" required
                               style="width:100%; padding:.75rem 1rem; background:rgba(15,23,42,.8); border:1px solid rgba(148,163,184,.25); border-radius:.75rem; color:#e2e8f0; font-size:.95rem; box-sizing:border-box;"
                               placeholder="Nom de famille">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:.4rem; color:#cbd5e1; font-size:.9rem;">Date de naissance <span style="color:#f87171;">*</span></label>
                        <input type="date" name="student_dob" required
                               style="width:100%; padding:.75rem 1rem; background:rgba(15,23,42,.8); border:1px solid rgba(148,163,184,.25); border-radius:.75rem; color:#e2e8f0; font-size:.95rem; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:.4rem; color:#cbd5e1; font-size:.9rem;">Sexe <span style="color:#f87171;">*</span></label>
                        <select name="student_gender" required
                                style="width:100%; padding:.75rem 1rem; background:rgba(15,23,42,.8); border:1px solid rgba(148,163,184,.25); border-radius:.75rem; color:#e2e8f0; font-size:.95rem; box-sizing:border-box;">
                            <option value="">Sélectionner</option>
                            <option value="M">Masculin</option>
                            <option value="F">Féminin</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            {{-- Programme demandé --}}
            <fieldset style="border:1px solid rgba(148,163,184,.18); border-radius:1rem; padding:1.25rem;">
                <legend style="color:#a5b4fc; font-weight:600; padding:0 .5rem;">🏫 Programme souhaité</legend>
                <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:1rem; margin-top:.75rem;">
                    <div>
                        <label style="display:block; margin-bottom:.4rem; color:#cbd5e1; font-size:.9rem;">Programme <span style="color:#f87171;">*</span></label>
                        <select name="program_id" required
                                style="width:100%; padding:.75rem 1rem; background:rgba(15,23,42,.8); border:1px solid rgba(148,163,184,.25); border-radius:.75rem; color:#e2e8f0; font-size:.95rem; box-sizing:border-box;">
                            <option value="">Choisir un programme</option>
                            @foreach($records as $record)
                                <option value="{{ $record->id }}">{{ $record->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:.4rem; color:#cbd5e1; font-size:.9rem;">Année scolaire <span style="color:#f87171;">*</span></label>
                        <select name="academic_year" required
                                style="width:100%; padding:.75rem 1rem; background:rgba(15,23,42,.8); border:1px solid rgba(148,163,184,.25); border-radius:.75rem; color:#e2e8f0; font-size:.95rem; box-sizing:border-box;">
                            <option value="{{ date('Y').'-'.(date('Y')+1) }}">{{ date('Y') }}-{{ date('Y')+1 }}</option>
                            <option value="{{ (date('Y')+1).'-'.(date('Y')+2) }}">{{ date('Y')+1 }}-{{ date('Y')+2 }}</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            {{-- Informations du parent/tuteur --}}
            <fieldset style="border:1px solid rgba(148,163,184,.18); border-radius:1rem; padding:1.25rem;">
                <legend style="color:#a5b4fc; font-weight:600; padding:0 .5rem;">👨‍👩‍👧 Parent / Tuteur légal</legend>
                <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:1rem; margin-top:.75rem;">
                    <div>
                        <label style="display:block; margin-bottom:.4rem; color:#cbd5e1; font-size:.9rem;">Nom complet <span style="color:#f87171;">*</span></label>
                        <input type="text" name="guardian_name" required
                               style="width:100%; padding:.75rem 1rem; background:rgba(15,23,42,.8); border:1px solid rgba(148,163,184,.25); border-radius:.75rem; color:#e2e8f0; font-size:.95rem; box-sizing:border-box;"
                               placeholder="Nom du parent ou tuteur">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:.4rem; color:#cbd5e1; font-size:.9rem;">Email <span style="color:#f87171;">*</span></label>
                        <input type="email" name="guardian_email" required
                               style="width:100%; padding:.75rem 1rem; background:rgba(15,23,42,.8); border:1px solid rgba(148,163,184,.25); border-radius:.75rem; color:#e2e8f0; font-size:.95rem; box-sizing:border-box;"
                               placeholder="email@exemple.com">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:.4rem; color:#cbd5e1; font-size:.9rem;">Téléphone <span style="color:#f87171;">*</span></label>
                        <input type="tel" name="guardian_phone" required
                               style="width:100%; padding:.75rem 1rem; background:rgba(15,23,42,.8); border:1px solid rgba(148,163,184,.25); border-radius:.75rem; color:#e2e8f0; font-size:.95rem; box-sizing:border-box;"
                               placeholder="+243 xxx xxx xxx">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:.4rem; color:#cbd5e1; font-size:.9rem;">Lien de parenté <span style="color:#f87171;">*</span></label>
                        <select name="guardian_relation" required
                                style="width:100%; padding:.75rem 1rem; background:rgba(15,23,42,.8); border:1px solid rgba(148,163,184,.25); border-radius:.75rem; color:#e2e8f0; font-size:.95rem; box-sizing:border-box;">
                            <option value="">Sélectionner</option>
                            <option value="père">Père</option>
                            <option value="mère">Mère</option>
                            <option value="tuteur">Tuteur légal</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                </div>
                <div style="margin-top:1rem;">
                    <label style="display:block; margin-bottom:.4rem; color:#cbd5e1; font-size:.9rem;">Message complémentaire (facultatif)</label>
                    <textarea name="message" rows="3"
                              style="width:100%; padding:.75rem 1rem; background:rgba(15,23,42,.8); border:1px solid rgba(148,163,184,.25); border-radius:.75rem; color:#e2e8f0; font-size:.95rem; resize:vertical; box-sizing:border-box;"
                              placeholder="Informations supplémentaires, besoins spéciaux, questions…"></textarea>
                </div>
            </fieldset>

            <div style="display:flex; justify-content:flex-end; gap:1rem; align-items:center; flex-wrap:wrap;">
                <a class="badge" href="{{ route($module['route_prefix'].'.home') }}">← Retour au site</a>
                <button type="submit" class="cta" style="border:none; cursor:pointer;">
                    📤 Soumettre ma demande d'admission
                </button>
            </div>
        </form>
    </section>

    {{-- ===== INFOS PRATIQUES ===== --}}
    <section class="panel">
        <h2 style="margin-top:0;">ℹ️ Informations pratiques</h2>
        <div class="card-grid">
            <article class="card">
                <strong>📅 Délai de traitement</strong>
                <p class="muted" style="font-size:.88rem;">Votre dossier est examiné sous 48 heures ouvrées. Vous recevrez une réponse par email.</p>
            </article>
            <article class="card">
                <strong>📄 Documents requis</strong>
                <p class="muted" style="font-size:.88rem;">Bulletin de l'année précédente, certificat de naissance, carte d'identité du tuteur.</p>
            </article>
            <article class="card">
                <strong>💳 Frais d'inscription</strong>
                <p class="muted" style="font-size:.88rem;">Les frais d'inscription sont à régler en ligne après acceptation du dossier via notre portail de paiement.</p>
            </article>
        </div>
    </section>

</x-school::layouts.master>
