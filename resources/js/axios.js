import axios from "axios";

// Get the CSRF token from the meta tag in your HTML template
const csrfToken = document.querySelector("meta[name='csrf-token']")?.getAttribute("content");

// Create an Axios instance
const axiosInstance = axios.create({
    baseURL: import.meta.env.VITE_BASE_URL, // Your backend base URL
    withCredentials: true, // Required for session-based authentication
});

// Add a request interceptor to include the CSRF token in the headers
axiosInstance.interceptors.request.use(
    (config) => {
        config.headers = {
            ...config.headers,
            "X-CSRF-TOKEN": csrfToken, // Attach the CSRF token
            "Accept": "application/json", // Specify response type
        };
        return config;
    },
    (error) => {
        console.error("Request Error:", error);
        return Promise.reject(error);
    }
);

// Add a response interceptor to handle errors globally
axiosInstance.interceptors.response.use(
    (response) => response,
    (error) => {
        console.error("Response Error:", error.response || error);
        if (
            error.response &&
            error.response.status === 401 &&
            error.response.data.message === "Unauthenticated."
        ) {
            // Handle unauthenticated state (optional)
            localStorage.removeItem("user"); // Clear user data if necessary
        }
        return Promise.reject(error);
    }
);

export default axiosInstance;
