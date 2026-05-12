const descriptions = {
    'core-insights': 'Vue transversale du noyau plateforme et des modules activés.',
};

const escapeHtml = (value) => String(value ?? '')
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;')
    .replaceAll("'", '&#39;');

const parseProps = (value) => {
    if (!value) {
        return {};
    }

    try {
        return JSON.parse(value);
    } catch {
        return {};
    }
};

const renderInsightsWidget = (element) => {
    const componentName = element.dataset.insightsComponent;
    const { accent = '#6366f1', title = 'Module', features = [] } = parseProps(element.dataset.props);
    const description = descriptions[componentName] ?? 'Bloc interactif prêt pour charts, tableaux dynamiques et micro-interactions.';

    const pills = Array.isArray(features)
        ? features.map((feature) => `<div class="insights-pill">${escapeHtml(feature)}</div>`).join('')
        : '';

    element.classList.add('insights-card');
    element.style.setProperty('--accent', accent);
    element.innerHTML = `
        <div>
            <p class="insights-eyebrow">Lumo widget</p>
            <h3 class="insights-title">${escapeHtml(title)}</h3>
            <p class="insights-description">${escapeHtml(description)}</p>
        </div>
        <div class="insights-stack">${pills}</div>
    `;
};

document.querySelectorAll('[data-insights-component]').forEach(renderInsightsWidget);
