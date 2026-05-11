<script setup>
defineProps({
    accent: { type: String, required: true },
    title: { type: String, required: true },
    features: { type: Array, default: () => [] },
});
</script>

<template>
    <div class="insight-card" :style="{ '--accent': accent }">
        <div>
            <p class="eyebrow">Vue 3 widget</p>
            <h3>{{ title }}</h3>
            <p>Composant prêt pour charts, tables dynamiques et micro-interactions.</p>
        </div>
        <div class="stack">
            <div v-for="feature in features" :key="feature" class="pill">{{ feature }}</div>
        </div>
    </div>
</template>

<style scoped>
.insight-card { --accent:#6366f1; display:grid; gap:1rem; background:rgba(15,23,42,.88); border:1px solid rgba(148,163,184,.18); border-radius:1.25rem; padding:1.25rem; }
.eyebrow { margin:0 0 .5rem; color:#94a3b8; text-transform:uppercase; letter-spacing:.08em; font-size:.75rem; }
h3 { margin:0 0 .35rem; color:#fff; font-size:1.4rem; }
p { margin:0; color:#cbd5e1; }
.stack { display:flex; flex-wrap:wrap; gap:.6rem; }
.pill { padding:.6rem .8rem; border-radius:999px; background:color-mix(in srgb, var(--accent) 18%, #0f172a); color:#fff; border:1px solid color-mix(in srgb, var(--accent) 48%, transparent); }
</style>
