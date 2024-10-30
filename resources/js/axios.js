import axios from "axios";
import router from "@/router";

const axiosInstance = axios.create({
  withCredentials: true,
  baseURL: import.meta.env.VITE_BASE_URL
});

// Obtener el token CSRF del meta tag, si existe
const tokenMetaTag = document.querySelector("meta[name='csrf-token']");
const token = tokenMetaTag ? tokenMetaTag.getAttribute('content') : null;

console.log('este es el fokin tokwen: ', token);

axiosInstance.interceptors.request.use(
    (config) => {
        // Configurar los headers sin sobrescribir los existentes
        config.headers = {
            ...config.headers, // Mantener los headers anteriores
            Accept: "application/json",
        };

        // Si existe el token CSRF, lo agregamos a los headers
        if (token) {
            config.headers["X-CSRF-TOKEN"] = token;
        }

        return config;
    },
    (error) => {
        console.log(error.response);
        return Promise.reject(error);
    }
);

axiosInstance.interceptors.response.use(
    (response) => {
        return response;
    },
    (error) => {
        console.log(error.response);

        if (
            error.response &&
            error.response.status === 401 &&
            error.response.data.message === "Unauthenticated."
        ) {
            localStorage.removeItem("user");
            router.push({ name: 'Login' }); // Redirigir al login si es necesario
        }

        return Promise.reject(error);
    }
);

export default axiosInstance;