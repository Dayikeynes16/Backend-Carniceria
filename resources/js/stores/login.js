import { defineStore } from 'pinia';

export const useLoginStore = defineStore('login', {
  state: () => ({
    autenticado: localStorage.getItem('autenticado') === 'true'
  }),
  actions: {
    setAutenticado(value) {
      this.autenticado = value;
      localStorage.setItem('autenticado', value);
    }
  }
});
