
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'
import colors from 'vuetify/util/colors';
import { es } from 'vuetify/locale'

export const vuetify = createVuetify({
  locale: {
    locale: 'es',
    fallback: 'en',
    messages: { es },
  },
  components,
  directives,
  theme: {
    defaultTheme: 'light',
    themes: {
      light: {
        dark: false,
        colors: {
          primary: '#FF8343',
          secondary: '#FF165D',
          accent: '#88A61C',
          'primary-background': '#F4F9F9'
        }
      }
    }
  },
  defaults: {
    VBtn: {
      color: 'secondary',
      variant: 'outlined'
    }
  },
  
})