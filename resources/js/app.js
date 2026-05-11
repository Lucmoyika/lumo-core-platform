import { createApp } from 'vue';
import AnalyticsInsights from '../../Modules/Analytics/resources/js/components/AnalyticsInsights.vue';
import CommunicationInsights from '../../Modules/Communication/resources/js/components/CommunicationInsights.vue';
import CompaniesInsights from '../../Modules/Companies/resources/js/components/CompaniesInsights.vue';
import CoreInsights from '../../Modules/Core/resources/js/components/CoreInsights.vue';
import EcommerceInsights from '../../Modules/Ecommerce/resources/js/components/EcommerceInsights.vue';
import JobsInsights from '../../Modules/Jobs/resources/js/components/JobsInsights.vue';
import LogisticsInsights from '../../Modules/Logistics/resources/js/components/LogisticsInsights.vue';
import PaymentInsights from '../../Modules/Payment/resources/js/components/PaymentInsights.vue';
import SchoolInsights from '../../Modules/School/resources/js/components/SchoolInsights.vue';
import UniversityInsights from '../../Modules/University/resources/js/components/UniversityInsights.vue';

const components = {
    'analytics-insights': AnalyticsInsights,
    'communication-insights': CommunicationInsights,
    'companies-insights': CompaniesInsights,
    'core-insights': CoreInsights,
    'ecommerce-insights': EcommerceInsights,
    'jobs-insights': JobsInsights,
    'logistics-insights': LogisticsInsights,
    'payment-insights': PaymentInsights,
    'school-insights': SchoolInsights,
    'university-insights': UniversityInsights,
};

const parseProps = (value) => {
    if (! value) {
        return {};
    }

    try {
        return JSON.parse(value);
    } catch {
        return {};
    }
};

document.querySelectorAll('[data-vue-component]').forEach((element) => {
    const componentName = element.dataset.vueComponent;
    const component = components[componentName];

    if (! component) {
        return;
    }

    const app = createApp(component, parseProps(element.dataset.props));
    app.mount(element);
});
