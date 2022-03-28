import Vue from 'vue';
import store from '../store';
import VueI18n from 'vue-i18n';

import EleUIENLocale from 'element-ui/lib/locale/lang/en.js';
import EleUICNLocale from 'element-ui/lib/locale/lang/zh-CN.js';
import EleUISWLocale from 'element-ui/lib/locale/lang/sv-SE.js';
import ElementLocale from 'element-ui/lib/locale';

Vue.use(VueI18n);

const languages = {
	en: { 
		...EleUIENLocale
	},
	zh: { 
		...EleUICNLocale
	},
	sw: { 
		...EleUISWLocale
	}
};

const i18n = new VueI18n({
	locale: store.state.u_lang || 'en',
	languages
});

ElementLocale.i18n((key, value) => i18n.t(key, value));

export default i18n